<?php
namespace app\commands\seeders;

class AlbumSeeder extends BaseSeeder
{

    public function run(array $userIds, int $albumsPerUser)
    {
        $rows = $this->generateRows($userIds, $albumsPerUser);
        $this->batchInsert('album', ['user_id', 'title'], $rows);
        return $this->getLastInsertIds(count($rows));
    }

    private function generateRows(array $userIds, int $albumsPerUser)
    {
        $rows = [];
        foreach ($userIds as $userId) {
            for ($i = 0; $i < $albumsPerUser; $i++) {
                $rows[] = [$userId, $this->faker->sentence(3)];
            }
        }
        return $rows;
    }
}