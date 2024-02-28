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
    <link rel="stylesheet" href="invoice_app/css/style.css">
    <link rel="stylesheet" href="invoice_app/css/style_matk.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>
<body>
    @include('navbar');
    <div class="page" >
        <div class="top_row" >
            <div class="customers_header">
                <text> Odbiorcy </text>
                <!-- <div class="top_button" style="margin-left: 35%">
                    <text> Imie </text>
                    <i class="material-symbols-outlined">arrow_drop_down</i>
                </div>
                <div class="top_button" style="margin-left: -10%">
                    <text> Sortuj </text>
                    <i class="material-symbols-outlined">arrow_drop_down</i>
                </div> -->
                <a class="linkwithoutlines" href="/clients/add">
                    <div class="add_button">
                        <text>
                            Dodaj
                        </text>
                        <i class="material-symbols-outlined">add</i>
                    </div>
                </a>
            </div>
        </div>
        <?php
        $userid = Auth::id();
        $clients=DB::select("select * from clients where owner_id='$userid'");

        for($i=0; $i<count($clients); $i++) {
        echo '
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
        </div>'; } ?>
    </div>
    
</body>
</html>