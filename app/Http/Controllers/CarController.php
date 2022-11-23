<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;
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
}
