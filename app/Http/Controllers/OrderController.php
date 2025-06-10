<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Item;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $code = $request->get('code');
        $client = Client::find($code);

        $last_order = Order::latest()->first();
        $order_number = $last_order ? $last_order->id + 1 : 1;

        $items_list = Item::orderBy('description')->get();

        return view('orders.create', compact('client', 'order_number', 'items_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = $request->get('code');

        $order_data = $request->validate([
            'car_id' => 'required',
            'date' => ['required', 'date']
        ]);

        $order_data['client_id'] = $code;
        $order_data['created_by'] = Auth::id();
        $order = Order::create($order_data);

        $order_items = $request->input('order_items');
        if ($order_items) {
            foreach ($order_items as $item_data) {
                if ($item_data['quantity'] == '*') {
                    $item_data['quantity'] = 1;
                    $item_data['is_service'] = 1;
                }

                $order->items()->create($item_data);
            }
        }

        // updating car info
        $car_data = $request->validate([
            'next_service' => 'nullable',
            'measure' => 'nullable'
        ]);

        if ($car_data['next_service']){
            $car_data['service_id'] = $order->id;

            $car = Car::find($order_data['car_id']);
            $car->fill($car_data);
            $car->save();
        }

        return redirect('/clients/' . $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        $code = $request->get('code');
        $tab = $request->get('tab');

        return view('orders.show', compact('order', 'code', 'tab'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order)
    {
        $code = $request->get('code');
        $tab = $request->get('tab');

        $client = Client::find($code);

        $items_list = Item::orderBy('description')->get();

        return view('orders.edit', compact('order', 'client', 'items_list', 'tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $code = $request->get('code');
        $tab = $request->get('tab');
        
        $order_data = $request->validate([
            'car_id' => 'required',
            'date' => ['required', 'date']
        ]);

        $car_data = $request->validate([
            'next_service' => 'nullable',
            'measure' => 'nullable'
        ]);

        // updating car info
        if ($car_data['next_service']) {
            $car_data['service_id'] = $order->id;

            $car = Car::find($order_data['car_id']);
            $prev_car = $order->car;

            if ($prev_car and ($prev_car->service_id != $car->service_id)) {
                $prev_car->next_service = null;
                $prev_car->service_id = null;
                $prev_car->save();
            }

            $car->fill($car_data);
            $car->save();    
        }

        // update order
        $order_data['updated_by'] = Auth::id();
        $order->fill($order_data);
        $order->save();

        // update items
        $new_items = $request->input('order_items');
        $current_items = $order->items;
        $this->UpdateItems($current_items, $new_items, $order);

        return redirect('/clients/' . $code . ($tab ? '?tab=' . $tab : ''));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, Order $order)
    {
        // update order
        $code = $request->get('code');
        $tab = $request->get('tab');

        $order_data = $request->validate([
            'finished' => ['required', 'date']
        ]);

        $order_data['updated_by'] = Auth::id();
        $order->fill($order_data);
        $order->save();

        return redirect('/clients/' . $code . ($tab ? '?tab=' . $tab : ''));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order)
    {
        $code = $request->get('code');
        if ($order->items()->count())
        {
            return redirect('/orders/' . $order->id . '?code=' . $code)->with('error', 'Orden No. ' . $order->id . 'no pudo eliminarse, tiene items asociados');
        }

        try {
            $order->delete();
        } catch (QueryException $e) {
            return redirect('/orders/' . $order->id . '?code=' . $code)->with('error','Orden No. ' . $order->id . 'no pudo eliminarse, error desconocido');
        }

        return redirect('/clients/' . $code)->with('info','Orden No. ' . $order->id . ' eliminada.');
    }

    private function UpdateItems($current_items, $new_items, $order)
    {
        $new_size = $new_items ? sizeof($new_items) : 0;
        $current_size = $current_items->count();

        $difference = $new_size - $current_size;
        if ($difference)
        {
            if ($difference < 0) {
                $this->UpdateAndDeleteRows($current_items, $new_items, $new_size);
            }
            else
            {
                $this->UpdateAndAddRows($current_items, $new_items, $current_size, $order);
            }
        }
        else
        {
            $this->UpdateRows($current_items, $new_items);
        }
    }

    private function UpdateRows($current_items, $new_items)
    {
        foreach ($current_items as $key => $item)
        {
            $this->UpdateItemData($item, $new_items[$key]);
        }
    }

    private function UpdateAndDeleteRows($current_items, $new_items, $new_size)
    {
        foreach ($current_items as $key => $item)
        {
            if ($key < $new_size)
            {
                $this->UpdateItemData($item, $new_items[$key]);
            }
            else
            {
                $item->delete();
            }
        }
    }
    
    private function UpdateAndAddRows($current_items, $new_items, $current_size, $order)
    {
        foreach ($new_items as $key => $item_data)
        {
            if ($key < $current_size)
            {
                $this->UpdateItemData($current_items[$key], $item_data);
            }
            else
            {
                if ($item_data['quantity'] == '*') {
                    $item_data['quantity'] = 1;
                    $item_data['is_service'] = 1;
                } 

                $order->items()->create($item_data);
            }
        }
    }

    private function UpdateItemData($item, $item_data)
    {
        if ($item_data['quantity'] == '*') {
            $item_data['quantity'] = 1;
            $item_data['is_service'] = 1;
        } else {
            $item_data['is_service'] = 0;
        }

        $item->fill($item_data);
        $item->save();
    }
}
