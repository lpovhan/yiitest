<?php
namespace tests\unit\seeders;

use app\commands\seeders\AlbumSeeder;
use Yii;
use Codeception\Test\Unit;

class AlbumSeederTest extends Unit
{
    protected function _before()
    {
        Yii::$app->db->beginTransaction();
    }

    protected function _after()
    {
        Yii::$app->db->transaction->rollBack();
    }

    public function testGenerateRows()
    {
        $seeder = new AlbumSeeder();

        $userIds = [1, 2];
        $albumsPerUser = 3;

        $reflection = new \ReflectionClass($seeder);
        $method = $reflection->getMethod('generateRows');
        $method->setAccessible(true);

        $rows = $method->invoke($seeder, $userIds, $albumsPerUser);

        $this->assertCount(6, $rows);

        foreach ($rows as $row) {
            $this->assertCount(2, $row);
            $this->assertContains($row[0], $userIds);
            $this->assertIsString($row[1]);
        }
    }

    public function testRun()
    {
        $seeder = new AlbumSeeder();

        $userIds = [1,2];
        $albumsPerUser = 2;

        $ids = $seeder->run($userIds, $albumsPerUser);

        $this->assertCount(4, $ids);

        $count = (new \yii\db\Query())
            ->from('album')
            ->where(['id' => $ids])
            ->count();

        $this->assertEquals(4, $count);
    }
}