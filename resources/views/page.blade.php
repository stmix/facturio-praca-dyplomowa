<?php
    $_SESSION['open']='index';
    $thisPage = "Dashboard";

    $userid = Auth::id();
    $products=DB::select("select * from products where owner_id='$userid'");
    $clients=DB::select("select * from clients where owner_id='$userid'");
    $invoices=DB::select("select * from invoices where user_id='$userid'");
    $invoices_sum=DB::select("select sum(value_netto) as invoices_sum from invoices where user_id='$userid'")[0]->invoices_sum;
    $products_count=count($products);
    $clients_count=count($clients);
    $invoices_count=count($invoices);
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
        <div class="page">
            <div class="say-hi">
                <text>
                    Witaj, <?php echo Auth::user()['name'];?> 👋
                </text>
                <a href="{{ route('invoices.create') }}">
                    <button>
                        <i class="material-symbols-outlined">add</i>
                    </button>
                </a>
                <a href="/settings">
                    <button>
                        <i class="material-symbols-outlined">settings</i>
                    </button>
                </a>
            </div>
            <div class="summary">
                <text> Ogólny przegląd </text>
                <div class="summary_items">
                    <a href="/clients">
                        <div class="containter">
                            <i class="material-symbols-outlined">grade</i>
                            <text>Odbiorcy</text>
                            <text class="value">{{ $clients_count }}</text>
                        </div>
                    </a>
                    <a href="/products">
                        <div class="containter">
                            <i class="material-symbols-outlined">inventory_2</i>
                            <text>Produkty</text>
                            <text class="value">{{ $products_count }}</text>
                        </div>
                    </a>
                    <a href="/invoices">
                        <div class="containter">
                            <i class="material-symbols-outlined">request_page</i>
                            <text>Faktury</text>
                            <text class="value">{{ $invoices_count }}</text>
                        </div>
                    </a>
                    <div class="containter">
                        <i class="material-symbols-outlined">attach_money</i>
                        <text>Zafakturowane</text>
                        <text class="value_money">{{ number_format($invoices_sum, 2, ".", " ").' zł' }}</text>
                    </div>
                </div>
            </div>
            <div class="recent_transactions">
                <text>Ostatnie transakcje </text>
                <?php
                    $userid = Auth::id();
                    $invoices=DB::select("select * from invoices where user_id='$userid'");
                    ?>
                @for($i=0; $i<min(count($invoices),5); $i++)

                <a href="/invoices">
                    <div class="m-4">
                        <div class="py-3 lg:py-0 lg:flex lg:flex-wrap min-h-14 bg-zinc-200 items-center rounded-lg border border-1 border-zinc-300" {{-- class="transactions_row" --}}>
                            <div class="lg:w-[8%] flex justify-center">
                                <div class="company_icon">
                                <i class="material-symbols-outlined">attach_money</i>
                                </div>
                            </div>
                            <div class="lg:w-[39%] text-center font-semibold"><text class="text-lg lg:text-base"> {{ $invoices[$i]->buyer_name }} </text></div>
                            <div class="lg:w-[13%] text-center"><text class="company_date"> {{ date("d M Y", strtotime($invoices[$i]->sale_date)) }} </text></div>
                            <div class="lg:w-[13%] text-center font-semibold"><text class="company_price text-lg lg:text-base"> {{ number_format($invoices[$i]->value_netto, 2, '.', ' ').' zł' }} </text></div>
                            <div class="lg:w-[9%] flex justify-center px-2 py-1 items-center w-min m-auto rounded-2xl {{ $invoices[$i]->is_paid==0 ? 'bg-red-500' : 'bg-green-500' }}">
                                <text class="status"> {{ $invoices[$i]->is_paid==0 ? 'Nieopłacona' : 'Opłacona' }} </text>
                            </div>
                        </div>
                    </div>
                </a>
                @endfor
            </div>
        </div>
    </body>
</html>