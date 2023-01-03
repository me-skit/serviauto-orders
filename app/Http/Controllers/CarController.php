<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
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

        return view('cars.create', compact('code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        $code = $request->get('code');

        $data = $request->validated();
        $data['client_id'] = $code;
        $data['created_by'] = Auth::id();
        Car::create($data);

        // return redirect(route('clients.show', $code) . '?tab=' . $tab);
        return redirect('/clients/' . $code . '?tab=cars');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Car $car)
    {
        $code = $request->get('code');

        return view('cars.edit', compact('car', 'code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CarRequest  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, Car $car)
    {
        $code = $request->get('code');

        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        $car->fill($data);
        $car->save();

        // return redirect(route('clients.show', $code) . '?tab=' . $tab);
        return redirect('/clients/' . $code . '?tab=cars');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function remove_service(Request $request, Car $car)
    {
        $code = $request->get('code');
        $order_id = $request->get('order');

        $car->next_service = null;
        $car->service_id = null;
        $car->updated_by = Auth::id();
        $car->save();

        return redirect('/orders/' . $order_id . '/edit' . '?tab=cars&code=' . $code)->with('info', 'Registro para "siguiente servicio" fue eliminado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Car $car)
    {
        $code = $request->get('code');

        if ($car->orders()->count())
        {
            return redirect('/clients/' . $code . '?tab=cars')->with('error','Datos de vehículo no puede eliminarse, se encuentra asociado a alguna orden.');
        }

        try {
            $car->delete();
        } catch (QueryException $e) {
            return redirect('/clients/' . $code . '?tab=cars')->with('error','Datos de vehículo no pudo eliminarse, error desconocido.');
        }

        return redirect('/clients/' . $code . '?tab=cars')->with('info','Datos de vehículo eliminado.');
    }
}
