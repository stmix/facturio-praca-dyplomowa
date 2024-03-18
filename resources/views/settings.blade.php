<?php
    $_SESSION['open']='settings';
    $userid = Auth::id();
    // $settings=(DB::select("select * from settings where id='$userid'"))[0];
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
        <h1 class="text-4xl">Ustawienia</h1>
        <form method="POST" action=" {{route('settings.store')}} " id="invoice_add_form">
            @csrf
            <div id="new_invoice_row">
                <div style="flex: 4;" class="new_invoice"> 
                    <header class="new_invoice_header">
                        <div style="margin: 0px 50px; display:flex; justify-content: space-between;" class="flex">
                            <div>Twoje dane do faktury</div>
                            <div>
                                <button type="button" class="hover:bg-white bg-zinc-300 hover:text-zinc-700 font-thin text-black border border-zinc-500 hover:border-transparent rounded text-xs px-1" onclick="window.location='{{ route('settings.api', ['nip' => '']) }}' + document.getElementById('nip').value">
                                    Wyszukaj po numerze NIP
                                </button>
                            </div>
                        </div>
                    </header>
                    <div class="new_invoice_main">
                        <div class="invoice_form_row">
                            <div class="invoice_form_column_in_row" style="flex:1;">
                                <label class="input_text_label" for="fullname">Imię i nazwisko (nazwa)</label><br/>
                                <input value="{{ $settings->name }}" name="name" class="input_text" id="fullname" type="text" placeholder="Nazwa..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('name'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('name') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="street">Ulica</label><br/>
                                <input value="{{ $settings->street }}" name="street" class="input_text" id="street" type="text" placeholder="Ulica..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('street'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('street') }}
                                        </span>
                                        @endif
                                    </div>
                                <label class="input_text_label" for="town">Miasto</label><br/>
                                <input value="{{ $settings->city }}" name="city" class="input_text" id="town" type="text" placeholder="Miasto"/>
                                <div class="input_separator">
                                        @if ($errors->has('city'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('city') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="fullname">E-mail</label><br/>
                                <input value="{{ $settings->email }}" name="email" class="input_text" id="fullname" type="text" placeholder="Adres e-mail..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('email'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('email') }}
                                        </span>
                                        @endif
                                </div>
                            </div>
                            <div style="min-width:5%;"></div>
                            <div class="invoice_form_column_in_row" style="flex:1;">
                                <label class="input_text_label" for="nip">NIP</label><br/>
                                <input value="{{ $settings->nip }}" name="nip" class="input_text" id="nip" type="text" placeholder="NIP..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('nip'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('nip') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="number">Numer domu</label><br/>
                                <input value="{{ $settings->house_number }}" name="house_number" class="input_text" id="number" type="text" placeholder="Nr domu..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('house_number'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('house_number') }}
                                        </span>
                                        @endif
                                    </div>
                                <label class="input_text_label" for="zip">Kod pocztowy</label><br/>
                                <input value="{{ $settings->postcode }}" name="postcode" class="input_text" id="zip" type="text" placeholder="Kod pocztowy..."/>
                                <div class="input_separator">
                                        @if ($errors->has('postcode'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('postcode') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="phone">Nr telefonu</label><br/>
                                <input value="{{ $settings->phone }}" name="phone" class="input_text" id="phone" type="text" placeholder="Nr telefonu..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('phone'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('phone') }}
                                        </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new_invoice">
                <button id="submit_invoice_form" type="submit" class="new_invoice_main">Aktualizuj dane</div>
            </div>
        </form>
    </div>
    
</body>
</html>