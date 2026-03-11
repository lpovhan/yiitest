<?php

declare(strict_types=1);

namespace tests\api;

use \ApiTester;

final class AlbumCest
{
    public function testIndexAlbums(ApiTester $I)
    {
        $I->sendGET('/albums');
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
        $I->sendGET('/albums/1');
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
}
