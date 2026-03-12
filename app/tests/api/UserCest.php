<?php

declare(strict_types=1);

namespace tests\api;

use \ApiTester;
use Helper\ApiHelper;

final class UserCest
{
    use ApiHelper;

    private const ENDPOINT = '/users';

    public function testIndexUsers(ApiTester $I)
    {
        $I->sendGET(self::ENDPOINT);
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
            'id' => 'integer',
            'first_name' => 'string',
            'last_name' => 'string'
        ], '$.data[*]');
    }

    public function testViewUser(ApiTester $I)
    {
        $I->sendGET(self::ENDPOINT . '/1');
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

    /**
     * @dataProvider invalidIds
     */
    public function testViewUserNegative(ApiTester $I, \Codeception\Example $example)
    {
        $I->sendGET(self::ENDPOINT . '/' . $example['id']);

        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'status' => 'integer',
            'code' => 'integer',
            'message' => 'string'
        ]);
    }
}
