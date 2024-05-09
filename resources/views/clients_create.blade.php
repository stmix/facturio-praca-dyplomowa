<?php
    $_SESSION['open']='clients';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('navbar');
    <div class="page" >
        <h1 class="text-4xl">Dodaj nowego odbiorcę</h1>
        <form method="POST" action=" {{route('clients.store')}} " id="invoice_add_form">
            @csrf
            <div id="new_invoice_row">
                <div style="flex: 4;" class="new_invoice"> 
                    <header class="new_invoice_header">
                        <div style="margin: 0px 50px; display:flex; justify-content: space-between;" class="flex">
                            <div>Nabywca</div>
                            <div>
                                <button type="button" class="hover:bg-white bg-zinc-300 hover:text-zinc-700 font-thin text-black border border-zinc-500 hover:border-transparent rounded text-xs px-1" onclick="window.location='{{ route('clients.api', ['nip' => '']) }}' + document.getElementById('nip').value">
                                    Wyszukaj po numerze NIP
                                </button>
                            </div>
                        </div>
                    </header>
                    
                    <div class="new_invoice_main">
                        <div class="invoice_form_row">
                            <div class="invoice_form_column_in_row" style="flex:1;">
                                <label class="input_text_label" for="fullname">Imię i nazwisko (nazwa)</label><br/>
                                <input value="{{ $client->client_name ?? old('client_name') }}" name="client_name" class="input_text" id="fullname" type="text" placeholder="Nazwa adresata..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('client_name'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_name') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="street">Ulica</label><br/>
                                <input value="{{ $client->client_street ?? old('client_street') }}" name="client_street" class="input_text" id="street" type="text" placeholder="Ulica..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('client_street'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_street') }}
                                        </span>
                                        @endif
                                    </div>
                                <label class="input_text_label" for="town">Miasto</label><br/>
                                <input value="{{ $client->client_city ?? old('client_city') }}" name="client_city" class="input_text" id="town" type="text" placeholder="Miasto"/>
                                <div class="input_separator">
                                        @if ($errors->has('client_city'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_city') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="fullname">E-mail</label><br/>
                                <input value="{{ $client->client_email ?? old('client_email') }}" name="client_email" class="input_text" id="email" type="text" placeholder="Adres e-mail..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('client_email'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_email') }}
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div style="min-width:5%;"></div>
                            <div class="invoice_form_column_in_row" style="flex:1;">
                                <label class="input_text_label" for="nip">NIP</label><br/>
                                <input value="{{ $client->client_nip ?? old('client_nip') }}" name="client_nip" class="input_text" id="nip" type="text" placeholder="NIP..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('client_nip'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_nip') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="number">Numer domu</label><br/>
                                <input value="{{ $client->client_house_number ?? old('client_house_number') }}" name="client_house_number" class="input_text" id="number" type="text" placeholder="Nr domu..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('client_house_number'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_house_number') }}
                                        </span>
                                        @endif
                                    </div>
                                <label class="input_text_label" for="zip">Kod pocztowy</label><br/>
                                <input value="{{ $client->client_postcode ?? old('client_postcode') }}" name="client_postcode" class="input_text" id="zip" type="text" placeholder="Kod pocztowy..."/>
                                <div class="input_separator">
                                        @if ($errors->has('client_postcode'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_postcode') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="phone">Nr telefonu</label><br/>
                                <input value="{{ $client->client_phone ?? old('client_phone') }}" name="client_phone" class="input_text" id="phone" type="text" placeholder="Nr telefonu..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('client_phone'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('client_phone') }}
                                        </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new_invoice">
                <button id="submit_invoice_form" type="submit" class="new_invoice_main">Dodaj odbiorcę</div>
            </div>
        </form>
    </div>
    
</body>
</html>