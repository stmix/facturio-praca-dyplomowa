<div class="page" id="new_invoice_page" style="margin-right: 20px;">
    <?php
    $_SESSION['open'] = 'invoices';

    use Illuminate\Support\Facades\DB;

    $userid = auth()->id();
    $products = DB::select("select * from products where owner_id='$userid'");
    $clients = DB::select("select * from clients where owner_id='$userid'");
    $settings = DB::select("select * from settings where id='$userid'");
    ?>
    <form method="POST" action=" {{route('invoices.store')}} " id="invoice_add_form">
        @csrf
        <h1>Nowa faktura</h1>
        <div class="new_invoice">
            <header class="new_invoice_header">Wybierz typ faktury:</header>
            <div class="new_invoice_main">
                <div class="invoice_type">
                    <div class="invoice_ispaid">
                        <input name="ispaid" id="ispaid" class="product_input" type="checkbox">
                        <label id="ispaid_label" for="ispaid"><i class="fa fa-check"></i>Opłacona</label></input>
                    </div>
                    <hr>
                    <div class="invoice_date">
                        <i class="fa fa-calendar"></i><span style="padding-right: 7px">Płatność od:</span>
                        <input name="paid_from" type="date" class="product_input" value="<?php
                                                                                            $date = new DateTime();
                                                                                            $date->modify("+1 day");
                                                                                            $date->modify("-1 day");
                                                                                            echo $date->format("Y-m-d");
                                                                                            ?>">
                    </div>
                    <hr>
                    <div class="invoice_date">
                        <i class="fa fa-calendar"></i><span style="padding-right: 7px">Płatność do:</span>
                        <input name="paid_to" type="date" class="product_input" value="<?php
                                                                                        $date = new DateTime();
                                                                                        $date->modify("+14 day");
                                                                                        echo $date->format("Y-m-d");
                                                                                        ?>">
                    </div>
                </div>
            </div>
        </div>
        <script type='text/javascript'>
            function importYourData() {
                try {
                    document.getElementById('seller_name').value = '<?php echo $settings[0]->name; ?>';
                    document.getElementById('seller_street').value = '<?php echo $settings[0]->street; ?>';
                    document.getElementById('seller_city').value = '<?php echo $settings[0]->city; ?>';
                    document.getElementById('seller_email').value = '<?php echo $settings[0]->email; ?>';

                    document.getElementById('seller_nip').value = '<?php echo $settings[0]->nip; ?>';
                    document.getElementById('seller_house_number').value = '<?php echo $settings[0]->house_number; ?>';
                    document.getElementById('seller_postcode').value = '<?php echo $settings[0]->postcode; ?>';
                    document.getElementById('seller_phone').value = '<?php echo $settings[0]->phone; ?>';
                } catch (error) {
                    alert(error);
                }
                //document.getElementById('product_name'+ijk).value = document.getElementById('select_product'+ijk).options[document.getElementById('product_name'+ijk).value].text;
            }
        </script>
        <div id="new_invoice_row">
            <div style="flex: 4;" class="new_invoice">
                <header class="new_invoice_header">
                    <div style="display: flex;">
                        <div style="flex: 1;">Sprzedawca</div>
                        <div style="text-align:right; padding-right: 20px;">
                            <input type="button" onclick="importYourData();" value="Wprowadź dane z ustawień" />
                        </div>
                </header>
                <div class="new_invoice_main">
                    <div class="invoice_form_row">
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <label class="input_text_label" for="fullname">Imię i nazwisko (nazwa)</label><br />
                            <input wire:model.defer="seller_name" value="{{ old('seller_name') }}" name="seller_name" class="input_text" id="seller_name" type="text" placeholder="Nazwa sprzedawcy..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('seller_name'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_name') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="street">Ulica</label><br />
                            <input wire:model.defer="seller_street" value="{{ old('seller_street') }}" name="seller_street" class="input_text" id="seller_street" type="text" placeholder="Nazwa ulicy..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('seller_street'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_street') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="city">Miasto</label><br />
                            <input wire:model.defer="seller_city" value="{{ old('seller_city') }}" name="seller_city" class="input_text" id="seller_city" type="text" placeholder="Wprowadź nazwę miasta..." />
                            <div class="input_separator">
                                @if ($errors->has('seller_city'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_city') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="email">E-mail</label><br />
                            <input wire:model.defer="seller_email" value="{{ old('seller_email') }}" name="seller_email" class="input_text" id="seller_email" type="text" placeholder="Adres e-mail..." />
                            <div class="input_separator">
                                @if ($errors->has('seller_email'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div style="min-width:5%;"></div>
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <div style="display:flex; justify-content: space-between;">
                                <div>
                                    <label class="input_text_label" for="nip">NIP</label>
                                </div>
                                <div>
                                    <input type="button" wire:click="getSellerDataFromApi()" value="Wyszukaj po numerze NIP" />
                                </div>
                            </div>
                            <input wire:model.defer="seller_nip" value="{{ old('seller_nip') }}" name="seller_nip" class="input_text" id="seller_nip" type="text" placeholder="Numer NIP..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('seller_nip'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_nip') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="address2">Numer domu </label><br />
                            <input wire:model.defer="seller_house_number" value="{{ old('seller_house_number') }}" name="seller_house_number" class="input_text" id="seller_house_number" type="text" placeholder="Numer domu..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('seller_house_number'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_house_number') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="phone">Kod pocztowy</label><br />
                            <input wire:model.defer="seller_postcode" value="{{ old('seller_postcode') }}" name="seller_postcode" class="input_text" id="seller_postcode" type="text" placeholder="Kod pocztowy..." />
                            <div class="input_separator">
                                @if ($errors->has('seller_postcode'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_postcode') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="phone">Nr telefonu</label><br />
                            <input wire:model.defer="seller_phone" value="{{ old('seller_phone') }}" name="seller_phone" class="input_text" id="seller_phone" type="text" placeholder="Numer telefonu..." />
                            <div class="input_separator">
                                @if ($errors->has('seller_phone'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('seller_phone') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type='text/javascript'>
                function importClient() {
                    for (let pr = 1; pr < 1000; pr++) {
                        try {
                            document.getElementById('buyer_name').value = document.getElementById('select_client_name').options[document.getElementById('select_client_main').value].text;
                            document.getElementById('buyer_street').value = document.getElementById('select_client_street').options[document.getElementById('select_client_main').value].text;
                            document.getElementById('buyer_city').value = document.getElementById('select_client_city').options[document.getElementById('select_client_main').value].text;
                            document.getElementById('buyer_email').value = document.getElementById('select_client_email').options[document.getElementById('select_client_main').value].text;

                            document.getElementById('buyer_nip').value = document.getElementById('select_client_nip').options[document.getElementById('select_client_main').value].text;
                            document.getElementById('buyer_house_number').value = document.getElementById('select_client_house_number').options[document.getElementById('select_client_main').value].text;
                            document.getElementById('buyer_postcode').value = document.getElementById('select_client_postcode').options[document.getElementById('select_client_main').value].text;
                            document.getElementById('buyer_phone').value = document.getElementById('select_client_phone').options[document.getElementById('select_client_main').value].text;

                        } catch (error) {}
                        //document.getElementById('product_name'+ijk).value = document.getElementById('select_product'+ijk).options[document.getElementById('product_name'+ijk).value].text;
                    }
                }
            </script>
            <div style="flex: 4;" class="new_invoice">
                <header class="new_invoice_header">
                    <div style="display: flex;">
                        <div style="flex: 1;">Nabywca</div>
                        <div style="text-align:right; padding-right: 20px;">
                            <select id="select_client_main" onchange="importClient();">
                                <option value="0">Wybierz...</option>
                                <?php
                                for ($k = 0; $k < count($clients); $k++) {
                                    echo '<option value=' . ($k + 1) . '>' . $clients[$k]->client_name . '</option>';
                                } ?>
                            </select>
                        </div>
                </header>
                <div class="new_invoice_main">
                    <div class="invoice_form_row">
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <label class="input_text_label" for="fullname">Imię i nazwisko (nazwa)</label><br />
                            <input wire:model.defer="buyer_name" value="{{ old('buyer_name') }}" name="buyer_name" class="input_text" id="buyer_name" type="text" placeholder="Nazwa adresata..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('buyer_name'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_name') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="street">Ulica</label><br />
                            <input wire:model.defer="buyer_street" value="{{ old('buyer_street') }}" name="buyer_street" class="input_text" id="buyer_street" type="text" placeholder="Ulica..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('buyer_street'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_street') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="town">Miasto</label><br />
                            <input wire:model.defer="buyer_city" value="{{ old('buyer_city') }}" name="buyer_city" class="input_text" id="buyer_city" type="text" placeholder="Miasto" />
                            <div class="input_separator">
                                @if ($errors->has('buyer_city'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_city') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="fullname">E-mail</label><br />
                            <input wire:model.defer="buyer_email" value="{{ old('buyer_email') }}" name="buyer_email" class="input_text" id="buyer_email" type="text" placeholder="Adres e-mail..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('buyer_email'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div style="min-width:5%;"></div>
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <div style="display:flex; justify-content: space-between;">
                                <div>
                                    <label class="input_text_label" for="nip">NIP</label>
                                </div>
                                <div>
                                    <input type="button" wire:click="getBuyerDataFromApi()" value="Wyszukaj po numerze NIP" />
                                </div>
                            </div>
                            <!-- <label class="input_text_label" for="nip">NIP</label><br/> -->
                            <input wire:model.defer="buyer_nip" value="{{ old('buyer_nip') }}" name="buyer_nip" class="input_text" id="buyer_nip" type="text" placeholder="NIP..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('buyer_nip'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_nip') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="number">Numer domu</label><br />
                            <input wire:model.defer="buyer_house_number" value="{{ old('buyer_house_number') }}" name="buyer_house_number" class="input_text" id="buyer_house_number" type="text" placeholder="Nr domu..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('buyer_house_number'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_house_number') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="zip">Kod pocztowy</label><br />
                            <input wire:model.defer="buyer_postcode" value="{{ old('buyer_postcode') }}" name="buyer_postcode" class="input_text" id="buyer_postcode" type="text" placeholder="Kod pocztowy..." />
                            <div class="input_separator">
                                @if ($errors->has('buyer_postcode'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_postcode') }}
                                </span>
                                @endif
                            </div>
                            <label class="input_text_label" for="phone">Nr telefonu</label><br />
                            <input wire:model.defer="buyer_phone" value="{{ old('buyer_phone') }}" name="buyer_phone" class="input_text" id="buyer_phone" type="text" placeholder="Nr telefonu..." /><br />
                            <div class="input_separator">
                                @if ($errors->has('buyer_phone'))
                                <span class="alert_form" role="alert">
                                    {{ $errors->first('buyer_phone') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="new_invoice" id="page_list_parent">
            <header class="new_invoice_header">
                <div class="product_header">
                    <div class="product_header_input" style="flex: 1.3;">
                        <span style="vertical-align: middle; font-size: 20px;" class="material-symbols-outlined">
                            add_circle
                        </span>
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 9.7;">
                        Nazwa produktu
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 3;">
                        Ilość
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 4;">
                        Cena
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 6;">
                        Stawka VAT
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 4;">
                        Wartość netto
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 4;">
                        Wartość brutto
                    </div>
                </div>
            </header>
            <div class="new_invoice_main">
                <style name="impostor_size">
                    .marker+li {
                        border-top-width: 0px;
                    }
                </style>
                <?php
                $products_count = 1;
                $product_id = 0;
                $new_product = 1;
                if (isset($_SESSION['new_product'])) {
                    $new_product = $_SESSION['new_product'];
                } ?>
    <!-- TODO: zrobic zeby lista w petli sie wyswietlala ladnie rekordy do produktow --->
                <ul id="page_list" class="products_list">
                    {{ $productsCount }}
                    @for($i = 0; $i < $productsCount; $i++)
                    <div id="product_row">
                        <li id="product_f_copy" class="product_field">
                            <div class="delete_product" style="flex: 1.3; display: table;">
                                <div class="for_number" onClick="updateFullpriceSumAfterDelete((this.parentNode.parentNode.id).substring(7)); this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); setIDs();" style="display: table-cell; vertical-align: middle; text-align: center;">

                                </div>
                            </div>
                            <hr>

                            <script type='text/javascript'>
                                function importProduct() {
                                    for (let ijk = 1; ijk < 1000; ijk++) {
                                        try {
                                            document.getElementById('product_price' + ijk).value = document.getElementById('select_price' + ijk).options[document.getElementById('product_name' + ijk).value].text;
                                            document.getElementById('product_name' + ijk).value = document.getElementById('select_product' + ijk).options[document.getElementById('product_name' + ijk).value].text;
                                        } catch (error) {}
                                        //document.getElementById('product_name'+ijk).value = document.getElementById('select_product'+ijk).options[document.getElementById('product_name'+ijk).value].text;
                                    }
                                }
                            </script>
                            <div class="product_field_input" style="flex: 9.7;">
                                <select style="display: none;" id="select_product" onchange="importProduct();">
                                    <option value="0">Wybierz...</option>
                                    <?php
                                    for ($k = 0; $k < count($products); $k++) {
                                        echo '<option value=' . ($k + 1) . '>' . $products[$k]->product_name . '</option>';
                                    } ?>
                                </select>
                                <datalist id="select_product_new" onchange="importProduct();">
                                    <option></option>
                                    <?php
                                    for ($k = 0; $k < count($products); $k++) {
                                        echo '<option value=' . ($k + 1) . '>' . $products[$k]->product_name . '</option>';
                                    } ?>
                                </datalist>
                                <input onchange="importProduct()" list="select_product_new" value="{{old('product_name')}}" name="product_name" type="text" class="product_input" placeholder="Wprowadź nazwę produktu...">
                            </div>
                            <hr>
                            <div class="product_field_input" style="flex: 3;">
                                <div id="prminus" style="margin:auto" class="discount_remove">
                                    <span style="vertical-align: middle; font-size: 16px; margin: auto 5px;" class="material-symbols-outlined" class="discount_remove">
                                        remove_circle
                                    </span>
                                </div>
                                <input value="0" id="prinput" name="product_count" pattern="[0-9]+" type="text" class="product_input" placeholder="X szt." style="text-align: center; padding:0;">
                                <div id="prplus" style="margin:auto;" class="discount_add">
                                    <span style="vertical-align: middle; font-size: 16px; margin: auto 5px;" class="material-symbols-outlined">
                                        add_circle
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="product_field_input" style="flex: 4;">
                                <select style="display: none;" id="select_price" onchange="importProduct()">
                                    <option value="0"></option>
                                    <?php
                                    for ($i = 0; $i < count($products); $i++) {
                                        echo '<option value=' . ($i + 1) . '>' . $products[$i]->product_price . '</option>';
                                    } ?>
                                </select>
                                <input name="product_price" type="text" class="product_input" placeholder="Cena za szt." style="text-align: center; padding: 0;">
                            </div>
                            <hr>
                            <div class="product_field_input" style="flex: 6;">
                                <div id="dcminus" style="margin:auto" class="discount_remove">
                                    <span style="vertical-align: middle; font-size: 16px; margin: auto;" class="material-symbols-outlined" class="discount_remove">
                                        remove_circle
                                    </span>
                                </div>
                                <input id="dcinput" style="text-align: center; padding: 0;" value="23%" name="product_vat" type="text" class="product_input" placeholder="Stawka podatku VAT..." style="text-align: center;">
                                <div id="dcplus" style="margin:auto;" class="discount_add">
                                    <span style="vertical-align: middle; font-size: 16px; margin: auto;" class="material-symbols-outlined">
                                        add_circle
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="product_field_input" style="flex: 4;">
                                <input value="{{old('product_fullprice')}}" name="product_fullprice" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly>
                            </div>
                            <hr>
                            <div class="product_field_input" style="flex: 4;">
                                <input value="{{old('product_fullprice')}}" name="product_fullprice" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly>
                            </div>
                        </li>
                    </div>
                @endfor
            </ul>
            <li wire:click="addProduct()" onclick="/* addProduct() */" id="product_f_copy" class="product_field" style="border-top: 0; cursor: pointer;">
                <div style="flex: 6;"></div>
                <div style="flex: 16;" class="product_field_input">
                    <span style="font-size: 20px; margin: auto;" class="material-symbols-outlined">
                        add_circle
                        <span>Dodaj kolejny produkt</span>
                    </span>
                </div>
                <span style="flex: 2; font-size: 12px; text-align: end;">Wartość faktury:</span>
                <div class="product_field_input" style="flex: 4;">
                    <input id="product_fullprice_sum" name="product_fullprice_sum" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly value=0>
                </div>
            </li>
        </div>
</div>

<div class="new_invoice">
    <button id="submit_invoice_form" type="submit" class="new_invoice_main">Stwórz fakturę</button>
</div>
</form>
@livewireScripts()
</div>
