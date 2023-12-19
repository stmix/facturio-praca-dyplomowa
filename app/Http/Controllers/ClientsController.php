<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use Auth;

class ClientsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        return view('clients');
    }

    public function create() {
        return view('clients_create');
    }

    public function store(ClientStoreRequest $request) {
        $validated = $request->validated();
        
        $client=new Client;
        $client->owner_id=Auth::id();
        $client->client_name=$validated["client_name"];
        $client->client_street=$validated["client_street"];
        $client->client_city=$validated["client_city"];
        $client->client_email=$validated["client_email"];
        $client->client_nip=$validated["client_nip"];
        $client->client_house_number=$validated["client_house_number"];
        $client->client_postcode=$validated["client_postcode"];
        $client->client_phone=$validated["client_phone"];
        
        $client->save();

        return redirect('/clients')->with('success', 'Klient dodany');
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect('/clients');
    }
}
