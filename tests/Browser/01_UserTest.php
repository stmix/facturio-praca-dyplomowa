<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends DuskTestCase
{
    use RefreshDatabase;
    /**
     * A basic browser test example.
     */

    public function testRedirecting(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPathIs('/login');
        });
    }

    public function testSigningUp(): void
    {
        $this->browse(function (Browser $browser) {
            $faker = Faker::create();
            $browser->visit('/')
                ->assertPathIs('/login')
                ->click('label#registerbutton')
                ->pause(1000)
                ->type('name', $faker->firstName.' '.$faker->lastName)
                ->type('input#email_register', 'jan.kowalski@example.com')
                ->type('input#password_register', 'Password123!')
                ->type('input#password_confirmation_register', 'Password123!')
                ->click('input#register_button')
                ->assertPathIs('/main')
                ->click('li#logout_button');
        });
    }

    public function testSigningIn(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('input#email_login', 'jan.kowalski@example.com')
                ->type('input#password_login', 'Password123!')
                ->click('input#login_button')
                ->assertPathIs('/main');
        });
    }

    public function testSettings(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/main')
                ->click('li#settings_button')
                ->assertPathIs('/settings')
                ->type('input#nip', '584-020-32-39')
                ->press('Wyszukaj po numerze NIP')
                ->pause(1000)
                ->type('input#email', 'test@ug.edu.pl')
                ->type('input#phone', '555666777')
                ->press('Aktualizuj dane')
                ->visit('/')
                ->visit('/settings')
                ->assertPathIs('/settings');
            $this->assertNotEmpty($browser->value('input#fullname'), 'Pole imienia i nazwiska nie może być puste.');
            $this->assertNotEmpty($browser->value('input#nip'), 'Pole NIP nie może być puste.');
            $this->assertNotEmpty($browser->value('input#street'), 'Pole ulicy nie może być puste.');
            $this->assertNotEmpty($browser->value('input#number'), 'Pole numeru nie może być puste.');
            $this->assertNotEmpty($browser->value('input#town'), 'Pole miasta nie może być puste.');
            $this->assertNotEmpty($browser->value('input#email'), 'Pole email nie może być puste.');
            $this->assertNotEmpty($browser->value('input#phone'), 'Pole telefonu nie może być puste.');
        });
    }

    public function testAddProducts(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                ->assertPathIs('/products')
                ->click('div#add_product_button')
                ->assertPathIs('/products/add');
        });
    }
}
