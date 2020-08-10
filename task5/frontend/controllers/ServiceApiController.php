<?php

namespace frontend\controllers;

use common\models\Service;
use yii\web\Controller;

class ServiceApiController extends Controller
{
    public function actionCity()
    {
        $city = \Yii::$app->request->get('city');
        $result = Service::findAll(['city' => $city]);

        return $this->asJson($result);
    }

    public function actionService(int $id)
    {
        $result = Service::findOne($id) ?? [];

        return $this->asJson($result);
    }
}