<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

abstract class BaseController extends ActiveController
{
    abstract protected function findModel(int $id);

    public function actions()
    {
        return [];
    }

    public function actionIndex()
    {
        $query = $this->modelClass::find()->orderBy(['id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page', 10),
                'page' => max(0, Yii::$app->request->get('page', 1) - 1)
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);

        return [
            'status' => 'ok',
            'total' => $dataProvider->getTotalCount(),
            'page' => $dataProvider->pagination->getPage() + 1,
            'pageSize' => $dataProvider->pagination->getPageSize(),
            'data' => $dataProvider->getModels(),
        ];
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return [
            'status' => 'ok',
            'data' => $model,
        ];
    }

}
