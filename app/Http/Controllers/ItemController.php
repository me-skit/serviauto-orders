<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Price;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        $items = Item::paginate(10);

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_item = $request->validate([
            'description' => 'required'
        ]);

        $data_price = $request->validate([
            'cost' => ['nullable', 'regex:/^\d+(\.\d{1,})?$/'],
            'sell_price' => ['required', 'regex:/^\d+(\.\d{1,})?$/']
        ]);

        $item = Item::create($data_item);

        $data_price['item_id'] = $item->id;
        Price::create($data_price);

        return redirect('/items');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Item $item)
    {
        $latest_price = $item->latestPrice;
        $action = $request->get('action') ? $request->get('action') : null;
        return view('items.edit', compact('item', 'latest_price', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $data_item = $request->validate([
            'description' => 'required'
        ]);

        $data_price = $request->validate([
            'cost' => ['nullable', 'regex:/^\d+(\.\d{1,})?$/'],
            'sell_price' => ['required', 'regex:/^\d+(\.\d{1,})?$/']
        ]);

        $item->fill($data_item);
        $item->save();

        $latest_price = $item->latestPrice;
        if ($request->get('action') and $latest_price->sell_price != $data_price['sell_price'])
        {
            $data_price['item_id'] = $item->id;
            Price::create($data_price);
            return redirect('/items');
        }

        $latest_price->fill($data_price);
        $latest_price->save();

        return redirect('/items');
    }
}
