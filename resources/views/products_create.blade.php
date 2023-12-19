<?php 
    $_SESSION['open']='products';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../invoice_app/css/style.css">
    <link rel="stylesheet" href="../invoice_app/css/style_m.css">
</head>
<body>
@include('navbar');
    <div class="page" >
        <h1>Dodaj nowy produkt</h1>
        <form method="POST" action=" {{route('products.store')}} " id="invoice_add_form">
            @csrf
            <div id="new_invoice_row">
                <div style="flex: 4;" class="new_invoice"> 
                    <header class="new_invoice_header">Produkt</header>
                    <div class="new_invoice_main">
                        <div class="invoice_form_row">
                            <div class="invoice_form_column_in_row" style="flex:1;">
                                <label class="input_text_label" for="product_name">Nazwa produktu</label><br/>
                                <input value="{{ old('product_name') }}" name="product_name" class="input_text" id="product_name" type="text" placeholder="Wprowadź nazwę produktu..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('product_name'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('product_name') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="product_price">Cena za sztukę</label><br/>
                                <input value="{{ old('product_price') }}" name="product_price" class="input_text" id="product_price" type="text" placeholder="Cena..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('product_price'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('product_price') }}
                                        </span>
                                        @endif
                                    </div>
                                <label class="input_text_label" for="producent">Producent</label><br/>
                                <input value="{{ old('producent') }}" name="producent" class="input_text" id="producent" type="text" placeholder="Nazwa producenta..."/>
                                <div class="input_separator">
                                        @if ($errors->has('producent'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('producent') }}
                                        </span>
                                        @endif
                                </div>
                                <label class="input_text_label" for="product_info">Uwagi dodatkowe</label><br/>
                                <input value="{{ old('product_info') }}" name="product_info" class="input_text" id="product_info" type="text" placeholder="Uwagi..."/><br/>
                                <div class="input_separator">
                                        @if ($errors->has('product_info'))
                                        <span class="alert_form" role="alert">
                                            {{ $errors->first('product_info') }}
                                        </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new_invoice">
                <button id="submit_invoice_form" type="submit" class="new_invoice_main">Dodaj produkt</div>
            </div>
        </form>
    </div>
</body>
</html>