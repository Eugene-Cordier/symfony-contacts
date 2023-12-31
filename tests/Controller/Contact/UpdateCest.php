<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function formShowsContactDataBeforeUpdating(ControllerTester $I): void
    {
        $admin = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $adminObj = $admin->object();
        $I->amLoggedInAs($adminObj);
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/1/update');

        $I->seeInTitle('Édition de Simpson, Homer');
        $I->see('Édition de Simpson, Homer', 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I)
    {
        $I->logout();

        $contact = ContactFactory::createOne([
            'firstname' => 'Ned',
            'lastname' => 'Flanders',
        ]);
        $I->amOnPage('/contact/'.$contact->getId().'/update');
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $userObj = $user->object();
        $I->amLoggedInAs($userObj);
        $I->amOnPage('/contact/'.$contact->getId().'/update');
        $I->seeResponseCodeIsSuccessful();
    }
}
