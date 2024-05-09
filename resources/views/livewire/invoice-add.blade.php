<div class="page" id="new_invoice_page" style="margin-right: 20px;">
    <form wire:submit.prevent="createInvoice()" id="invoice_add_form">
        @csrf
        <h1 class="text-4xl">Nowa faktura</h1>
        <h2 style="padding-left:4%; font-weight: 300; font-size:20px;">nr {{ $invoice_num }}</h2>
        <div class="new_invoice">
            <header class="new_invoice_header">Wybierz typ faktury:</header>
            <div class="new_invoice_main">
                <div class="invoice_type">
                    <div class="invoice_ispaid">
                        <input name="ispaid" wire:model="is_paid" id="ispaid" class="product_input" type="checkbox">
                        <label id="ispaid_label" for="ispaid"><i class="fa fa-check"></i>Opłacona</label></input>
                    </div>
                    <hr>
                    <div class="invoice_date">
                        <i class="fa fa-calendar"></i><span style="padding-right: 7px">Data sprzedaży:</span>
                        <input id="paid_from" name="paid_from" wire:model="sale_date" type="date" class="product_input" value="<?php
                                                                                            $date = new DateTime();
                                                                                            $date->modify("+1 day");
                                                                                            $date->modify("-1 day");
                                                                                            echo $date->format("Y-m-d");
                                                                                            ?>">
                    </div>
                    <hr>
                    <div class="invoice_date">
                        <i class="fa fa-calendar"></i><span style="padding-right: 7px">Termin płatności:</span>
                        <input id="paid_to" name="paid_to" wire:model="payment_deadline" type="date" class="product_input" value="<?php
                                                                                        $date = new DateTime();
                                                                                        $date->modify("+14 day");
                                                                                        echo $date->format("Y-m-d");
                                                                                        ?>">
                    </div>
                </div>
            </div>
        </div>
        <div id="new_invoice_row">
            <div style="flex: 4;" class="new_invoice">
                <header class="new_invoice_header">
                    <div style="display: flex;">
                        <div style="flex: 1;">Sprzedawca</div>
                        <div style="text-align:right; padding-right: 20px;">
                            <button type="button" class="hover:bg-white bg-zinc-300 hover:text-zinc-700 font-thin text-black border border-zinc-500 hover:border-transparent rounded text-xs px-1" wire:click="getSellerDataFromSettings()">
                                Wprowadź dane z ustawień
                            </button>
                        </div>
                </header>
                <div class="new_invoice_main">
                    <div class="invoice_form_row">
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <label class="input_text_label" for="fullname">Imię i nazwisko (nazwa)</label><br />
                            <input wire:model.defer="seller_name" name="seller_name" class="input_text" id="seller_name" type="text" placeholder="Nazwa sprzedawcy..." /><br />
                            <div class="input_separator">
                                @error('seller_name')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="street">Ulica</label><br />
                            <input wire:model.defer="seller_street" value="{{ old('seller_street') }}" name="seller_street" class="input_text" id="seller_street" type="text" placeholder="Nazwa ulicy..." /><br />
                            <div class="input_separator">
                                @error('seller_street')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="city">Miasto</label><br />
                            <input wire:model.defer="seller_city" value="{{ old('seller_city') }}" name="seller_city" class="input_text" id="seller_city" type="text" placeholder="Wprowadź nazwę miasta..." />
                            <div class="input_separator">
                                @error('seller_city')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="email">E-mail</label><br />
                            <input wire:model.defer="seller_email" value="{{ old('seller_email') }}" name="seller_email" class="input_text" id="seller_email" type="text" placeholder="Adres e-mail..." />
                            <div class="input_separator">
                                @error('seller_email')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="min-width:5%;"></div>
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <div style="display:flex; justify-content: space-between;">
                                <div>
                                    <label class="input_text_label" for="nip">NIP</label>
                                </div>
                                <div>
                                    <button type="button" class="bg-transparent hover:bg-zinc-100 text-zinc-700 font-thin hover:text-black border border-zinc-500 rounded text-xs px-1" wire:click="getSellerDataFromApi()">
                                        Wyszukaj po numerze NIP
                                    </button>
                                </div>
                            </div>
                            <input wire:model.defer="seller_nip" value="{{ old('seller_nip') }}" name="seller_nip" class="input_text" id="seller_nip" type="text" placeholder="Numer NIP..." /><br />
                            <div class="input_separator">
                                @error('seller_nip')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="address2">Numer domu </label><br />
                            <input wire:model.defer="seller_house_number" value="{{ old('seller_house_number') }}" name="seller_house_number" class="input_text" id="seller_house_number" type="text" placeholder="Numer domu..." /><br />
                            <div class="input_separator">
                                @error('seller_house_number')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="phone">Kod pocztowy</label><br />
                            <input wire:model.defer="seller_postcode" value="{{ old('seller_postcode') }}" name="seller_postcode" class="input_text" id="seller_postcode" type="text" placeholder="Kod pocztowy..." />
                            <div class="input_separator">
                                @error('seller_postcode')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="phone">Nr telefonu</label><br />
                            <input wire:model.defer="seller_phone" value="{{ old('seller_phone') }}" name="seller_phone" class="input_text" id="seller_phone" type="text" placeholder="Numer telefonu..." />
                            <div class="input_separator">
                                @error('seller_phone')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 4;" class="new_invoice">
                <header class="new_invoice_header">
                    <div style="display: flex;">
                        <div style="flex: 1;">Nabywca</div>
                        <div>
                            <select id="buyer_select" style="max-width: 200px;" class="px-2 py-1 rounded text-sm bg-zinc-200 text-black mr-3" wire:model="clientIndex" wire:change="getBuyerDataFromDatabase()">
                                <option value="0">Wybierz...</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->client_name }} </option>
                                @endforeach
                            </select>
                        </div>
                </header>
                <div class="new_invoice_main">
                    <div class="invoice_form_row">
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <label class="input_text_label" for="fullname">Imię i nazwisko (nazwa)</label><br />
                            <input wire:model.defer="buyer_name" value="{{ old('buyer_name') }}" name="buyer_name" class="input_text" id="buyer_name" type="text" placeholder="Nazwa adresata..." /><br />
                            <div class="input_separator">
                                @error('buyer_name')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="street">Ulica</label><br />
                            <input wire:model.defer="buyer_street" value="{{ old('buyer_street') }}" name="buyer_street" class="input_text" id="buyer_street" type="text" placeholder="Ulica..." /><br />
                            <div class="input_separator">
                                @error('buyer_street')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="town">Miasto</label><br />
                            <input wire:model.defer="buyer_city" value="{{ old('buyer_city') }}" name="buyer_city" class="input_text" id="buyer_city" type="text" placeholder="Miasto" />
                            <div class="input_separator">
                                @error('buyer_city')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="fullname">E-mail</label><br />
                            <input wire:model.defer="buyer_email" value="{{ old('buyer_email') }}" name="buyer_email" class="input_text" id="buyer_email" type="text" placeholder="Adres e-mail..." /><br />
                            <div class="input_separator">
                                @error('buyer_email')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div style="min-width:5%;"></div>
                        <div class="invoice_form_column_in_row" style="flex:1;">
                            <div style="display:flex; justify-content: space-between;">
                                <div>
                                    <label class="input_text_label" for="nip">NIP</label>
                                </div>
                                <div>
                                    <button type="button" class="bg-transparent hover:bg-zinc-100 text-zinc-700 font-thin hover:text-black border border-zinc-500 rounded text-xs px-1" wire:click="getBuyerDataFromApi()">
                                        Wyszukaj po numerze NIP
                                    </button>
                                </div>
                            </div>
                            <!-- <label class="input_text_label" for="nip">NIP</label><br/> -->
                            <input wire:model.defer="buyer_nip" value="{{ old('buyer_nip') }}" name="buyer_nip" class="input_text" id="buyer_nip" type="text" placeholder="NIP..." /><br />
                            <div class="input_separator">
                                @error('buyer_nip')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="number">Numer domu</label><br />
                            <input wire:model.defer="buyer_house_number" value="{{ old('buyer_house_number') }}" name="buyer_house_number" class="input_text" id="buyer_house_number" type="text" placeholder="Nr domu..." /><br />
                            <div class="input_separator">
                                @error('buyer_house_number')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="zip">Kod pocztowy</label><br />
                            <input wire:model.defer="buyer_postcode" value="{{ old('buyer_postcode') }}" name="buyer_postcode" class="input_text" id="buyer_postcode" type="text" placeholder="Kod pocztowy..." />
                            <div class="input_separator">
                                @error('buyer_postcode')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="input_text_label" for="phone">Nr telefonu</label><br />
                            <input wire:model.defer="buyer_phone" value="{{ old('buyer_phone') }}" name="buyer_phone" class="input_text" id="buyer_phone" type="text" placeholder="Nr telefonu..." /><br />
                            <div class="input_separator">
                                @error('buyer_phone')
                                    <span class="alert_form">{{ $message }}</span>
                                @enderror
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
                    <div class="product_header_input" style="flex: 8;">
                        Nazwa produktu
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 4;">
                        Ilość
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 6;">
                        Cena jedn. netto
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 6;">
                        Stawka VAT [%]
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 4;">
                        Rabat [%]
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 5;">
                        Wartość netto
                    </div>
                    <hr>
                    <div class="product_header_input" style="flex: 5;">
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
                    <select id="product_select" style="display:none;">
                        <option value="null">Wybierz...</option>
                        @foreach($products as $prod)
                        <option>{{ $prod->product_name }}</option>
                        @endforeach
                    </select>
                    <select id="product_price_select" style="display: none;" style="margin: auto;">
                        <option value="null">Wybierz...</option>
                        @foreach($products as $prod)
                        <option>{{ $prod->product_price }}</option>
                        @endforeach
                    </select>
                    @foreach($productsList as $index => $product)
                        <div>
                            <li class="product_field">
                                <div class="delete_product" style="flex: 1.3; display: table;">
                                    <div class="for_number" wire:click="deleteProduct({{ $index }})" style="display: table-cell; vertical-align: middle; text-align: center;">
                                        <span>{{ $loop->index+1 }}</span>
                                    </div>
                                </div>
                                <hr>
                                <datalist id="select_product_new">
                                    @foreach($products as $prod)
                                    <option>{{ $prod->product_name }}</option>
                                    @endforeach
                                </datalist>
                                <div class="product_field_input" style="flex: 8;">
                                    <input id="product_input{{$index}}" wire:model.defer="productsList.{{$index}}.product_name" list="select_product_new" value="{{old('product_name')}}" name="product_name" type="text" class="product_input" placeholder="Wprowadź nazwę...">
                                </div>
                                <hr>
                                <div class="product_field_input" style="flex: 4;">
                                    <div id="product_count_minus{{$index}}" style="margin:auto; {{ $product['number'] > 0 ? '' : 'cursor:default;' }}" class="discount_remove" wire:click="productCounterMinus({{ $index }})">
                                        <span style="{{ $product['number'] > 0 ? '' : 'visibility:hidden;' }} vertical-align: middle; font-size: 16px; margin: auto 5px;" class="material-symbols-outlined" class="discount_remove">
                                            remove_circle
                                        </span>
                                    </div>
                                    <input id="product_count_input{{$index}}" wire:model.defer="productsList.{{$index}}.number" name="product_count" pattern="[0-9]+" type="text" class="product_input" placeholder="X szt." style="text-align: center; padding:0;" wire:change="updateProduct()">
                                    <div id="product_count_plus{{$index}}" style="margin:auto;" class="discount_add" wire:click="productCounterPlus({{ $index }})">
                                        <span style="vertical-align: middle; font-size: 16px; margin: auto 5px;" class="material-symbols-outlined">
                                            add_circle
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="product_field_input" style="flex: 6;">
                                    <input id="product_price_input{{$index}}" wire:model.defer="productsList.{{$index}}.price" name="product_price" type="text" class="product_input" placeholder="Cena za szt." style="text-align: center; padding: 0;" wire:change="updateProduct()">
                                </div>
                                <hr>
                                <div class="product_field_input" style="flex: 6;">
                                    <div id="product_vat_minus{{$index}}" style="margin:auto; {{ $product['vat'] > 0 ? '' : 'cursor:default;' }}" class="discount_remove" wire:click="productVatMinus({{ $index }})">
                                        <span style="{{ $product['vat'] > 0 ? '' : 'visibility:hidden;' }} vertical-align: middle; font-size: 16px; margin: auto;" class="material-symbols-outlined" class="discount_remove">
                                            remove_circle
                                        </span>
                                    </div>
                                    <input id="product_vat_input{{$index}}" wire:model.defer="productsList.{{$index}}.vat" style="text-align: center; padding: 0;" name="product_vat" type="text" class="product_input" placeholder="Stawka podatku VAT..." style="text-align: center;" wire:change="updateProduct()">
                                    <div id="product_vat_plus{{$index}}" style="margin:auto; {{ $product['vat'] >= 100 ? 'cursor:default;' : '' }}" class="discount_add" wire:click="productVatPlus({{ $index }})">
                                        <span style="{{ $product['vat'] >= 100 ? 'visibility:hidden;' : '' }} vertical-align: middle; font-size: 16px; margin: auto;" class="material-symbols-outlined">
                                            add_circle
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="product_field_input" style="flex: 4;">
                                    <div id="product_discount_minus{{$index}}" style="margin:auto; {{ $product['discount'] > 0 ? '' : 'cursor:default;' }}" class="discount_remove" wire:click="productDiscountMinus({{ $index }})">
                                        <span style="{{ $product['discount'] > 0 ? '' : 'visibility:hidden;' }} vertical-align: middle; font-size: 16px; margin: auto;" class="material-symbols-outlined" class="discount_remove">
                                            remove_circle
                                        </span>
                                    </div>
                                    <input id="product_discount_input{{$index}}" wire:model.defer="productsList.{{$index}}.discount" name="product_price" type="text" class="product_input" placeholder="Cena za szt." style="text-align: center; padding: 0;" wire:change="updateProduct()">
                                    <div id="product_discount_plus{{$index}}" style="margin:auto; {{ $product['discount'] < 100 ? '' : 'cursor:default;' }}" class="discount_add" wire:click="productDiscountPlus({{ $index }})">
                                        <span style="{{ $product['discount'] < 100 ? '' : 'visibility:hidden;' }} vertical-align: middle; font-size: 16px; margin: auto;" class="material-symbols-outlined">
                                            add_circle
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="product_field_input" style="flex: 5;">
                                    <input id="netto_price_input{{$index}}" value="{{ number_format(($product['price'] * $product['number']) * ((100 - $product['discount']) / 100), 2, ',', ' ') . ' zł' }}" name="product_fullprice_netto" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly>
                                </div>
                                <hr>
                                <div class="product_field_input" style="flex: 5;">
                                    <input id="brutto_price_input{{$index}}" value="{{ number_format(($product['price'] * $product['number'] * ((100 - $product['discount']) / 100)) * ((100 + $product['vat']) / 100), 2, ',', ' ') . ' zł' }}" name="product_fullprice_brutto" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly>
                                </div>
                            </li>
                        </div>
                        <script>
                            var productInput = document.getElementById('product_input' + {{ $index }});
                            var productPriceInput = document.getElementById('product_price_input' + {{ $index }});

                            const productSelect = document.getElementById('product_select');
                            const productPriceSelect = document.getElementById('product_price_select');

                            productInput.addEventListener('input', () => {
                                var inputValue = productInput.value;
                                for (let i = 0; i < productSelect.options.length; i++) {
                                    if (productSelect.options[i].value === inputValue) {
                                        const selectedOption = productSelect.options[i];
                                        // productPriceInput.value = productPriceSelect.options[i].value || ''; // Assuming a "data-price" attribute on options for price
                                        window.livewire.emit('updateProductPrice', {{ $index }}, productPriceSelect.options[i].value);
                                        break;
                                    }
                                }
                            });
                        </script>
                    @endforeach
                </ul>
                <li id="add_next_product_button" wire:click="addProduct()" id="product_f_copy" class="product_field" style="border-top: 0; cursor: pointer;">
                    <div style="flex: 12;" class="product_field_input">
                        <span style="font-size: 20px; margin: auto;" class="material-symbols-outlined">
                            add_circle
                            <span>Dodaj kolejny produkt</span>
                        </span>
                    </div>
                </li>
                <li id="product_f_copy" class="product_field" style="border-top: 0;">
                    <div style="flex: 14;"></div>
                    <div>
                        <div style="display: flex; padding-bottom: 6px;">
                            <span style="flex: 4; font-size: 12px; text-align: end; margin: auto;">Suma rabatów netto:</span>
                            <div class="product_field_input" style="flex: 4;">
                                <input id="discounts_sum" name="product_fullprice_sum" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly value="{{ number_format($invoiceDiscountTotal, 2, ',', ' ') . ' zł' }}">
                            </div>
                        </div>
                        <div style="display: flex;">
                            <span style="flex: 4; font-size: 12px; text-align: end; margin: auto;">Suma podatku VAT:</span>
                            <div class="product_field_input" style="flex: 4;">
                                <input id="vat_sum" name="product_fullprice_sum" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly value="{{ number_format($invoiceVatTotal, 2, ',', ' ') . ' zł' }}">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; padding-bottom: 6px;">
                            <span style="flex: 4; font-size: 12px; text-align: end; margin: auto;">Wartość faktury netto:</span>
                            <div class="product_field_input" style="flex: 4;">
                                <input id="netto_sum" name="product_fullprice_sum" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly value="{{ number_format($invoiceFullpriceNetto, 2, ',', ' ') . ' zł' }}">
                            </div>
                        </div>
                        <div style="display: flex;">
                            <span style="flex: 4; font-size: 12px; text-align: end; margin: auto;">Wartość faktury brutto:</span>
                            <div class="product_field_input" style="flex: 4;">
                                <input id="brutto_sum" name="product_fullprice_sum" type="text" class="product_input" placeholder="-" style="text-align: end; padding-right: 10px;" readonly value="{{ number_format($invoiceFullpriceBrutto, 2, ',', ' ') . ' zł' }}">
                            </div>
                        </div>
                    </div>
                </li>
            </div>
        </div>
        <div class="new_invoice" id="page_list_parent">
            <header class="new_invoice_header">
                <div class="product_header">
                    <div class="product_header_input" style="flex: 8;">
                        Uwagi
                    </div>
                </div>
            </header>
            <div class="new_invoice_main">
                <li id="product_f_copy" class="product_field" style="border: 0;">
                    <div style="width: 80%;">
                        <div class="product_field_input" style="width: 100%;">
                            <textarea id="note" class="rounded-lg border shadow-lg" wire:model="note" name="product_fullprice_sum" style="width: 100%; min-height: 100px; padding: 8px;" type="text" class="product_input" placeholder="Wprowadź uwagi dodatkowe..." value=""></textarea>
                        </div>
                        @error('note')
                            <span class="alert_form">{{ $message }}</span>
                        @enderror
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
