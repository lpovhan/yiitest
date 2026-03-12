<?php

namespace app\controllers;

use app\models\dto\PaginatedListDto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

abstract class BaseController extends ActiveController
{
    abstract protected function findModel(int $id);

    abstract protected function getList($data);
    
    public function actions()
    {
        return [];
    }

    public function actionIndex()
    {
        $query = $this->modelClass::find()->orderBy(['id' => SORT_ASC]);

        $pageSize = Yii::$app->request->get('pageSize', 10);
        $page = Yii::$app->request->get('page', 1);
        if(!is_integer($pageSize) || $pageSize < 1) {
            throw new \yii\web\BadRequestHttpException('Invalid page size');    
        }
        if(!is_integer($page) || $page < 1) {
            throw new \yii\web\BadRequestHttpException('Invalid page');    
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => max(0, $page - 1)
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);

        return PaginatedListDto::fromDataProvider($dataProvider, $this->getList($dataProvider->getModels()));
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
