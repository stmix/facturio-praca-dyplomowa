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
    <link rel="stylesheet" href="invoice_app/css/style.css">
    <link rel="stylesheet" href="invoice_app/css/style_m.css">
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
        <?php
        $userid = Auth::id();
        $products=DB::select("select * from products where owner_id='$userid'");

        for($i=0; $i<count($products); $i++) {

        echo '<div class="products_row">
            <div class="company_icon">
                <i class="material-symbols-outlined">inventory_2</i>
            </div>
            <div id="products_data">
                <div class="product_name">';  echo $products[$i]->product_name; echo '</div>
                <div class="prod_description">';  echo $products[$i]->producent; echo '</div>
                <div class="prod_description">';  echo $products[$i]->product_info; echo '</div>
                <div class="product_name">';  echo $products[$i]->product_price; echo ' zł</div>
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
        </div>';  
        } ?>
    </div>
</body>
</html>