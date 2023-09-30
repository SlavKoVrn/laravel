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

    public function testSorting(FunctionalTester $I)
    {
        $I->sendGET('/api/comment', [
            'sort' => 'likes',
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $responseData = $I->grabResponse();
        $response = json_decode($responseData);

        $I->assertEquals(false , $response->success);
        $I->assertEquals('Validation Error.' , $response->message);

        $I->sendGET('/api/comment', [
            'sort' => 'likes_code',
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $responseData = $I->grabResponse();
        $response = json_decode($responseData);

        $comments = $response->data->data;
        $code = 0;
        foreach ($comments as $comment){
            $I->assertGreaterThanOrEqual($code, intval($comment->likes_code));
            $code = intval($comment->likes_code);
        }

        $I->sendGET('/api/comment', [
            'sort' => '-likes_code',
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $responseData = $I->grabResponse();
        $response = json_decode($responseData);

        $comments = $response->data->data;
        $first = reset($comments);
        $code = intval($first->likes_code);

        foreach ($comments as $comment){
            $I->assertLessThanOrEqual($code, intval($comment->likes_code));
            $code = intval($comment->likes_code);
        }

    }

}
