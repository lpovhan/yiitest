<?php
namespace tests\unit\seeders;

use app\commands\seeders\PhotoSeeder;
use Codeception\Test\Unit;

class PhotoSeederTest extends Unit
{
    protected PhotoSeeder $seeder;

    protected function _before()
    {
        $this->seeder = new PhotoSeeder();
    }

    public function testGenerateRowsCount()
    {
        $albumIds = [1,2,3];
        $photosPerAlbum = 4;

        $reflection = new \ReflectionClass($this->seeder);
        $method = $reflection->getMethod('generateRows');
        $method->setAccessible(true);

        $rows = $method->invoke($this->seeder, $albumIds, $photosPerAlbum);

        $this->assertCount(12, $rows);
    }

    public function testGenerateRowsStructure()
    {
        $albumIds = [1];
        $photosPerAlbum = 2;

        $reflection = new \ReflectionClass($this->seeder);
        $method = $reflection->getMethod('generateRows');
        $method->setAccessible(true);

        $rows = $method->invoke($this->seeder, $albumIds, $photosPerAlbum);

        foreach ($rows as $row) {
            $this->assertCount(3, $row);
            $this->assertEquals(1, $row[0]); // album_id
            $this->assertIsString($row[1]);  // url
            $this->assertIsString($row[2]);  // title
        }
    }

    public function testRunInsertsRows()
    {
        $albumIds = [1];
        $photosPerAlbum = 3;

        $ids = $this->seeder->run($albumIds, $photosPerAlbum);

        $this->assertCount(3, $ids);

        $rows = (new \yii\db\Query())
            ->from('photo')
            ->where(['id' => $ids])
            ->all();

        $this->assertCount(3, $rows);
    }
}