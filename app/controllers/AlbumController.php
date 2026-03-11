<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;

class AlbumController extends BaseController
{

    public $modelClass = 'app\models\Album';

    protected function findModel($id)
    {
        $model = $this->modelClass::find()
                ->with(['photos', 'user'])
                ->where(['id' => $id])
                ->one();
        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Not found");
        }
        return $model;
    }
}
