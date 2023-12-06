<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function viewContact(ControllerTester $I): void
    {
        ContactFactory::createOne(['firstName' => 'Joe', 'lastName' => 'Aaaaaaaaaaaaaaa']);
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->click('Aaaaaaaaaaaaaaa, Joe');
        $I->seeResponseCodeIs(200);
        $I->amOnRoute('app_contact/show', ['id' => 1]);
    }

    public function search(ControllerTester $I): void
    {
        $I->amOnPage('contact/');
        ContactFactory::createMany(2);
        ContactFactory::createOne(['firstName' => 'Joe', 'lastName' => 'Adam']);
        ContactFactory::createOne(['firstName' => 'Adam', 'lastName' => 'Aaaaaaaaaaaaaaa']);
        $I->fillField("//input[@type='search']","Adam");
        $I->click("submit");
        $I->see('Joe');
        $I->see('Aaaaaaaaaaaaaaa');
    }
}
