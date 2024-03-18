<?php
    if($invoice==null) {
        echo '<script>alert("Wybrana faktura nie jest dostępna lub zalogowany uytkownik nie posiada do niej dostępu!");</script>';
        echo ("<div style='font-family: Arial; text-align: center; padding-top: 100px;'><h1 style='
        vertical-align:middle;'>BRAK FAKTURY</h1><button style='height: 50px; font-size: 20px;'>Powrót</button></div>");
        return;
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            body {
                font-family: "Dejavu Sans", sans-serif;
                font-weight: normal;
                font-size: 10pt;
                line-height: 1;
            }
    
            table {
                width: 100%;
                border-collapse: collapse;
            }
    
            table,
            th,
            td {
                border: 1px solid black;
            }
    
            th,
            td {
                padding: 5px;
                text-align: left;
            }
    
            section {
                page-break-before: always;
            }
        </style>
    </head>
	<body class="my-10 mx-[15rem]">
        <style>
            {!! file_get_contents(public_path('css/app.css')) !!}
        </style>
        <div class="text-xs">
            Wystawiono: {{ $invoice->created_at->format('Y-m-d H:i:s') }}
        </div>
        <div class="flex grid-cols-2">
            <div></div>
            <div class="grid text-center">
                <div class="text-2xl">Faktura</div>
                <div class="text-lg border-y border-zinc-500 bg-zinc-100">nr {{ $invoice->invoice_num }}</div>
                <div class="text-xs">Data sprzedaży: {{ $invoice->sale_date }}</div>
                <div class="text-xs">Termin płatności: {{ $invoice->payment_deadline }}</div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2" style="width: 100%;">
            <div class="" style="width: 50%; float: left;">
                <div class="font-bold text-md mb-2 border-b border-zinc-500">Sprzedawca:</div>
                <div class="text-xs">{{ $invoice->seller_name }}</div>
                <div class="text-xs">NIP: {{ $invoice->seller_nip }}</div>
                <div class="text-xs">{{ $invoice->seller_street.' '.$invoice->seller_house_number }}</div>
                <div class="text-xs">{{ $invoice->seller_postcode.' '.$invoice->seller_city }}</div>
                @if($invoice->seller_phone) <div class="text-xs">tel. {{ $invoice->seller_phone }}</div> @endif
                @if($invoice->seller_email) <div class="text-xs">e-mail: {{ $invoice->seller_email }}</div> @endif
            </div>
            <div class="text-right" style="width: 50%; float: left;">
                <div class="font-bold text-md mb-2 border-b border-zinc-500">Nabywca:</div>
                <div class="text-xs"> {{ $invoice->buyer_name }} </div>
                <div class="text-xs"> NIP: {{ $invoice->buyer_nip }} </div>
                <div class="text-xs"> {{ $invoice->buyer_street.' '.$invoice->buyer_house_number }} </div>
                <div class="text-xs"> {{ $invoice->buyer_postcode.' '.$invoice->buyer_city }} </div>
                @if($invoice->buyer_phone) <div class="text-xs"> {{ $invoice->buyer_phone }} </div> @endif
                @if($invoice->buyer_phone) <div class="text-xs"> {{ $invoice->buyer_email }} </div> @endif
            </div>
        </div>
        <div style="clear:both; padding-top: 2rem;" class="relative m-auto w-4/5 overflow-x-auto">
            <table class="text-right w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase bg-zinc-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="">
                            Lp.
                        </th>
                        <th scope="col" class="">
                            Nazwa
                        </th>
                        <th scope="col" class="">
                            Ilość
                        </th>
                        <th scope="col" class="">
                            Cena netto
                        </th>
                        <th scope="col" class="">
                            Wartość netto
                        </th>
                        <th scope="col" class="">
                            VAT [%]
                        </th>
                        <th scope="col" class="">
                            Kwota VAT
                        </th>
                        <th scope="col" class="">
                            Wartość brutto
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->getProducts() as $product)
                    <tr>
                        <td scope="row" class="text-left border-t border-x text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->index+1 }}.
                        </td>
                        <td scope="row" class="text-left border-t border-x text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->product_name }}
                        </td>
                        <td class="border-t border-x">
                            {{ $product->number }}
                        </td>
                        <td class="border-t border-x">
                            {{ number_format($product->price * (100 - $product->discount)/100, 2, ".", " ")."zł" }}
                        </td>
                        <td class="border-t border-x">
                            {{ number_format($product->price * (100 - $product->discount)/100 * $product->number, 2, ".", " ")." zł" }}
                        </td>
                        <td class="border-t border-x">
                            {{ $product->vat }}
                        </td>
                        <td class="border-t border-x">
                            {{ number_format(($product->vat / 100) * ($product->price * (100 - $product->discount)/100 * $product->number), 2, ".", " ")." zł" }}
                        </td>
                        <td class="border-t border-x">
                            {{ number_format(($product->number)*($product->price * (100 - $product->discount)/100) * ((100 + $product->vat) / 100), 2, ".", " ")." zł" }}
                        </td>
                    </tr>
                    @endforeach
                    <tr class="text-xs font-bold border-t border-zinc-500">
                        <td class=""></td>
                        <td class="border-t border-zinc-500"></td>
                        <td class=""></td>
                        <td class="">Razem:</td>
                        <td class="bg-zinc-100 border-l border-zinc-500 text-xs text-right font-bold">{{ number_format($invoiceTaxes['all']['netto'], 2, ".", " ")." zł" }}</td>
                        <td class="bg-zinc-100 border-l"></td>
                        <td class="bg-zinc-100 border-l text-xs text-right font-bold">{{ number_format($invoiceTaxes['all']['vat'], 2, ".", " ")." zł" }}</td>
                        <td class="bg-zinc-100 border-l text-xs text-right font-bold">{{ number_format($invoiceTaxes['all']['brutto'], 2, ".", " ")." zł" }}</td>
                    </tr>
                    @php
                        $wTym = false;
                    @endphp
                    @for($i=100; $i>=0; $i--)
                        @if(isset($invoiceTaxes[$i]))
                        <tr class="text-xs font-bold">
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class="">
                                @if (!$wTym)
                                    W tym:
                                    @php $wTym = true; @endphp
                                @endif</td>
                            <td class="bg-zinc-100 border border-l-black text-xs text-right font-bold">{{ number_format($invoiceTaxes[$i]['netto'], 2, ".", " ")." zł" }}</td>
                            <td class="bg-zinc-100 border border-1">{{ $i }}</td>
                            <td class="bg-zinc-100 border border-1 text-xs text-right font-bold">{{ number_format($invoiceTaxes[$i]['vat'], 2, ".", " ")." zł" }}</td>
                            <td class="bg-zinc-100 border border-1 text-xs text-right font-bold">{{ number_format($invoiceTaxes[$i]['brutto'], 2, ".", " ")." zł" }}</td>
                        </tr>
                        @endif
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="grid mt-4">
            <span class="text-md">Razem do zapłaty: <b>{{ number_format($invoiceTaxes['all']['brutto'], 2, ".", " ")." zł" }} </b></span>
            <span class="font-normal text-xs">(słownie: {{ $zloteSlownie}} PLN {{ round($invoiceTaxes['all']['brutto'] - floor($invoiceTaxes['all']['brutto']),2)*100 }}/100)</span>
        </div>
        <div class="font-normal text-xs border mt-4 min-h-10 p-1" style="border-color: black;">Uwagi: {{ $invoice->note }}</div>
        <div class="w-full mt-16">
            <div style="width: 100%;">
                <div style="width: 50%; float: left;">
                    <div class="text-left">__________________________________________</div>
                    <div class="text-xs text-left">podpis osoby upoważnionej do odbioru faktury</div>
                </div>
                <div style="width: 50%; float: left;">
                    <div class="text-right">_____________________________________________</div>
                    <div class="text-xs text-right">podpis osoby upoważnionej do wystawienia faktury</div>
                </div>
            </div>
        </table>
	</body>
</html>
