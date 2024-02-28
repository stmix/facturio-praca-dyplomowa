<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsStoreRequest;
use DB;
use App\Models\Settings;
use Auth;
use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;

class SettingsController extends Controller
{
    public $settings;
    public function index() {
        $settings=Settings::where('id', auth()->user()->id)->first();
        return view('settings')->with(['settings' => $settings]);
    }

    public function store(SettingsStoreRequest $request) {
        $validated = $request->validated();

        Settings::where('id',auth()->user()->id)->update(array(
            'name'=>$validated["name"],
            'street'=>$validated["street"],
            'city'=>$validated["city"],
            'email'=>$validated["email"],
            'nip'=>$validated["nip"],
            'house_number'=>$validated["house_number"],
            'postcode'=>$validated["postcode"],
            'phone'=>$validated["phone"],
        ));

        return redirect('/settings')->with('success', 'Klient dodany');
    }

    public function dataFromApi(Request $request)
    {
        $apiFoundData = new Settings;
        
        $nipForApi = $request->get('nip');
        $apiFoundData->nip = $nipForApi;
        $nipForApi = preg_replace("/[^0-9]/", "", $nipForApi);
        $gus = new GusApi('b666914c9b084287ac4b');

        try {
            $nipToCheck = $nipForApi;
            $gus->login();
            $gusReports = $gus->getByNip($nipToCheck);
            if($gusReports)
            {
                $gusReport = $gusReports[0];
                $apiFoundData->name = $gusReport->getName();
                if($gusReport->getCity() == $gusReport->getPostCity()) $apiFoundData->street = $gusReport->getStreet();
                else $apiFoundData->street = $gusReport->getCity().' '.$gusReport->getStreet();
                if($gusReport->getApartmentNumber() != "") $apiFoundData->house_number = $gusReport->getPropertyNumber().'/'.$gusReport->getApartmentNumber();
                else $apiFoundData->house_number = $gusReport->getPropertyNumber();
                $apiFoundData->city = $gusReport->getPostCity();
                $apiFoundData->postcode = $gusReport->getZipCode();
            }
        } catch (InvalidUserKeyException $e) {
            $apiFoundData->name = "Błąd!";
        } catch (NotFoundException $e) {
            $apiFoundData->name = "Nie znaleziono";
        }
        catch (\Exception $e) {
            $apiFoundData->name = "Coś poszło nie tak";
        }

        return view('settings')->with(['settings' => $apiFoundData]);
    }
}
