<?php
namespace tests\console;

use Yii;
use yii\db\Query;

class SeedControllerCest
{
    public function testRun(\ConsoleTester $I)
    {
        Yii::$app->params['seedUsers'] = 2;
        Yii::$app->params['seedAlbumsPerUser'] = 2;
        Yii::$app->params['seedPhotosPerAlbum'] = 2;

        ob_start();
        
        // Yii::$app->runAction('seed/run');
        $app = \Yii::$app;
        $controller = new \app\commands\SeedController('seed', $app);
        $controller->runAction('run');

        ob_end_clean();

        $users = (new Query())->from('user')->count();
        $albums = (new Query())->from('album')->count();
        $photos = (new Query())->from('photo')->count();

        $I->assertEquals(2, $users);
        $I->assertEquals(4, $albums);
        $I->assertEquals(8, $photos);
    }
}