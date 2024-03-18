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
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/style_m.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('navbar');
    <div class="page">
        <div class="say-hi">
            <div class="history_header">
                <text> Produkty </text>
   
                <a class="linkwithoutlines" href="/products/add">
                    <div class="time_button">
                        <text>
                            Dodaj
                        </text>
                        <i class="material-symbols-outlined">add</i>
                    </div>
                </a>
            </div>

        </div>
        <div>
            @foreach($products as $product)
            <div class="m-4">
                <div class="py-3 lg:py-0 lg:flex lg:flex-wrap min-h-14 bg-zinc-200 items-center rounded-lg border border-1 border-zinc-300" {{-- class="transactions_row" --}}>
                    <div class="lg:w-[10%] flex justify-center">
                        <div class="company_icon">
                        <i class="material-symbols-outlined">inventory_2</i>
                        </div>
                    </div>
                    <div class="lg:w-[20%] text-center"><text class="text-lg lg:text-base"> {{ $product->product_name }} </text></div>
                    <div class="lg:w-[25%] text-center font-thin text-neutral-600"><text> {{ $product->producent }} </text></div>
                    <div class="lg:w-[17%] text-center"><text class=" text-lg lg:text-base"> {{ $product->product_info }} </text></div>
                    <div class="lg:w-[8%] text-center"><text class=" text-lg lg:text-base"> {{ number_format($product->product_price, 2, '.', ' ').' zł' }} </text></div>
                    <div class="lg:w-[20%] flex m-auto justify-center p-2">
                        <a href="/products/{{ $product->id }}/edit">
                            <div class="mx-2 bg-amber-500 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center">
                                <i class="material-symbols-outlined text-white">edit</i>
                            </div>
                        <a class="linkwithoutlines" onclick="return confirm(`Czy na pewno chcesz usunąć produkt?`)" href="/products/{{ $product->id }}">
                            <div class="bg-red-500 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center">
                                <i class="material-symbols-outlined text-white">delete</i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach




            {{-- <div class="products_row">
                <div class="company_icon">
                    <i class="material-symbols-outlined">inventory_2</i>
                </div>
                <div id="products_data">
                    <div class="product_name">';  echo $products[$i]->product_name</div>
                    <div class="prod_description">';  echo $products[$i]->producent</div>
                    <div class="prod_description">';  echo $products[$i]->product_info</div>
                    <div class="product_name">';  echo $products[$i]->product_pricezł</div>
                </div>
                <div class="menage_buttons">
                    <div class="info_icon">
                        <i class="material-symbols-outlined">info</i>
                    </div>
                    <div class="edit_icon">
                        <i class="material-symbols-outlined">edit</i>
                    </div>
                    <a class="linkwithoutlines" onclick="return confirm(\'Czy na pewno chcesz usunąć produkt?\');" href="/products/'.$products[$i]->id.'">
                    <div class="delete_icon">
                            <i class="material-symbols-outlined">delete</i>
                        </div>
                    </a>
                </div>
            </div> --}}





        </div>
    </div>
</body>
</html>