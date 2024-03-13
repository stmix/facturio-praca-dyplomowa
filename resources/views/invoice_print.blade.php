<?php
    $userid = Auth::id();
    $invoice=DB::select("select * from invoices where id='$id' and user_id='$userid'");
    if(count($invoice)==0) {
        echo '<script>alert("Wybrana faktura nie jest dostępna lub zalogowany uytkownik nie posiada do niej dostępu!");</script>';
        echo ("<div style='font-family: Arial; text-align: center; padding-top: 100px;'><h1 style='
        vertical-align:middle;'>BRAK FAKTURY</h1><button style='height: 50px; font-size: 20px;'>Powrót</button></div>");
        return;
    } else {
        $invoice=$invoice[0];
    }
    $products=DB::select("select * from invoices_products where invoice_id = $invoice->id");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../../invoice_app/css/style_invoice.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	</head>
	<body>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Faktura #<?php echo $invoice->id ?><br />
									Utworzono: <?php echo $invoice->created_at ?><br />
									Zapłata do: <?php echo $invoice->payment_deadline ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="6">
						<table>
							<tr>
								<td>
                                    <b style="font-size: 20px;">Sprzedawca:</b><br/>
                                    <?php echo $invoice->seller_name ?><br />
                                    <b>NIP:</b> <?php echo $invoice->seller_nip ?><br />
                                    <?php echo $invoice->seller_street.' '.$invoice->seller_house_number ?><br />
                                    <?php echo $invoice->seller_postcode.' '.$invoice->seller_city ?><br/><br/>
                                    <b>tel.</b> <?php echo $invoice->seller_phone ?><br />
                                    <b>e-mail:</b> <?php echo $invoice->seller_email ?><br />
                                    </td>


								<td>
                                    <b style="font-size: 20px;">Nabywca:</b><br/>
                                    <?php echo $invoice->buyer_name ?><br />
                                    <b>NIP:</b> <?php echo $invoice->buyer_nip ?><br />
                                    <?php echo $invoice->buyer_street.' '.$invoice->buyer_house_number ?><br />
                                    <?php echo $invoice->buyer_postcode.' '.$invoice->buyer_city ?><br/><br/>
                                    <b>tel.</b> <?php echo $invoice->buyer_phone ?><br />
                                    <b>e-mail:</b> <?php echo $invoice->buyer_email ?><br />
								</td>
							</tr>
						</table>
					</td>
				</tr>


				<tr class="heading">
					<td>Adres dostawy</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Status (Opłacona/Nie opłacona)</td>
				</tr>

				<tr class="details">
					<td>
                    <?php echo $invoice->buyer_name ?><br />
                    <?php echo $invoice->buyer_street.' '.$invoice->buyer_house_number ?><br />
                    <?php echo $invoice->buyer_postcode ?>
                    <?php echo $invoice->buyer_city ?><br/>
                    <b>tel.</b> <?php echo $invoice->buyer_phone ?><br />
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
					<td><?php if($invoice->is_paid) { echo "Opłacona"; } else { echo "Nieopłacona"; } ?></td>
				</tr>

				<tr class="heading">
					<td>Nazwa produktu</td>
					<td></td>
					<td>Ilość</td>
                    <td>Cena</td>
					<td>Rabat</td>
					<td>Suma</td>
				</tr>
                <?php
                    for($j=0; $j<count($products); $j++)
                    {
                        echo '<tr class="item">
                            <td>'.$products[$j]->product_name.'</td>
                            <td></td>
                            <td>'.$products[$j]->number.'</td>
                            <td>'.$products[$j]->price.' zł</td>
                            <td>'.$products[$j]->discount.'</td>
                            <td>'.($products[$j]->number)*($products[$j]->price).' zł</td>
                        </tr>';
                    }
                ?>
				</td>
				<tr class="sum">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo number_format($invoice->value_netto, 2, ".", " ") ?> zł</td>
				</tr>
			</table>
		</div>
	</body>
</html>
<?php
    // $url = '.';
    // $localFile = '.';
    // $apiKey = 'a04aca8f-d89c-43f7-acee-4c48329945d2';
    // require('SelectPdf.Api.php');

    // $client = new SelectPdf\Api\HtmlToPdfClient($apiKey);
    // $client->setPageSize(SelectPdf\Api\PageSize::A4);
    // $client->convertUrlToFile($url, $localFile);
?>
