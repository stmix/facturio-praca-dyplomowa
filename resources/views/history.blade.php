<?php
    use Illuminate\Support\Facades\Auth;
    $_SESSION['open']='history';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

    @include('navbar');
    <div class="page mr-6">
        <div class="say-hi">
            <div class="history_header">
                <text> Historia </text>
            </div>
        </div>
        @foreach($invoices as $index => $invoice)
            <div class="m-4">
                <div class="py-3 lg:py-0 lg:flex lg:flex-wrap min-h-14 bg-zinc-200 items-center rounded-lg border border-1 border-zinc-300" {{-- class="transactions_row" --}}>
                    <div class="lg:w-[8%] flex justify-center">
                        <div class="company_icon">
                        <i class="material-symbols-outlined">attach_money</i>
                        </div>
                    </div>
                    <div class="lg:w-[39%] text-center"><text class="text-lg lg:text-base"> {{ $invoice->buyer_name }} </text></div>
                    <div class="lg:w-[13%] text-center font-thin"><text> {{ date("d M Y", strtotime($invoice->sale_date)) }} </text></div>
                    <div class="lg:w-[13%] text-center"><text class=" text-lg lg:text-base"> {{ number_format($invoice->value_netto, 2, '.', ' ').' zł' }} </text></div>
                    <div class="lg:w-[9%] flex justify-center px-2 py-1 items-center w-min m-auto rounded-2xl {{ $invoice->is_paid==0 ? 'bg-red-500' : 'bg-green-500' }}">
                        <text class="status"> {{ $invoice->is_paid==0 ? 'Nieopłacona' : 'Opłacona' }} </text>
                    </div>
                    <div class="lg:w-[18%] flex m-auto justify-center p-2">
                        <div class="cursor-pointer mr-2 bg-zinc-400 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center" onclick="showInvoiceDetails({{strval($index)}});">
                            <i class="material-symbols-outlined text-white">info</i>
                        </div>
                        <a class="linkwithoutlines mr-2" onclick="return confirm(`Czy na pewno chcesz zmienić status faktury na {{ $invoice->is_paid==0 ? 'opłacony' : 'nieopłacony'}}?`)" href="/invoices/status/{{$invoice->id}}">
                            <div class="bg-amber-500 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center">
                                <i class="material-symbols-outlined text-white">paid</i>
                            </div>
                        </a>
                        <a class="linkwithoutlines" onclick="return confirm(`Czy na pewno chcesz usunąć fakturę?`)" href="/invoices/delete/{{$invoice->id}}">
                            <div class="bg-red-500 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center">
                                <i class="material-symbols-outlined text-white">delete</i>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="invoice_details{{strval($index)}}" class="border border-1 rounded-lg px-9 py-6 bg-neutral-100 w-full" style="display: none;">
                    <div class="grid lg:grid-cols-3">
                        <div class="grid gap-0 h-min text-center lg:text-left pb-5 lg:pb-0 lg:pr-5">
                            <span class="text-md pb-2">Sprzedawca:</span>
                            <span class="text-lg font-bold">{{ $invoice->seller_name }}</span>
                            <span>{{ $invoice->seller_street.' '.$invoice->seller_house_number }}</span>
                            <span>{{ $invoice->seller_postcode.' '.$invoice->seller_city }}</span>
                            <span>{{ $invoice->seller_nip }}</span>
                            <span>{{ $invoice->seller_phone }}</span>
                            <span>{{ $invoice->seller_email }}</span>
                        </div>
                        <div class="py-5 lg:py-0 lg:px-5 border-y lg:border-y-0 lg:border-x border-zinc-300">
                            <h3>Produkty:</h3>
                            <div class="relative overflow-x-auto rounded-lg border border-1 border-zinc-400">
                                <table class="text-right w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-white uppercase bg-zinc-500 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-2 py-1">
                                                
                                            </th>
                                            <th scope="col" class="px-2 py-1">
                                                Liczba
                                            </th>
                                            <th scope="col" class="px-2 py-1">
                                                Cena za szt.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->getProducts() as $product)
                                        <tr class="bg-zinc-100 border-b">
                                            <th scope="row" class="px-3 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $product->product_name }}
                                            </th>
                                            <td class="px-3 py-1">
                                                {{ $product->number }}
                                            </td>
                                            <td class="px-3 py-1">
                                                {{ number_format($product->price, 2, ',', ' ') . ' zł' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-5 flex justify-center">
                                <a class="linkwithoutlines pr-1" href="{{ route('invoices.show', $invoice->id) }}" target="_blank">
                                    <div class="bg-lime-400 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center" style="margin: auto; vertical-align: middle;">
                                        <i class="material-symbols-outlined">preview</i>
                                    </div>
                                </a>
                                <a class="linkwithoutlines pl-1" href="{{ route('invoices.download', $invoice->id) }}" target="_blank">
                                    <div class="bg-yellow-400 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center" style="margin: auto; vertical-align: middle;">
                                        <i class="material-symbols-outlined">download</i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="grid gap-0 h-min text-center lg:text-right pt-5 lg:pt-0 lg:pl-5">
                            <span class="text-md pb-2">Sprzedawca:</span>
                            <span class="text-lg font-bold">{{ $invoice->buyer_name }}</span>
                            <span>{{ $invoice->buyer_street.' '.$invoice->buyer_house_number }}</span>
                            <span>{{ $invoice->buyer_postcode.' '.$invoice->buyer_city }}</span>
                            <span>{{ $invoice->buyer_nip }}</span>
                            <span>{{ $invoice->buyer_phone }}</span>
                            <span>{{ $invoice->buyer_email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
<script>
    function showInvoiceDetails($num) {
        if(document.getElementById("invoice_details"+$num.toString()).style.display != "none") {
            document.getElementById("invoice_details"+$num.toString()).style.display = "none";
        } else {
            document.getElementById("invoice_details"+$num.toString()).style.display = "block";
        }
    }
</script>