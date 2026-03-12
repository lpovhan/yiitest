<?php

declare(strict_types=1);

namespace tests\api;

use \ApiTester;
use Helper\ApiHelper;

final class AlbumCest
{
    use ApiHelper;

    private const ENDPOINT = '/albums';

    public function testIndexAlbums(ApiTester $I)
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
            'title' => 'string',
        ], '$.data[*]');
    }

    public function testViewAlbum(ApiTester $I)
    {
        $I->sendGET(self::ENDPOINT . '/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

       $I->seeResponseMatchesJsonType([
            'status' => 'string',
            'data' => [
                'id' => 'integer',
                'title' => 'string',
                'first_name' => 'string',
                'last_name' => 'string',
                'photos' => 'array'
            ],
        ]);

        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'title' => 'string',
            'url' => 'string:url'
        ], '$.data.photos[0]');
    }

     /**
     * @dataProvider invalidIds
     */
    public function testViewAlbumNegative(ApiTester $I, \Codeception\Example $example)
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
