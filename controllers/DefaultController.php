<?php

namespace gofmanaa\notification\controllers;

use gofmanaa\notification\models\Notification;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'delete' => ['post'],
                    'touch' => ['post'],
                ],
            ],
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],

        ];
    }



    public function actionIndex()
    {
        if(\Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['notifications' => Notification::getNotifications()]);
        }
    }

    public function actionCheckNew(){
        return Notification::getNotificationsCount(true);
    }

    public function actionDelete()
    {
        if($id = \Yii::$app->request->post('id')){
            return Notification::findOne($id)->delete();
        }
    }
    public function actionDeleteAll()
    {
        if(\Yii::$app->request->isAjax){
            return Notification::deleteAll();

        }
    }

    public function actionTouch(){
        if($id = \Yii::$app->request->post('id')){
           return Notification::touch($id);
        }
    }
}
