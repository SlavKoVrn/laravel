<?php

declare(strict_types=1);

namespace Tests\Functional;

use Tests\FunctionalTester;

class ApiCest
{
    public function getProfileWithoutCredentions(FunctionalTester $I)
    {
        $I->sendGET('/api/comment');
        $I->seeResponseCodeIs(200);
    }

}
