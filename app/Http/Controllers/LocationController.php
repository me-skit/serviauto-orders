<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class LocationController extends Controller
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
    public function index(Request $request)
    {
        $locations = Location::orderBy('location')->paginate(10);

        if ($request->get('page'))
        {
            return view('locations.pagination', compact('locations'));
        }

        return view('locations.index', compact('locations'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = str_replace(" ", "%", $request->get('query'));
        $locations = Location::where('location', 'like', '%' . $query . '%')
                        ->orderBy('location')
                        ->paginate(10);

        return view('locations.pagination', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        Location::create($data);

        return redirect('/locations')
            ->with('success', 'Nuevo taller agregado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LocationRequest  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, Location $location)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::id();
        $location->fill($data);
        $location->save();

        return redirect('/locations')
            ->with('success', 'Taller actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        try {
            $location->delete();
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect('/locations')->with('error', 'Datos de taller no pudo eliminarse, ya que tiene clientes asociados.');
            }

            return redirect('/locations')->with('error','Datos de taller no pudo eliminarse, error desconocido.');
        }

        return redirect('/locations')->with('info','Datos de taller "' . $location->location . ", " . $location->address . '" eliminados.');
    }
}
