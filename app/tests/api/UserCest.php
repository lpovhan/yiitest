<?php

declare(strict_types=1);

namespace tests\api;

use \ApiTester;

final class UserCest
{

    public function testIndexUsers(ApiTester $I)
    {
        $I->sendGET('/users');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'status' => 'string',
            'total' => 'integer',
            'page' => 'integer',
            'pageSize' => 'integer',
            'data' => 'array'
        ]);

        $I->seeResponseMatchesJsonType([
            'id'         => 'integer',
            'first_name' => 'string',
            'last_name'  => 'string'
        ], '$.data[*]');
    }

    public function testViewUser(ApiTester $I)
    {
        $I->sendGET('/users/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'status' => 'string',
            'data' => [
                'id' => 'integer',
                'first_name' => 'string',
                'last_name' => 'string',
                'albums' => 'array'
            ],
        ]);

        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'title' => 'string',
            'photos' => 'array'
        ], '$.data.albums[0]');

        $I->seeResponseMatchesJsonType([
            'id'    => 'integer',
            'title' => 'string',
            'url'   => 'string:url'
        ], '$.data.albums[0].photos[0]');
    }
}
