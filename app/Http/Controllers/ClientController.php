<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClientRequest;
use Illuminate\Database\QueryException;

class ClientController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::with('location')->orderBy('id', 'desc')->paginate(10);

        if ($request->get('page'))
        {
            return view('clients.pagination', compact('clients'));
        }

        return view('clients.index', compact('clients'));
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
        $clients = Client::where('name', 'like', '%' . $query . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('clients.pagination', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::All();

        return view('clients.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $client = Client::create($data);

        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Client $client)
    {
        $tab = $request->get('tab');

        $active_orders = $client->orders()->with('car')->paginate(30);
        $past_orders = $client->historic()->with('car')->paginate(30);
        $car_list = $client->cars()->with('service')->paginate(30);
        $can_be_deleted = (count($active_orders) or count($past_orders) or count($car_list)) ? false : true;
        $grand_total = Order::totalByClientOrders($client->id);

        return view('clients.show', compact('client', 'tab', 'active_orders', 'past_orders', 'car_list', 'can_be_deleted', 'grand_total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $locations = Location::All();

        return view('clients.edit', compact('client', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::id();
        $client->fill($data);
        $client->save();

        return redirect()->route('clients.show', $client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if ($client->orders()->count() or $client->cars()->count())
        {
            return redirect('/clients/' . $client->id)->with('error','Datos de cliente no pueden eliminarse, cliente asociado a alguna orden o vehículo.');
        }

        try {
            $client->delete();
        } catch (QueryException $e) {
            return redirect('/clients/' . $client->id)->with('error','Datos de cliente no pudieron eliminarse, error desconocido.');
        }

        return redirect('/clients')->with('info','Datos de cliente "' . $client->name . '" eliminados.');
    }
}
