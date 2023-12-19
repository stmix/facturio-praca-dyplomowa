<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsStoreRequest;
use DB;
use App\Models\Settings;
use Auth;

class SettingsController extends Controller
{
    public function index() {
        return view('settings');
    }

    public function store(SettingsStoreRequest $request) {
        $validated = $request->validated();
        
        // $settings=new Settings;
        // $settings->name=$validated["name"];
        // $settings->street=$validated["street"];
        // $settings->city=$validated["city"];
        // $settings->email=$validated["email"];
        // $settings->nip=$validated["nip"];
        // $settings->house_number=$validated["house_number"];
        // $settings->postcode=$validated["postcode"];
        // $settings->phone=$validated["phone"];
        
        //$settings->save();

        Settings::where('id',Auth::id())->update(array(
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
}
