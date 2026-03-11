<?php

namespace app\commands;

use app\commands\seeders\AlbumSeeder;
use app\commands\seeders\PhotoSeeder;
use app\commands\seeders\UserSeeder;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{

    public function actionRun()
    {
        $usersCount = (int)Yii::$app->params['seedUsers'];
        $albumsPerUser = (int)Yii::$app->params['seedAlbumsPerUser'];
        $photosPerAlbum = (int)Yii::$app->params['seedPhotosPerAlbum'];

        echo "Seeding with $usersCount users, $albumsPerUser albums per user and $photosPerAlbum photos per album\n";
        $db = Yii::$app->db;

        
        $db->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
        $db->createCommand()->truncateTable('photo')->execute();
        $db->createCommand()->truncateTable('album')->execute();
        $db->createCommand()->truncateTable('user')->execute();
        $db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();

    
        $transaction = $db->beginTransaction();
        
        
        try {
            $userIds = (new UserSeeder())->run($usersCount);
            $albumIds = (new AlbumSeeder())->run($userIds, $albumsPerUser);
            (new PhotoSeeder())->run($albumIds, $photosPerAlbum);

            $transaction->commit();
            $this->stdout("Seeding finished\n");
        
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $this->stdout($e->getMessage() . "\n");
            throw $e;
        }
    }

}
