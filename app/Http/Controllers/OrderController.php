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
        $order_items = $request->input('order_items');
        $items = $order->items;
        $this->UpdateItems($items, $order_items, $order);

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

    private function UpdateItems($items, $order_items, $order)
    {
        $new_size = $order_items ? sizeof($order_items) : 0;
        $old_size = $items->count();

        $difference = $new_size - $old_size;
        if ($difference)
        {
            if ($difference < 0) {
                $this->UpdateAndDelete($items, $order_items, $new_size);
            }
            else
            {
                $this->UpdateAndCreate($items, $order_items, $old_size, $order);
            }
        }
        else
        {
            $this->UpdateSame($items, $order_items);
        }
    }

    private function UpdateSame($items, $order_items)
    {
        foreach ($items as $key => $item)
        {
            $item->fill($order_items[$key]);
            $item->save();
        }
    }

    private function UpdateAndDelete($items, $order_items, $new_size)
    {
        foreach ($items as $key => $item)
        {
            if ($key < $new_size)
            {
                $item->fill($order_items[$key]);
                $item->save();
            }
            else
            {
                $item->delete();
            }
        }
    }
    
    private function UpdateAndCreate($items, $order_items, $old_size, $order)
    {
        foreach ($order_items as $key => $item_data)
        {
            if ($key < $old_size)
            {
                $items[$key]->fill($item_data);
                $items[$key]->save();
            }
            else
            {
                $order->items()->create($item_data);
            }
        }
    }
}
