<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class ClientsTest extends DuskTestCase
{
    /**
     * A Dusk clients test for Factur.io.
     */

    public function testAddClient(): void
    {
        $this->loginForTests();
        $this->browse(function (Browser $browser) {
            $faker = Faker::create('pl_PL');
            $browser->assertPathIs('/main')
                ->click('li#clients_nav')
                ->assertPathIs('/clients')
                ->assertSee('Odbiorcy');
            for($i=0; $i<2;$i++)
            {
                $browser->click('div#add_client_button')
                ->assertPathIs('/clients/add')
                ->assertSee('Dodaj nowego odbiorcę')
                ->type('input#fullname', $faker->company)
                ->type('input#nip', $faker->taxpayerIdentificationNumber)
                ->type('input#street', $faker->streetName)
                ->type('input#number', $faker->buildingNumber)
                ->type('input#town', $faker->city)
                ->type('input#zip', $faker->postcode)
                ->type('input#email', $faker->email)
                ->type('input#phone', $faker->phoneNumber)
                ->press('Dodaj odbiorcę')
                ->pause(100)
                ->assertPathIs('/clients');
            }

            $clients = $browser->elements('.client_row');
            $this->assertEquals(2, count($clients));
        });
    }

    public function testAddClientsFromGusApi(): void
    {
        $this->browse(function (Browser $browser) {
            $faker = Faker::create('pl_PL');
            $browser->assertPathIs('/clients')
                ->assertSee('Odbiorcy');

            $clientsBefore = count($browser->elements('.client_row'));
            
            $browser->click('div#add_client_button')
            ->assertPathIs('/clients/add')
            ->assertSee('Dodaj nowego odbiorcę')
            ->type('input#nip', '6912364568')
            ->press('Wyszukaj po numerze NIP')
            ->pause(1000)
            ->type('input#email', $faker->email)
            ->type('input#phone', $faker->phoneNumber)
            ->press('Dodaj odbiorcę')
            ->pause(100)
            ->assertPathIs('/clients');

            $browser->click('div#add_client_button')
            ->assertPathIs('/clients/add')
            ->assertSee('Dodaj nowego odbiorcę')
            ->type('input#nip', '527-261-38-19')
            ->press('Wyszukaj po numerze NIP')
            ->pause(1000)
            ->type('input#email', $faker->email)
            ->type('input#phone', $faker->phoneNumber)
            ->press('Dodaj odbiorcę')
            ->pause(100)
            ->assertPathIs('/clients');

            $clients = $browser->elements('.client_row');
            $this->assertEquals($clientsBefore+2, count($clients));
        });
    }
}
