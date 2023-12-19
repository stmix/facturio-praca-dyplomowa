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
    <link rel="stylesheet" href="invoice_app/css/style.css">
    <link rel="stylesheet" href="invoice_app/css/style_d.css">
</head>
<body>

    @include('navbar');
    <div class="page">
        <div class="say-hi">
            <div class="history_header">
        <text> Historia </text>
   
        <div class="time_button">
                <text>
                    Month
                </text>
                <i class="material-symbols-outlined">arrow_drop_down</i>

            </div>

        </div>

        </div>
        <?php
            $userid = Auth::id();
            $invoices=DB::select("select * from invoices where user_id='$userid'");

        for($i=0; $i<count($invoices); $i++)
        {
            $invid = $invoices[$i]->id;
            $products=DB::select("select * from invoices_products where invoice_id = $invid");
        echo
            '<div style="margin: 20px;">
                <div class="transactions_row">
                    <div style="flex:1">
                        <div class="company_icon" >
                        <i class="material-symbols-outlined">attach_money</i>
                        </div>
                    </div>
                    <div style="flex:3"><text class="company_name">'; echo $invoices[$i]->buyer_name; echo '</text></div>
                    <div style="flex:2"><text class="company_date">'; echo date("d M Y", strtotime($invoices[$i]->paid_from)); echo '</text></div>
                    <div style="flex:2"><text class="company_price">'; echo $invoices[$i]->value; echo ' zł</text></div>
                    <div class="status_paid"'; if(($invoices[$i]->is_paid)==0) { echo 'style="background-color: red;"'; } echo '>
                        <text class="status"">'; if(($invoices[$i]->is_paid)==0) { echo 'Nieopłacona'; } else { echo 'Opłacona'; } echo '</text>
                    </div>
                    <div class="menage_buttons">
                        <div class="info_icon" onclick="showInvoiceDetails('.strval($i).');">
                            <i class="material-symbols-outlined">info</i>
                        </div>
                        <a class="linkwithoutlines" onclick="return confirm(\'Czy na pewno chcesz zmienić status faktury na '; if(($invoices[$i]->is_paid)==0) { echo 'opłacony'; } else { echo 'nieopłacony'; } echo '?\')" href="/invoices/status/'.$invoices[$i]->id.'">
                            <div class="edit_icon">
                                <i class="material-symbols-outlined">edit</i>
                            </div>
                        </a>
                        <a class="linkwithoutlines" onclick="return confirm(\'Czy na pewno chcesz usunąć fakturę?\');" href="/invoices/delete/'.$invoices[$i]->id.'">
                            <div class="delete_icon">
                                <i class="material-symbols-outlined">delete</i>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="invoice_details'.strval($i).'" class="invoice_details" style="display: none;">
                    <div style="flex: 1;"><h3>Sprzedawca:</h3><br/>'; echo '<h4>'.$invoices[$i]->seller_name.'</h4><br/>&nbsp;&nbsp;'.$invoices[$i]->seller_street.' '.$invoices[$i]->seller_house_number.'<br/>&nbsp;&nbsp;'.$invoices[$i]->seller_postcode.' '.$invoices[$i]->seller_city.'<br/>&nbsp;&nbsp;'.$invoices[$i]->seller_nip.'<br/>&nbsp;&nbsp;'.$invoices[$i]->seller_phone.'<br/>&nbsp;&nbsp;'.$invoices[$i]->seller_email.'<br/></div>'; echo '
                    <hr/><div style="padding-left:20px; padding-right:20px; flex: 2;">
                    <h3>Produkty:</h3><br/><hr/>
                    <h4><div style="display: flex; text-align: center;"><hr/>
                        <div style="flex: 3;"></div><hr/>
                        <div style="flex: 3;">Liczba</div><hr/>
                        <div style="flex: 3;">Cena za szt.</div><hr/>
                    </div><hr/></h4>';
                    for($j=0; $j<count($products); $j++)
                    {
                        echo '<div style="display: flex; text-align: center;">';
                        echo '<hr/><div style="flex: 3;"> <h5>'.$products[$j]->product_name.'</h5></div><hr/>';
                        echo '<div style="flex: 3; font-size: 12px;">'.$products[$j]->number.'</div><hr/>';
                        echo '<div style="flex: 3; font-size: 12px;">'.$products[$j]->price.' zł</div><hr/>';
                        echo '</div><hr/>';
                    }
                    echo '<div style="padding-top: 20px;">
                    <a class="linkwithoutlines" href="invoices/print/'.$invoices[$i]->id.'" target="_blank"><div class="edit_icon" style="margin: auto; vertical-align: middle;">
                        <i class="material-symbols-outlined">download</i>
                    </div>
                    </a>
                    </div>
                </div>
                    <hr/>
                    <div style="flex:1; text-align: right;" ><h3>Nabywca:</h3><br/>'; echo '<h4>'.$invoices[$i]->buyer_name.'</h4><br/>&nbsp;&nbsp;'.$invoices[$i]->buyer_street.' '.$invoices[$i]->buyer_house_number.'<br/>&nbsp;&nbsp;'.$invoices[$i]->buyer_postcode.' '.$invoices[$i]->buyer_city.'<br/>&nbsp;&nbsp;'.$invoices[$i]->buyer_nip.'<br/>&nbsp;&nbsp;'.$invoices[$i]->buyer_phone.'<br/>&nbsp;&nbsp;'.$invoices[$i]->buyer_email.'<br/></div>'; echo '
                </div>
            </div>
            
            ';
        }
        ?>
    </div>
</body>
</html>
<script>
    function showInvoiceDetails($num) {
        if(document.getElementById("invoice_details"+$num.toString()).style.display != "none") {
            document.getElementById("invoice_details"+$num.toString()).style.display = "none";
        } else {
            document.getElementById("invoice_details"+$num.toString()).style.display = "flex";
        }
    }
</script>