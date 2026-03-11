<?php
namespace app\commands\seeders;

use Yii;

class UserSeeder extends BaseSeeder
{
    public function run($count)
    {    
        $this->batchInsert('user', ['first_name','last_name', 'password_hash'], $this->generateRows($count));
    
        return $this->getLastInsertIds($count);
    }

    public function generateRows($count): array
    {
        $password = Yii::$app->params['seedUserPassword'];
        $passwordHash = Yii::$app->security->generatePasswordHash($password);

        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                $this->faker->firstName,
                $this->faker->lastName,
                $passwordHash
            ];
        }
        return $rows;
    }
}