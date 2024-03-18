<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use Auth;
use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;

class ClientsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        $clients=Client::where('owner_id', auth()->user()->id)->get();
        return view('clients')->with('clients', $clients);
    }

    public function create() {
        return view('clients_create');
    }

    public function store(ClientStoreRequest $request) {
        $validated = $request->validated();
        
        $client=new Client;
        $client->owner_id=auth()->user()->id;
        $client->client_name=$validated["client_name"];
        $client->client_street=$validated["client_street"];
        $client->client_city=$validated["client_city"];
        $client->client_email=$validated["client_email"];
        $client->client_nip=$validated["client_nip"];
        $client->client_house_number=$validated["client_house_number"];
        $client->client_postcode=$validated["client_postcode"];
        $client->client_phone=$validated["client_phone"];
        
        $client->save();

        return redirect(route('clients'))->with('success', 'Klient dodany');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients_edit')->with('client',$client);
    }

    public function update(ClientStoreRequest $request)
    {
        $validated = $request->validated();
        $client = Client::find($request->id);
        $client->client_name=$validated["client_name"];
        $client->client_street=$validated["client_street"];
        $client->client_city=$validated["client_city"];
        $client->client_email=$validated["client_email"];
        $client->client_nip=$validated["client_nip"];
        $client->client_house_number=$validated["client_house_number"];
        $client->client_postcode=$validated["client_postcode"];
        $client->client_phone=$validated["client_phone"];
        
        $client->save();
        return redirect(route('clients'))->with('success', 'Klient dodany');
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect('/clients');
    }

    public function dataFromApi(Request $request)
    {
        $apiFoundData = new Client;
        
        $nipForApi = $request->get('nip');
        $apiFoundData->client_nip = $nipForApi;
        $nipForApi = preg_replace("/[^0-9]/", "", $nipForApi);
        $gus = new GusApi('b666914c9b084287ac4b');

        try {
            $nipToCheck = $nipForApi;
            $gus->login();
            $gusReports = $gus->getByNip($nipToCheck);
            if($gusReports)
            {
                $gusReport = $gusReports[0];
                $apiFoundData->client_name = $gusReport->getName();
                if($gusReport->getCity() == $gusReport->getPostCity()) $apiFoundData->client_street = $gusReport->getStreet();
                else $apiFoundData->client_street = $gusReport->getCity().' '.$gusReport->getStreet();
                if($gusReport->getApartmentNumber() != "") $apiFoundData->client_house_number = $gusReport->getPropertyNumber().'/'.$gusReport->getApartmentNumber();
                else $apiFoundData->client_house_number = $gusReport->getPropertyNumber();
                $apiFoundData->client_city = $gusReport->getPostCity();
                $apiFoundData->client_postcode = $gusReport->getZipCode();
            }
        } catch (InvalidUserKeyException $e) {
            $apiFoundData->client_name = "Błąd!";
        } catch (NotFoundException $e) {
            $apiFoundData->client_name = "Nie znaleziono";
        }
        catch (\Exception $e) {
            $apiFoundData->client_name = "Coś poszło nie tak";
        }

        return view('clients_create')->with(['client' => $apiFoundData]);
    }
}
