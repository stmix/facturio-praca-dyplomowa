<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class ProductsTest extends DuskTestCase
{
    /**
     * A Dusk products test for Factur.io.
     */
    public function testAddProduct(): void
    {
        $this->loginForTests();
        $this->browse(function (Browser $browser) {
            $faker = Faker::create('pl_PL');
            $browser->assertPathIs('/main')
                ->click('li#products_nav')
                ->assertPathIs('/products')
                ->assertSee('Produkty');
            for($i=0; $i<6;$i++)
            {
                $browser->click('div#add_product_button')
                ->assertPathIs('/products/add')
                ->assertSee('Dodaj nowy produkt')
                ->type('input#product_name', $faker->word)
                ->type('input#product_price', $faker->randomFloat(2, 0, 99))
                ->type('input#producent', $faker->company)
                ->type('input#product_info', $faker->sentence)
                ->press('Dodaj produkt')
                ->pause(100)
                ->assertPathIs('/products');
            }
            $products = $browser->elements('.product_row');
            $this->assertEquals(6, count($products));
        });
    }
}
