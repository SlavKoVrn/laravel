<?php

declare(strict_types=1);

namespace Tests\Functional;

use Tests\FunctionalTester;

class ApiCest
{
    public function listComments(FunctionalTester $I)
    {
        $I->sendGET('/api/comment');
        $I->seeResponseCodeIs(200);
    }

    public function testPagination(FunctionalTester $I)
    {
        $pageNumber = 2;
        $perPage = 10;

        $I->sendGET('/api/comment', [
            'page' => $pageNumber,
            'per_page' => $perPage
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $responseData = $I->grabResponse();
        $response = json_decode($responseData);

        $I->assertEquals($pageNumber, $response->data->current_page);
        $I->assertEquals($perPage, $response->data->per_page);
    }

}
