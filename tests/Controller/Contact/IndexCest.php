<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function viewContact(ControllerTester $I): void
    {
        ContactFactory::createOne(['firstName' =>"Joe", 'lastName' =>"Aaaaaaaaaaaaaaa"]);
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->click('Aaaaaaaaaaaaaaa, Joe');
        $I->seeResponseCodeIs(200);
        $I->amOnRoute('app_contact/show', 1);
    }
}
