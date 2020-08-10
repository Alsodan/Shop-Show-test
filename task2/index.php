<?php
use yii\helpers\Url;

class TestClass
{
    public function processUrl()
    {
        $request = Yii::$app->request;
        $params = $request->get();
        // Фильтрация массива по значению параметра
        $params = array_filter($params, function ($value) {
            return $value !== '3';
        });
        // Используем натуральную сортировку, т.к. значения параметров могут быть число-буквенным
        natsort($params);
        $params['url'] = '/' . $request->pathInfo;

        return Url::to(array_merge([Yii::$app->request->hostName], $params), true);
    }
}