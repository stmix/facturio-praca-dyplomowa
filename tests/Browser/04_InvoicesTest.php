<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class InvoicesTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testCreateInvoice(): void
    {
        $this->loginForTests();
        $this->browse(function (Browser $browser) {
            $faker = Faker::create('pl_PL');
            $browser->assertPathIs('/main')
                ->click('li#invoice_nav')
                ->assertPathIs('/invoices/add')
                ->assertSee('Nowa faktura')
                ->click('label#ispaid_label')
                ->type('input#paid_from', date('d.m.Y', strtotime('-5 days')))
                ->type('input#paid_to', date('d.m.Y', strtotime('+6 days')));

            $browser->type('input#seller_name', $faker->company)->pause(100)
                ->type('input#seller_street', $faker->streetName)->pause(100)
                ->type('input#seller_city', $faker->city)->pause(100)
                ->type('input#seller_email', $faker->email)->pause(100)
                ->type('input#seller_nip', $faker->taxpayerIdentificationNumber)->pause(100)
                ->type('input#seller_house_number', $faker->buildingNumber)->pause(100)
                ->type('input#seller_postcode', $faker->postcode)->pause(100)
                ->type('input#seller_phone', $faker->phoneNumber)->pause(100);

            $browser->type('input#buyer_name', $faker->company)->pause(100)
                ->type('input#buyer_street', $faker->streetName)->pause(100)
                ->type('input#buyer_city', $faker->city)->pause(100)
                ->type('input#buyer_email', $faker->email)->pause(100)
                ->type('input#buyer_nip', $faker->taxpayerIdentificationNumber)->pause(100)
                ->type('input#buyer_house_number', $faker->buildingNumber)->pause(100)
                ->type('input#buyer_postcode', $faker->postcode)->pause(100)
                ->type('input#buyer_phone', $faker->phoneNumber)->pause(100)
                ->type('input#product_input0', $faker->word);
                for ($i = 0; $i < 14; $i++) {
                    $browser->click('div#product_count_plus0')->pause(50);
                }
                $browser->assertValue('input#product_count_input0', 15);
                for ($i = 0; $i < 5; $i++) {
                    $browser->click('div#product_count_minus0')->pause(50);
                }
                $browser->assertValue('input#product_count_input0', 10)
                ->type('input#product_price_input0', $faker->randomFloat(2, 0, 999))
                ->click('div#product_vat_minus0')->pause(50)
                ->click('div#product_vat_minus0')->pause(50)
                ->click('div#product_vat_minus0')->pause(50)
                ->assertValue('input#product_vat_input0', 20)
                ->click('div#product_vat_plus0')->pause(50)
                ->click('div#product_vat_plus0')->pause(50)
                ->click('div#product_vat_plus0')->pause(50)
                ->assertValue('input#product_vat_input0', 23);
                for ($i = 0; $i < 12; $i++) {
                    $browser->click('div#product_discount_plus0')->pause(50);
                }
                $browser->assertValue('input#product_discount_input0', 12)
                ->click('div#product_discount_minus0')->pause(50)
                ->click('div#product_discount_minus0')->pause(50)
                ->assertValue('input#product_discount_input0', 10)
                ->assertScript('Math.abs(parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 + (parseFloat(document.querySelector("input#product_vat_input0").value))) / 100) * ((100 - (parseFloat(document.querySelector("input#product_discount_input0").value))) / 100) - (parseFloat(document.querySelector("input#brutto_price_input0").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->click("li#add_next_product_button")->pause(50)
                ->type('input#product_input1', $faker->word);
                for ($i = 0; $i < 4; $i++) {
                    $browser->click('div#product_count_plus1')->pause(50);
                }
                $browser->assertValue('input#product_count_input1', 5)
                ->type('input#product_price_input1', $faker->randomFloat(2, 0, 999));
                for ($i = 0; $i < 18; $i++) {
                    $browser->click('div#product_vat_minus1')->pause(50);
                }
                $browser->assertValue('input#product_vat_input1', 5);
                for ($i = 0; $i < 5; $i++) {
                    $browser->click('div#product_discount_plus1')->pause(50);
                }
                $browser->assertValue('input#product_discount_input1', 5)
                ->assertScript('Math.abs(parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 + (parseFloat(document.querySelector("input#product_vat_input1").value))) / 100) * ((100 - (parseFloat(document.querySelector("input#product_discount_input1").value))) / 100) - (parseFloat(document.querySelector("input#brutto_price_input1").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->click("li#add_next_product_button")->pause(50)
                ->type('input#product_input2', $faker->word);
                for ($i = 0; $i < 17; $i++) {
                    $browser->click('div#product_count_plus2')->pause(50);
                }
                $browser->assertValue('input#product_count_input2', 18);
                for ($i = 0; $i < 3; $i++) {
                    $browser->click('div#product_count_minus2')->pause(50);
                }
                $browser->assertValue('input#product_count_input2', 15)
                ->type('input#product_price_input2', $faker->randomFloat(2, 0, 999));
                for ($i = 0; $i < 15; $i++) {
                    $browser->click('div#product_vat_minus2')->pause(50);
                }
                $browser->assertValue('input#product_vat_input2', 8);
                for ($i = 0; $i < 8; $i++) {
                    $browser->click('div#product_discount_plus2')->pause(50);
                }
                $browser->assertValue('input#product_discount_input2', 8)
                ->assertScript('Math.abs(parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 + (parseFloat(document.querySelector("input#product_vat_input2").value))) / 100) * ((100 - (parseFloat(document.querySelector("input#product_discount_input2").value))) / 100) - (parseFloat(document.querySelector("input#brutto_price_input2").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * (parseFloat(document.querySelector("input#product_discount_input0").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * (parseFloat(document.querySelector("input#product_discount_input1").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * (parseFloat(document.querySelector("input#product_discount_input2").value) / 100)
                    - (parseFloat(document.querySelector("input#discounts_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input0").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input0").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input1").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input1").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input2").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input2").value) / 100)
                    - (parseFloat(document.querySelector("input#vat_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input0").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input1").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input2").value)) / 100)
                    - (parseFloat(document.querySelector("input#netto_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input0").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input0").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input1").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input1").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input2").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input2").value)) / 100)
                    - (parseFloat(document.querySelector("input#brutto_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->type('textarea#note', $faker->sentence)
                ->pause(1000)
                ->press('Stwórz fakturę')
                ->pause(1000)
                ->assertPathIs('/invoices');
        });
    }

    public function testCreateInvoiceQuickly(): void
    {
        $this->loginForTests();
        $this->browse(function (Browser $browser) {
            $faker = Faker::create('pl_PL');
            $browser->assertPathIs('/main')
                ->click('li#invoice_nav')
                ->assertPathIs('/invoices/add')
                ->assertSee('Nowa faktura')
                ->type('input#paid_from', date('d.m.Y', strtotime('-2 days')))
                ->type('input#paid_to', date('d.m.Y', strtotime('+26 days')));

            $browser->press('Wprowadź dane z ustawień')
            ->select('#buyer_select', rand(1, 4));

            $productNameOptions = $browser->script('return Array.from(document.querySelectorAll("#product_select option")).map(option => option.text);')[0];
            for($i=0; $i<count($productNameOptions)-1; $i++)
            {
                $browser->type('input#product_input'.$i, $productNameOptions[$i+1]);
                for ($j = 0; $j < 14; $j++) {
                    $browser->click('div#product_count_plus'.$i)->pause(50);
                }
                $browser->type('input#product_count_input'.$i, rand(1,50))
                    ->type('input#product_vat_input'.$i, rand(1,30));
                $browser->type('input#product_discount_input'.$i, rand(0,50))
                    ->click('div#product_discount_plus'.$i)->pause(50)
                    ->click('div#product_discount_minus'.$i)->pause(50)
                    ->assertScript('Math.abs(parseFloat(document.querySelector("input#product_count_input'.$i.'").value) * (parseFloat(document.querySelector("input#product_price_input'.$i.'").value)) * ((100 + (parseFloat(document.querySelector("input#product_vat_input'.$i.'").value))) / 100) * ((100 - (parseFloat(document.querySelector("input#product_discount_input'.$i.'").value))) / 100) - (parseFloat(document.querySelector("input#brutto_price_input'.$i.'").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                    ', true);
                if($i < count($productNameOptions) - 2)
                {
                    $browser->pause(500)->click("li#add_next_product_button")->pause(500);
                }
            }
            $browser
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * (parseFloat(document.querySelector("input#product_discount_input0").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * (parseFloat(document.querySelector("input#product_discount_input1").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * (parseFloat(document.querySelector("input#product_discount_input2").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input3").value) * (parseFloat(document.querySelector("input#product_price_input3").value)) * (parseFloat(document.querySelector("input#product_discount_input3").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input4").value) * (parseFloat(document.querySelector("input#product_price_input4").value)) * (parseFloat(document.querySelector("input#product_discount_input4").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input5").value) * (parseFloat(document.querySelector("input#product_price_input5").value)) * (parseFloat(document.querySelector("input#product_discount_input5").value) / 100)
                    - (parseFloat(document.querySelector("input#discounts_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input0").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input0").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input1").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input1").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input2").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input2").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input3").value) * (parseFloat(document.querySelector("input#product_price_input3").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input3").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input3").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input4").value) * (parseFloat(document.querySelector("input#product_price_input4").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input4").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input4").value) / 100)
                    + parseFloat(document.querySelector("input#product_count_input5").value) * (parseFloat(document.querySelector("input#product_price_input5").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input5").value)) / 100) * (parseFloat(document.querySelector("input#product_vat_input5").value) / 100)
                    - (parseFloat(document.querySelector("input#vat_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input0").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input1").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input2").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input3").value) * (parseFloat(document.querySelector("input#product_price_input3").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input3").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input4").value) * (parseFloat(document.querySelector("input#product_price_input4").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input4").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input5").value) * (parseFloat(document.querySelector("input#product_price_input5").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input5").value)) / 100)
                    - (parseFloat(document.querySelector("input#netto_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->assertScript('Math.abs(
                    parseFloat(document.querySelector("input#product_count_input0").value) * (parseFloat(document.querySelector("input#product_price_input0").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input0").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input0").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input1").value) * (parseFloat(document.querySelector("input#product_price_input1").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input1").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input1").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input2").value) * (parseFloat(document.querySelector("input#product_price_input2").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input2").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input2").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input3").value) * (parseFloat(document.querySelector("input#product_price_input3").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input3").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input3").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input4").value) * (parseFloat(document.querySelector("input#product_price_input4").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input4").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input4").value)) / 100)
                    + parseFloat(document.querySelector("input#product_count_input5").value) * (parseFloat(document.querySelector("input#product_price_input5").value)) * ((100 - parseFloat(document.querySelector("input#product_discount_input5").value)) / 100) * ((100 + parseFloat(document.querySelector("input#product_vat_input5").value)) / 100)
                    - (parseFloat(document.querySelector("input#brutto_sum").value.replace(/\s+/g, ``).replace(`,`, `.`).replace(` zł`, ``)))) < 0.01;
                ', true)
                ->type('textarea#note', $faker->sentence)
                ->pause(1000)
                ->press('Stwórz fakturę')
                ->pause(1000);
        });
    }

    public function testInvoiceShowPdf(): void
    {
        $invoiceId = 1;

        $this->browse(function (Browser $browser) use ($invoiceId) {
            $browser->visit(route('invoices.show', $invoiceId))
                ->pause(1000)
                ->assertPathIs('/invoices/'.$invoiceId);
        });
    }
}
