<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\InvoiceStoreRequest;
use Auth;
use App\Models\Invoice;
use App\Models\InvoicesProduct;

class InvoicesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        return view('history');
    }

    public function create() {
        return view('invoice_add');
    }

    public function print($id) {
        return view('invoice_print')->with(['id' => $id]);
    }

    public function status($id_s) {
        $status=DB::select("select is_paid as status from invoices where id=$id_s");
        if($status[0]->status==0) {
            Invoice::where('id',$id_s)->update(array(
                'is_paid'=>1));
        } else if($status[0]->status==1) {
            Invoice::where('id',$id_s)->update(array(
                'is_paid'=>0));
        }
        return redirect('/invoices');
    }

    public function store(InvoiceStoreRequest $request) {
            $validated = $request->validated();

            $invoice=new Invoice;
            $invoice->user_id=Auth::id();

            $invoice->is_paid=isset($request['ispaid']);
            $invoice->paid_from=$validated["paid_from"];
            $invoice->paid_to=$validated["paid_to"];

            $invoice->seller_name=$validated["seller_name"];
            $invoice->seller_street=$validated["seller_street"];
            $invoice->seller_city=$validated["seller_city"];
            $invoice->seller_email=$validated["seller_email"];
            $invoice->seller_nip=$validated["seller_nip"];
            $invoice->seller_house_number=$validated["seller_house_number"];
            $invoice->seller_postcode=$validated["seller_postcode"];
            $invoice->seller_phone=$validated["seller_phone"];

            $invoice->buyer_name=$validated["buyer_name"];
            $invoice->buyer_street=$validated["buyer_street"];
            $invoice->buyer_city=$validated["buyer_city"];
            $invoice->buyer_email=$validated["buyer_email"];
            $invoice->buyer_nip=$validated["buyer_nip"];
            $invoice->buyer_house_number=$validated["buyer_house_number"];
            $invoice->buyer_postcode=$validated["buyer_postcode"];
            $invoice->buyer_phone=$validated["buyer_phone"];

            $invoice->value=$validated["product_fullprice_sum"];

            $invoice->save();

        // $invoice_count=DB::select("select max(id) as invoice_count from invoices");
        // $invoice_id=($invoice_count[0]->invoice_count);
        // $validated = $request->validated();
        // $eok=true;
        // $ispaid=0;
        // if(isset($_POST['ispaid']))
        // {
        //     $ispaid=1;
        // } else {
        //     $ispaid=0;
        // }

        // $paid_from=$_POST['paid_from'];
        // $paid_to=$_POST['paid_to'];

        // $value=0;

        // $seller_name=$validated["seller_name"];
        // $seller_street=$validated["seller_street"];
        // $seller_city=$validated["seller_city"];
        // $seller_email=$validated["seller_email"];
        // $seller_nip=$validated["seller_nip"];
        // $seller_house_number=$validated["seller_house_number"];
        // $seller_postcode=$validated["seller_postcode"];
        // $seller_phone=$validated["seller_phone"];

        // $buyer_name=$validated["buyer_name"];
        // $buyer_street=$validated["buyer_street"];
        // $buyer_city=$validated["buyer_city"];
        // $buyer_email=$validated["buyer_email"];
        // $buyer_nip=$validated["buyer_nip"];
        // $buyer_house_number=$validated["buyer_house_number"];
        // $buyer_postcode=$validated["buyer_postcode"];
        // $buyer_phone=$validated["buyer_phone"];

        // $fullvalue=$_POST['product_fullprice_sum'];
        // $userid=Auth::id();

        // try {
        //     if($eok==true) {
        //         if(DB::insert("insert into invoices values(NULL, '$userid', '$ispaid', '$paid_from', '$paid_to', '$seller_name', '$seller_street', '$seller_city', '$seller_email', '$seller_nip', '$seller_house_number', '$seller_postcode', '$seller_phone', '$buyer_name', '$buyer_street', '$buyer_city', '$buyer_email', '$buyer_nip', '$buyer_house_number', '$buyer_postcode', '$buyer_phone', '$fullvalue', now(), NULL)")) {
        //             $_SESSION['reg_res']='Faktura została dodana do bazy!';
        //         }
        //         else {
        //             throw new Exception("Błąd przy dodawaniu faktury");
        //         }
        //     }

        //     if($eok==false) {
        //         $_SESSION['showreg']=true;
        //     }
        // } catch(Exception $e) {
        //     echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        //     echo '<br/>Informacja developerska: '.$e;
        // }
        $invoice_count=DB::select("select max(id) as invoice_count from invoices");

        for ($i=1; $i <= 10000; $i+=1) {
            $invoice_product = new InvoicesProduct;
            $invoice_product->invoice_id=($invoice_count[0]->invoice_count);
            if(isset($request['product_name'.$i]))
            {
                if($request['product_name'.$i]=='' && $request['product_count'.$i]=='' && $request['product_price'.$i]=='' && $request['product_discount'.$i]=='' && $request['product_fullprice'.$i]=='')
                {
                    continue;
                }

                $invoice_product->product_name=$request['product_name'.$i];
                $invoice_product->number=$request['product_count'.$i];
                $invoice_product->price=$request['product_price'.$i];

                if(isset($request['product_discount'.$i])) {
                    $invoice_product->discount=$request['product_discount'.$i];
                }
                $invoice_product->save();

                // try {
                //     if($eok==true) {
                //         if(DB::insert("insert into invoices_products values(NULL, '$invoice_id', '$prp1', '$prp2', '$prp3', '$prp4', now(), NULL)")) {
                //             $_SESSION['reg_res']='Produkt '.$prp1.' został dodany do bazy!';
                //         }
                //         else {
                //             throw new Exception("Błąd");
                //         }
                //     }

                //     if($eok==false) {
                //         $_SESSION['showreg']=true;
                //     }
                // } catch(Exception $e) {
                //     echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                //     echo '<br/>Informacja developerska: '.$e;
                // }
            }
            if($i==9999) {
                return redirect()->route('invoices.index');
            }
        }
    }
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        DB::delete("DELETE FROM INVOICES_PRODUCTS WHERE INVOICE_ID=$id");

        return redirect('/invoices');
    }
}

    // public function save_invoice() {
    //
        // $ispaid=false;
        // $paid_from=date("yyyy-mm-dd");
        // $paid_to=date("yyyy-mm-dd");
        // $client = (object) [
        //     'name' => '',
        //     'nip' => '',
        //     'address' => '',
        //     'address_2' => '',
        //     'email' => '',
        //     'phone' => '',
        // ];

        // $receiver = (object) [
        //     'name' => '',
        //     'phone' => '',
        //     'street' => '',
        //     'number' => '',
        //     'city' => '',
        //     'postcode' => '',
        // ];

        // $value=0;

    //     if(isset($_POST['ispaid'])) {
    //         $ispaid=true;
    //     }
    // }
/*
    public function save_invoice(Request $request) {
        $eok=true;

        if(isset($_POST['ispaid']))
        {
            $ispaid=true;
        }
        else {
            $ispaid=false;
        }
        $paid_from=$_POST['paid_from'];
        $paid_to=$_POST['paid_to'];
        $client['name']=$_POST['client_name'];

        if(isset($_POST['client_nip']) && InvoicesController::validateNIP($_POST['client_nip'])==true) {
            $client['nip']=$_POST['client_nip'];
        }
        $client['address']=$_POST['client_address'];
        if(isset($_POST['client_address_2'])) {
            $client['address_2']=$_POST['client_address_2'];
        }
        if(isset($_POST['client_email'])) {
            $client['email']=$_POST['client_email'];
        }
        if(isset($_POST['client_phone'])) {
            $client['phone']=$_POST['client_phone'];
        }

        $validated=$request->validate([
            'client.name' => 'required|min:3|max:255',
        ]);

        if(isset($_POST['receiver_name'])) {
            $receiver['name']=$_POST['receiver_name'];
        }
        if(isset($_POST['receiver_phone'])) {
            $receiver['phone']=$_POST['receiver_phone'];
        }
        if(isset($_POST['receiver_street'])) {
            $receiver['street']=$_POST['receiver_street'];
        }
        if(isset($_POST['receiver_house_number'])) {
            $receiver['house_number']=$_POST['receiver_house_number'];
        }
        if(isset($_POST['receiver_city'])) {
            $receiver['city']=$_POST['receiver_city'];
        }
        if(isset($_POST['receiver_postcode'])) {
            $receiver['postcode']=$_POST['receiver_postcode'];
        }


        echo $ispaid;
        echo '<br>';
        echo $paid_from;
        echo '<br>';
        echo $paid_to;
        echo '<br>';
        dump($client);
        echo '<br>';
        dd($receiver);
        echo '<br>';

        /*$value=0;

        $products_count=1;
        while(isset($_POST['product_name'.$products_count])) {
            $products_count+=1;
        }
        $products_count-=1;

        for ($i=1; $i <= $products_count; $i++) {
            if($_POST['product_name'.$i]=='' && $_POST['product_count'.$i]=='' && $_POST['product_price'.$i]=='' && $_POST['product_discount'.$i]=='' && $_POST['product_fullprice'.$i]=='')
            {
                continue;
            }

            $prp1=$_POST['product_name'.$i];
            if($prp1=='')
            {
                $eok=false;
                $_SESSION['epr_name']='Nazwa produktu nie może pozostać pusta!';
            }


            $prp2=$_POST['product_count'.$i];



            $prp3=$_POST['product_price'.$i];
            if($prp1=='')
            {
                $eok=false;
                $_SESSION['epr_name']='Nazwa produktu nie może pozostać pusta!';
            }


            $prp4=$_POST['product_discount'.$i];
            if($prp1=='')
            {
                $eok=false;
                $_SESSION['epr_name']='Nazwa produktu nie może pozostać pusta!';
            }


            $prp5=$_POST['product_fullprice'.$i];
            if($prp1=='')
            {
                $eok=false;
                $_SESSION['epr_name']='Nazwa produktu nie może pozostać pusta!';
            }

            try {
                $invoiceid=$_SESSION['invoice_id'];
                if($eok==true) {
                    if(DB::insert("insert into invoices_products values(NULL, $invoiceid, '$prp1', '$prp2', '$prp3', '$prp4', now(), NULL)")) {
                        $_SESSION['reg_res']='Produkt '.$prp1.' został dodany do bazy!';
                    }
                    else {
                        throw new Exception("Błąd");
                    }
                }

                if($eok==false) {
                    $_SESSION['showreg']=true;
                }
            } catch(Exception $e) {
                echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                echo '<br/>Informacja developerska: '.$e;
            }
        }
        return redirect()->route('gotologinform');
    }
    public function validateNIP($nip)
    {
        //Check length
        if ($nip == null)
            return false;
        $nip = $nip.replace('-', '');
        if ($nip.length != 10)
            return false;

        //Check digits
        for ($i=0; $i<10; $i++)
            if (isNaN($nip[$i]))
                return false;

        //Check checkdigit
        $sum = 6 * $nip[0] +
        5 * $nip[1] +
        7 * $nip[2] +
        2 * $nip[3] +
        3 * $nip[4] +
        4 * $nip[5] +
        5 * $nip[6] +
        6 * $nip[7] +
        7 * $nip[8];
        $sum %= 11;
        if ($nip[9] != $sum)
            return false;

        return true;
    }
}
*/
