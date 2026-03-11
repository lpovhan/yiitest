<?php
namespace app\commands\seeders;

use Yii;

class PhotoSeeder extends BaseSeeder
{

    public function run(array $albumIds, int $photosPerAlbum)
    {
        $rows = $this->generateRows($albumIds, $photosPerAlbum);
        $this->batchInsert('photo', ['album_id','url', 'title'], $rows);
        return $this->getLastInsertIds(count($rows));
    }


    private function generateRows(array $albumIds, int $photosPerAlbum)
    {
        $rows = [];
        $photos = $this->getExistsPhotos();
        $maxIndex = count($photos) - 1;

        foreach ($albumIds as $albumId) {
            for ($i = 0; $i < $photosPerAlbum; $i++) {
                $rows[] = [$albumId, $photos[random_int(0, $maxIndex)], $this->faker->sentence(3)];
            }
        }
        return $rows;
    }

    /**
     * Gets list of exists static images
     *
     * @return array List of static images paths
     */
    private function getExistsPhotos()
    {
        $imageDir = Yii::getAlias('@app/web/' . Yii::$app->params['seedImagesUrl']);
        $result = [];
        $files = scandir($imageDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $result[] = $file;
            }
        }
        return $result;
    }

    /**
     * Gets and saves images locally from https://picsum.photos/640/480. This method is not used anymore, it was used to get and save images locally, but now we are using direct links to the service in the photo seeding process.
     *
     * @depricated This method is not used anymore, it was used to get and save images locally
     * @param integer $count
     * @return void
     */
    private static function getAndSaveImages($count = 0){
        if ($count > 0) {
            $imageDir = Yii::getAlias('@app/web/' . Yii::$app->params['seedImagesUrl']);
            if (!is_dir($imageDir)) {
                mkdir($imageDir, 0777, true);
            }
            for($i = 1; $i <= $count; $i++) {
                $imgName = uniqid('photo_') . '.jpg';
                $imgPath = $imageDir . $imgName;
                file_put_contents($imgPath, file_get_contents("https://picsum.photos/640/480?random=" . rand(1, 1000)));
            }
        }
    }
}