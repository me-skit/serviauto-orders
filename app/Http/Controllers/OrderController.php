<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('client')
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        $last_order = Order::latest()->first();
        $order_number = $last_order ? $last_order->id + 1 : 1;

        $items_list = Item::with('latestPrice')->get();

        return view('orders.create', compact('clients', 'order_number', 'items_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order_data = $request->validate([
            'client_id' => 'required',
            'car_description' => 'required'
        ]);

        $order = Order::create($order_data);

        $items_order = $request->input('items_order');
        $order->items()->sync($items_order);

        return redirect('/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $clients = Client::all();

        $items_list = Item::with('latestPrice')->get();

        return view('orders.edit', compact('order', 'clients', 'items_list'));
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
        $order_data = $request->validate([
            'client_id' => 'required',
            'car_description' => 'required'
        ]);

        $order->fill($order_data);
        $order->save();

        $items_order = $request->input('items_order');
        $order->items()->sync($items_order);

        return redirect('/orders');
    }
}
