<?php
namespace app\commands\seeders;

use Yii;
use Faker\Factory as Faker;

abstract class BaseSeeder
{
    protected $faker;
    protected $db;

    public function __construct()
    {
        $this->faker = Faker::create();
        $this->db = Yii::$app->db;
    }

    protected function getLastInsertIds(int $count): array
    {
        $firstId = (int)$this->db->createCommand("SELECT LAST_INSERT_ID()")->queryScalar();

        return range($firstId, $firstId + $count - 1);
    }

    protected function batchInsert(string $table, array $fields, array $rows): void
    {
        if (empty($rows)) {
            return;
        }
        $this->db->createCommand()->batchInsert($table, $fields, $rows)->execute();
    }

    // abstract public function generateRows(...$params): array;
}