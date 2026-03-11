<?php
namespace tests\unit\seeders;

use app\commands\seeders\UserSeeder;
use app\models\User;
use Yii;
use Codeception\Test\Unit;

class UserSeederTest extends Unit
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
        $count = 5;

        $seeder = new UserSeeder();
        $rows = $seeder->generateRows($count);

        $this->assertCount($count, $rows);

        foreach ($rows as $row) {
            $this->assertIsString($row[0]); // first_name
            $this->assertIsString($row[1]); // last_name
            $this->assertIsString($row[2]); // password_hash
            $this->assertTrue(Yii::$app->security->validatePassword(
                Yii::$app->params['seedUserPassword'], 
                $row[2]
            ));
        }
    }

    public function testRun()
    {
        $count = 5;

        $seeder = new UserSeeder();
        $ids = $seeder->run($count);

        $this->assertCount($count, $ids);

        foreach ($ids as $id) {
            $user = User::findOne($id);
            $this->assertNotNull($user);
            $this->assertTrue(Yii::$app->security->validatePassword(
                Yii::$app->params['seedUserPassword'], 
                $user->password_hash
            ));
        }
    }
}