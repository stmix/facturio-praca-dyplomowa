<?php
    $_SESSION['open']='index';
    $thisPage = "Dashboard";

    $userid = Auth::id();
    $products=DB::select("select * from products where owner_id='$userid'");
    $clients=DB::select("select * from clients where owner_id='$userid'");
    $invoices=DB::select("select * from invoices where user_id='$userid'");
    $invoices_sum=DB::select("select sum(value) as invoices_sum from invoices where user_id='$userid'")[0]->invoices_sum;
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
    <link rel="stylesheet" href="invoice_app/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


</head>
<body>
    @include('navbar');
    
  <div class="page">
        <div class="say-hi">
            <text>
                Witaj, <?php echo Auth::user()['name'];?> 👋
            </text>
            <img src="https://i.pinimg.com/236x/4e/45/88/4e458893b1fdc033508016e09fa5553c.jpg" alt="avatar" class="avatar">

            <button>
                <i class="material-symbols-outlined">notifications</i>
            </button>
            
        </div>
        <div class="summary">
        
            <text> Ogólny przegląd </text>

            <div class="summary_items">
            <div class="containter">
            <i class="material-symbols-outlined">grade</i>
            <text>Odbiorcy</text>
            <text class="value"><?php echo $clients_count; ?></text>
            </div>
            <div class="containter">
            <i class="material-symbols-outlined">inventory_2</i>
            <text>Produkty</text>
            <text class="value"><?php echo $products_count; ?></text>
            </div>
            <div class="containter">
            <i class="material-symbols-outlined">request_page</i>
            <text>Faktury</text>
            <text class="value"><?php echo $invoices_count; ?></text>
            </div>
            <div class="containter">
            <i class="material-symbols-outlined">attach_money</i>
            <text>Zafakturowane</text>
            <text class="value_money"><?php echo number_format($invoices_sum, 2, ".", " ").' zł'; ?></text>

            </div>
            </div>

        </div>
        <div class="recent_transactions">
        <text>Ostatnie transakcje </text>
        <?php
            $userid = Auth::id();
            $invoices=DB::select("select * from invoices where user_id='$userid'");
            
        for($i=0; $i<min(count($invoices),5); $i++)
        {

        echo '<a class="linkwithoutlines" href="/invoices"><div class="transactions_row" style="margin: 20px;">
            <div class="company_icon">
            <i class="material-symbols-outlined">attach_money</i>
            </div>
            <b><text class="company_name">'; echo $invoices[$i]->buyer_name; echo '
            </text></b>
            <text class="company_date">'; echo date("d M Y", strtotime($invoices[$i]->paid_from)); echo '</text>
            <b><text class="company_name">'; echo $invoices[$i]->value; echo ' zł</text></b>
            <div class="status_paid"'; if(($invoices[$i]->is_paid)==0) { echo 'style="background-color: red;"'; } echo '>
                <text class="status">'; if(($invoices[$i]->is_paid)==0) { echo 'Nieopłacona'; } else { echo 'Opłacona'; } echo '</text>
            </div>
        </div></a>';
        } ?>


        </div>

        </div>
</body>
</html>