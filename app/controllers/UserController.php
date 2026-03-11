<?php

namespace app\controllers;

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
        return $model;
    }
}
