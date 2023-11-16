<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function viewContact(ControllerTester $I): void
    {
        ContactFactory::createMany(4);
        ContactFactory::createOne(['truc', 'Machin']);
        $I->amOnPage('/contact');
        $I->click('ol>li>a');
        ContactFactory::createOne(['Joe', 'Aaaaaaaaaaaaaaa']);
        ContactFactory::createMany(5);
        $I->click(' Aaaaaaaaaaaaaaa, Joe');
        $I->seeResponseCodeIs(200);
        $I->amOnPage('/contact/Joe');
        $I->seeInTitle('Liste des contacts');
    }
}
