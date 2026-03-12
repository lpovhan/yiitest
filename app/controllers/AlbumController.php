<?php

namespace app\controllers;

use app\models\dto\AlbumDetailDto;
use app\models\dto\AlbumDto;
use Yii;

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
        return AlbumDetailDto::fromModel($model);
    }

    protected function getList($models)
    {
        return array_map(function ($model) {
            return AlbumDto::fromModel($model);
        }, $models);
    }
}
