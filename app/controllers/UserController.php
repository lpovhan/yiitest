<?php

namespace app\controllers;

use app\models\dto\UserDetailDto;
use app\models\dto\UserDto;

class UserController extends BaseController
{
    public $modelClass = 'app\models\User';

    protected function findModel($id)
    {
        $model = $this->modelClass::find()
                ->with(['albums'])
                ->where(['id' => $id])
                ->one();
        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Not found");
        }
        return UserDetailDto::fromModel($model);
    }

    protected function getList($models)
    {
        return array_map(function ($model) {
            return UserDto::fromModel($model);
        }, $models);
    }
}
