<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Livewire\InvoiceAdd;

class AddProductRow extends Component
{
    public $index;
    public $loopIndex;
    public $product;
    public $product_fullprice_netto;
    public $product_fullprice_brutto;

    protected $rules = [
        'product.product_name' => 'required|string|max:255',
        'product.number' => 'required',
        'product.price' => 'required',
        'product.vat' => 'required',
        'product.discount' => 'required'
    ];

    public function mount($product)
    {
        $this->product = $product;
        $this->product_fullprice_netto = $product->price * $product->number;
        $this->product_fullprice_brutto = ($product->price * $product->number) * ((100 + $product->vat) / 100);
    }

    public function updateProduct()
    {
        if($this->product->vat < 0) // lub nie liczba
        {
            $this->product->vat = 0;
        }
        else if($this->product->vat > 100) // lub nie liczba
        {
            $this->product->vat = 100;
        }

        if($this->product->discount < 0) // lub nie liczba
        {
            $this->product->discount = 0;
        }
        else if($this->product->discount > 100) // lub nie liczba
        {
            $this->product->discount = 100;
        }
        $this->product_fullprice_netto = ($this->product->price * $this->product->number) * ((100 - $this->product->discount) / 100);
        $this->product_fullprice_brutto = ($this->product->price * $this->product->number * ((100 - $this->product->discount) / 100)) * ((100 + $this->product->vat) / 100);
        $this->emit('productUpdated', [ 'index' => $this->index, 'product' => $this->product ]);
    }

    public function productCounterMinus()
    {
        if($this->product->number > 1)
        {
            if($this->product->number != round($this->product->number)) $this->product->number = floor($this->product->number);
            else $this->product->number--;
            $this->updateProduct();
        }
    }

    public function productCounterPlus()
    {
        if($this->product->number != round($this->product->number)) $this->product->number = ceil($this->product->number);
        else $this->product->number++;
        $this->updateProduct();
    }

    public function productVatMinus()
    {
        if($this->product->vat > 0)
        {
            if($this->product->vat != round($this->product->vat)) $this->product->vat = floor($this->product->vat);
            else $this->product->vat--;
            $this->updateProduct();
        }
    }

    public function productVatPlus()
    {
        if($this->product->vat < 100)
        {
            if($this->product->vat != round($this->product->vat)) $this->product->vat = ceil($this->product->vat);
            else $this->product->vat++;
            $this->updateProduct();
        }
    }

    public function productDiscountMinus()
    {
        if($this->product->discount > 0)
        {
            if($this->product->discount != round($this->product->discount)) $this->product->discount = floor($this->product->discount);
            else $this->product->discount--;
            $this->updateProduct();
        }
    }

    public function productDiscountPlus()
    {
        if($this->product->discount < 100)
        {
            if($this->product->discount != round($this->product->discount)) $this->product->discount = ceil($this->product->discount);
            else $this->product->discount++;
            $this->updateProduct();
        }
    }

    public function deleteProduct($index)
    {
        $this->emit('deleteProduct', $index-1);
    }

    public function render()
    {
        return view('components.livewire.add-product-row');
    }
}
