<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoicesProduct;
use App\Models\InvoicesProducts;
use DateTimeImmutable;
use GusApi\BulkReportTypes;
use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use GusApi\ReportTypes;
use Livewire\Component;
use App\Models\Product;
use App\Models\Settings;

class InvoiceAdd extends Component
{
    protected $listeners = [
        'productUpdated' => 'handleProductUpdate',
        'updateProductPrice' => 'updateProductPrice',
        'deleteProduct'
    ];

    public $rules = [
            'sale_date' => 'required',
            'payment_deadline' => 'required',

            'seller_name' => 'required|min:3|max:255',
            'seller_street' => 'required|min:3|max:255',
            'seller_city' => 'required|min:3|max:255',
            'seller_email' => 'nullable|min:3|max:255|email',
            'seller_nip' => 'required|NIP',
            'seller_house_number' => 'required',
            'seller_postcode' => 'required',
            'seller_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',

            'buyer_name' => 'required|min:3|max:255',
            'buyer_street' => 'required|min:3|max:255',
            'buyer_city' => 'required|min:3|max:255',
            'buyer_email' => 'nullable|min:3|max:255|email',
            'buyer_nip' => 'required|NIP',
            'buyer_house_number' => 'required|numeric',
            'buyer_postcode' => 'required|post_code',
            'buyer_phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',

            'invoiceFullpriceNetto' => 'required',

            'note' => 'nullable|min:3'
        ];

    public $products;
    public $clients;

    public $invoice_num;
    public $place;
    public $is_paid;
    public $sale_date;
    public $payment_deadline;

    public $seller_name;
    public $seller_nip;
    public $seller_street;
    public $seller_house_number;
    public $seller_city;
    public $seller_postcode;
    public $seller_email;
    public $seller_phone;

    public $buyer_name;
    public $buyer_nip;
    public $buyer_street;
    public $buyer_house_number;
    public $buyer_city;
    public $buyer_postcode;
    public $buyer_email;
    public $buyer_phone;

    public $productsList;
    public $invoiceFullpriceNetto;
    public $invoiceFullpriceBrutto;

    public $invoiceDiscountTotal;
    public $invoiceVatTotal;
    public $note;
    public $clientIndex;
    public $productIndex = [];

    public function mount()
    {
        $month = now()->format('m/Y');
        $lastInvoiceThisMonth = Invoice::where('invoice_num', 'like', "%$month")
        ->orderBy('invoice_num', 'desc')
        ->first();
        if($lastInvoiceThisMonth)
            $this->invoice_num = str_pad((((int)explode('/', $lastInvoiceThisMonth->invoice_num)[0])+1), 5, '0', STR_PAD_LEFT).date('/m/Y');
        else
            $this->invoice_num = '00001'.date('/m/Y');
        $this->productsList = collect([new Product([
            'product_name' => '',
            'number' => 1,
            'price' => 0,
            'vat' => 23,
            'discount' => 0
        ])]);
        $this->products = Product::where('owner_id', auth()->user()->id)->get();
        $this->clients = Client::where('owner_id', auth()->user()->id)->get();

        $this->is_paid = false;
        $this->place = "Gdańsk";
        $this->sale_date = date('Y-m-d');
        $this->payment_deadline = date('Y-m-d', strtotime('+2 weeks', strtotime($this->sale_date)));
    }

    public function getSellerDataFromSettings()
    {
        $settings = Settings::where('id', auth()->user()->id)->first();
        $this->seller_name = $settings->name;
        $this->seller_street = $settings->street;
        $this->seller_nip = $settings->nip;
        $this->seller_house_number = $settings->house_number;
        $this->seller_city = $settings->city;
        $this->seller_postcode = $settings->postcode;
        $this->seller_email = $settings->email;
        $this->seller_phone = $settings->phone;
    }

    public function getSellerDataFromApi()
    {
        $this->seller_name = "";
        $this->seller_street = "";
        $this->seller_house_number = "";
        $this->seller_city = "";
        $this->seller_postcode = "";
        $this->seller_email = "";
        $this->seller_phone = "";

        $seller_nip_copy = json_decode(json_encode($this->seller_nip),true);
        $seller_nip_copy = preg_replace("/[^0-9]/", "", $this->seller_nip);
        $gus = new GusApi('b666914c9b084287ac4b');

        try {
            $nipToCheck = $seller_nip_copy;
            $gus->login();
            $gusReports = $gus->getByNip($nipToCheck);
            if($gusReports)
            {
                $gusReport = $gusReports[0];
                $this->seller_name = $gusReport->getName();
                if($gusReport->getCity() == $gusReport->getPostCity()) $this->seller_street = $gusReport->getStreet();
                else $this->seller_street = $gusReport->getCity().' '.$gusReport->getStreet();
                if($gusReport->getApartmentNumber() != "") $this->seller_house_number = $gusReport->getPropertyNumber().'/'.$gusReport->getApartmentNumber();
                else $this->seller_house_number = $gusReport->getPropertyNumber();
                $this->seller_city = $gusReport->getPostCity();
                $this->seller_postcode = $gusReport->getZipCode();
            }
        } catch (InvalidUserKeyException $e) {
            $this->seller_nip = "Błąd!";
        } catch (NotFoundException $e) {
            $this->seller_nip = "Nie znaleziono";
        }
        catch (\Exception $e) {
            $this->seller_nip = "Coś poszło nie tak";
        }
    }

    public function getBuyerDataFromDatabase()
    {
        $data = Client::where('id', $this->clientIndex)->first();
        if($data != null)
        {
            $this->buyer_name = $data->client_name;
            $this->buyer_street = $data->client_street;
            $this->buyer_nip = $data->client_nip;
            $this->buyer_house_number = $data->client_house_number;
            $this->buyer_city = $data->client_city;
            $this->buyer_postcode = $data->client_postcode;
            $this->buyer_email = $data->client_email;
            $this->buyer_phone = $data->client_phone;
        }
        else
        {
            $this->buyer_name = "";
            $this->buyer_street = "";
            $this->buyer_nip = "";
            $this->buyer_house_number = "";
            $this->buyer_city = "";
            $this->buyer_postcode = "";
            $this->buyer_email = "";
            $this->buyer_phone = "";
        }
    }

    public function getProductDataFromDatabase($index)
    {
        $product = Product::where('id', $this->productIndex[$index])->first();

        $this->productsList[$index] = collect($this->productsList[$index])
        ->tap(function ($item) use ($product) {
            if (isset($product)) {
                $item['product_name'] = $product->product_name;
                $item['price'] = $product->product_price;
            }
            else
            {
                $item['product_name'] = "";
                $item['price'] = 0;
            }
        })
        ->toArray();
    }

    public function getBuyerDataFromApi()
    {
        $this->buyer_nip = json_decode(json_encode($this->buyer_nip),true);
        $buyer_nip_copy = preg_replace("/[^0-9]/", "", $this->buyer_nip);
        $gus = new GusApi('b666914c9b084287ac4b');

        $this->buyer_name = "";
        $this->buyer_street = "";
        $this->buyer_house_number = "";
        $this->buyer_city = "";
        $this->buyer_postcode = "";
        $this->buyer_email = "";
        $this->buyer_phone = "";

        try {
            $nipToCheck = $buyer_nip_copy; //change to valid nip value
            $gus->login();

            $gusReports = $gus->getByNip($nipToCheck);
            if($gusReports)
            {
                $gusReport = $gusReports[0];
                $this->buyer_name = $gusReport->getName();
                if($gusReport->getCity() == $gusReport->getPostCity()) $this->buyer_street = $gusReport->getStreet();
                else $this->buyer_street = $gusReport->getCity().' '.$gusReport->getStreet();
                if($gusReport->getApartmentNumber() != "") $this->buyer_house_number = $gusReport->getPropertyNumber().'/'.$gusReport->getApartmentNumber();
                else $this->buyer_house_number = $gusReport->getPropertyNumber();
                $this->buyer_city = $gusReport->getPostCity();
                $this->buyer_postcode = $gusReport->getZipCode();
            }
        } catch (InvalidUserKeyException $e) {
            $this->buyer_nip = "Błąd!";
        } catch (NotFoundException $e) {
            $this->buyer_nip = "Nie znaleziono";
        }
        catch (\Exception $e) {
            $this->buyer_nip = "Coś poszło nie tak";
        }
    }

    public function addProduct()
    {
        $product = new Product([
            'product_name' => '',
            'number' => 1,
            'price' => 0,
            'vat' => 23,
            'discount' => 0
        ]);

        $this->productsList[] = $product;
    }

    public function updateProduct()
    {
        $this->productsList = $this->productsList->map(function ($item) {
            $item['number'] = str_replace(',', '.', $item['number']);
            $item['price'] = str_replace(',', '.', $item['price']);
            $item['vat'] = str_replace(',', '.', $item['vat']);
            $item['discount'] = str_replace(',', '.', $item['discount']);

            if (!is_numeric($item['number'])) {
                $item['number'] = 1;
            }
            if (!is_numeric($item['price'])) {
                $item['price'] = 0;
            }
            if (!is_numeric($item['vat'])) {
                $item['vat'] = 23;
            }
            if (!is_numeric($item['discount'])) {
                $item['discount'] = 0;
            }

            if ($item['number'] < 0) {
                $item['number'] = 0;
            }
            if ($item['vat'] < 0) {
                $item['vat'] = 0;
            }
            else if($item['vat'] > 100) // lub nie liczba
            {
                $item['vat'] = 100;
            }
            if($item['discount'] < 0) // lub nie liczba
            {
                $item['discount'] = 0;
            }
            else if($item['discount'] > 100) // lub nie liczba
            {
                $item['discount'] = 100;
            }

            $item['price'] = number_format((float)$item['price'], 2, '.', '');

            return $item;
        });

        $this->invoiceFullpriceNetto = 0;
        $this->invoiceFullpriceBrutto = 0;
        $this->invoiceDiscountTotal = 0;
        $this->invoiceVatTotal = 0;
        foreach($this->productsList as $product)
        {
            $this->invoiceDiscountTotal += $product['number'] * $product['price'] * ($product['discount'] / 100);
            $this->invoiceVatTotal += ($product['price'] * $product['number'] * ((100 - $product['discount']) / 100)) * ($product['vat'] / 100);
            $this->invoiceFullpriceNetto += $product['price'] * $product['number'] * ((100 - $product['discount']) / 100);
            $this->invoiceFullpriceBrutto += ($product['price'] * $product['number'] * ((100 - $product['discount']) / 100)) * ((100 + $product['vat']) / 100);
        }
    }

    public function productCounterMinus($index)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index) {
            if ($key == $index && $item['number'] > 0) {
                if ($item['number'] != round($item['number'])) {
                    $item['number'] = floor($item['number']);
                } else {
                    $item['number']--;
                }
            }
            return $item;
        });
    }

    public function productCounterPlus($index)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index) {
            if ($key == $index) {
                if ($item['number'] != round($item['number'])) {
                    $item['number'] = ceil($item['number']);
                } else {
                    $item['number']++;
                }
            }
            return $item;
        });
    }

    public function productVatMinus($index)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index) {
            if ($key == $index && $item['vat'] > 0) {
                if ($item['vat'] != round($item['vat'])) {
                    $item['vat'] = floor($item['vat']);
                } else {
                    $item['vat']--;
                }
            }
            return $item;
        });
    }

    public function productVatPlus($index)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index) {
            if ($key == $index && $item['vat'] < 100) {
                if ($item['vat'] != round($item['vat'])) {
                    $item['vat'] = ceil($item['vat']);
                } else {
                    $item['vat']++;
                }
            }
            return $item;
        });
    }

    public function productDiscountMinus($index)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index) {
            if ($key == $index && $item['discount'] > 0) {
                if ($item['discount'] != round($item['discount'])) {
                    $item['discount'] = floor($item['discount']);
                } else {
                    $item['discount']--;
                }
            }
            return $item;
        });
    }

    public function productDiscountPlus($index)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index) {
            if ($key == $index && $item['discount'] < 100) {
                if ($item['discount'] != round($item['discount'])) {
                    $item['discount'] = ceil($item['discount']);
                } else {
                    $item['discount']++;
                }
            }
            return $item;
        });
    }

    public function deleteProduct($index)
    {
        unset($this->productsList[$index]);
    }

    public function updateProductPrice($index, $price)
    {
        $this->productsList = $this->productsList->map(function ($item, $key) use ($index, $price) {
            if ($key == $index) {
                    $item['price'] = $price;
            }
            return $item;
        });
        $this->updateProduct();
    }

    public function createInvoice()
    {
        $this->validate();

        $invoice = new Invoice([
            'user_id' => auth()->user()->id,
            'invoice_num' => $this->invoice_num,
            'place' => $this->place,
            'is_paid' => $this->is_paid,
            'sale_date' => $this->sale_date,
            'payment_deadline' => $this->payment_deadline,
            'seller_name' => $this->seller_name,
            'seller_street' => $this->seller_street,
            'seller_city' => $this->seller_city,
            'seller_email' => $this->seller_email,
            'seller_nip' => $this->seller_nip,
            'seller_house_number' => $this->seller_house_number,
            'seller_postcode' => $this->seller_postcode,
            'seller_phone' => $this->seller_phone,
            'buyer_name' => $this->buyer_name,
            'buyer_street' => $this->buyer_street,
            'buyer_city' => $this->buyer_city,
            'buyer_email' => $this->buyer_email,
            'buyer_nip' => $this->buyer_nip,
            'buyer_house_number' => $this->buyer_house_number,
            'buyer_postcode' => $this->buyer_postcode,
            'buyer_phone' => $this->buyer_phone,
            'discount_total' => $this->invoiceDiscountTotal,
            'vat_total' => $this->invoiceVatTotal,
            'value_netto' => $this->invoiceFullpriceNetto,
            'note' => $this->note,
        ]);
        $invoice->save();

        foreach($this->productsList as $prod)
        {
            $product = new InvoicesProduct([
                'invoice_id' => $invoice->id,
                'product_name' => $prod['product_name'],
                'number' => $prod['number'],
                'price' => $prod['price'],
                'vat' => $prod['vat'],
                'discount' => $prod['discount']
            ]);
            $product->save();
        }

        return redirect(route('invoices.index'));
    }

    public function render()
    {
        return view('livewire.invoice-add');
    }
}
