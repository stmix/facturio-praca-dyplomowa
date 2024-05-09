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
    <link rel="stylesheet" href="/css/style_matk.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('navbar');
    <div class="page" >
        <div class="top_row" >
            <div class="customers_header">
                <text> Odbiorcy </text>
                <a class="linkwithoutlines" href="/clients/add">
                    <div class="add_button" id="add_client_button">
                        <text>
                            Dodaj
                        </text>
                        <i class="material-symbols-outlined">add</i>
                    </div>
                </a>
            </div>
        </div>
        @foreach($clients as $index => $client)
        <div class="client_row mx-4 mt-4">
            <div class="py-3 lg:py-0 lg:flex lg:flex-wrap min-h-14 bg-zinc-200 items-center rounded-lg border border-1 border-zinc-300" {{-- class="transactions_row" --}}>
                <div class="lg:w-[10%] flex justify-center">
                    <div class="company_icon">
                    <i class="material-symbols-outlined">inventory_2</i>
                    </div>
                </div>
                <div class="lg:w-[20%] text-center"><text class="text-lg lg:text-base"> {{ $client->client_name }} </text></div>
                <div class="lg:w-[25%] text-center font-thin text-neutral-600"><text> {{ $client->client_email }} </text></div>
                <div class="lg:w-[17%] text-center"><text class=" text-lg lg:text-base"> {{ $client->client_phone }} </text></div>
                <div class="lg:w-[20%] flex m-auto justify-center p-2">
                    <div class="cursor-pointer bg-zinc-400 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center" onclick="showClientDetails({{strval($index)}});">
                        <i class="material-symbols-outlined text-white">info</i>
                    </div>
                    <a href="/clients/{{ $client->id }}/edit">
                        <div class="mx-2 bg-amber-500 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center">
                            <i class="material-symbols-outlined text-white">edit</i>
                        </div>
                    </a>
                    <a class="linkwithoutlines" onclick="return confirm(`Czy na pewno chcesz usunąć klienta?`)" href="{{ route('clients.delete', $client->id) }}">
                        <div class="bg-red-500 rounded-full h-[2rem] w-[2rem] self-center flex justify-center items-center">
                            <i class="material-symbols-outlined text-white">delete</i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div id="client_details{{strval($index)}}" class="border border-1 rounded-lg px-9 py-6 bg-neutral-100 mx-4" style="display: none;">
            <div class="grid md:grid-cols-2">
                <div class="grid gap-0 h-min text-center lg:text-left pb-5 lg:pb-0 lg:pr-5">
                    <span class="text-lg font-bold">{{ $client->client_name }}</span>
                    <span>{{ $client->client_street.' '.$client->client_house_number }}</span>
                    <span>{{ $client->client_postcode.' '.$client->client_city }}</span>
                    <span>{{ $client->client_nip }}</span>
                </div>
                <div class="grid gap-0 h-min text-center lg:text-left pb-5 lg:pb-0 lg:pr-5">
                    <span class="text-xl">Kontakt:</span>
                    @if(isset($client->client_phone)) <span>tel. {{ $client->client_phone }}</span> @endif
                    @if(isset($client->client_email)) <span>e-mail :{{ $client->client_email }}</span> @endif
                </div>
            </div>
        </div>
        @endforeach
{{--         
        <div class="customers_row">
            <div class="icon_container">
                <div class="customer_icon">
                    <i class="material-symbols-outlined">person</i>
                </div>
            </div>
            <div class="customer_data">
                <div class="customer_name" style="margin: auto;"><text>'; echo $clients[$i]->client_name; echo '</text></div>
                <div class="divider"></div>
                <div class="customer_mail" style="margin: auto;"><text>'; echo $clients[$i]->client_email; echo '</text></div>
                <div class="divider"></div>
                <div class="customer_phone" style="margin: auto;"><text>'; echo $clients[$i]->client_phone; echo '</text></div>
            </div>
            <div class="placing_buttons">
                <div class="info_icon">
                    <i class="material-symbols-outlined">info</i>
                </div>
                <div class="edit_icon">
                    <i class="material-symbols-outlined">edit</i>
                </div>
                <a class="linkwithoutlines" onclick="return confirm(\'Czy na pewno chcesz usunąć klienta?\');" href="/clients/'.$clients[$i]->id.'">
                    <div class="delete_icon">
                        <i class="material-symbols-outlined">delete</i>
                    </div>
                </a>
            </div>
        </div> --}}
    </div>
    <script>
        function showClientDetails($num) {
            if(document.getElementById("client_details"+$num.toString()).style.display != "none") {
                document.getElementById("client_details"+$num.toString()).style.display = "none";
            } else {
                document.getElementById("client_details"+$num.toString()).style.display = "block";
            }
        }
    </script>
</body>
</html>