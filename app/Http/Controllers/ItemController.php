<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\ItemRequest;
use Illuminate\Database\QueryException;

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
        $items = Item::paginate(35);

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
     * @param  \App\Http\Requests\ItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $data = $request->validated();
        Item::create($data);

        return redirect('/items');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, Item $item)
    {
        $data = $request->validated();
        $item->fill($data);
        $item->save();

        return redirect('/items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
        } catch (QueryException $e) {
            return redirect('/items')->with('error','Datos de repuesto/servicio no pudo eliminarse, error desconocido.');
        }

        return redirect('/items')->with('info','Datos de "' . $item->description . '" eliminado.');
    }
}
