<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Response;
class RandController extends Controller //BaseController
{
        public function actionIndex($subject='list'){
                if($subject=='list'){
                    return $this->render('index');
                }else{
                    return $this->render('list', ['subject' => $subject]);
                }
        }

        public function actionGen($subject, $password){
               //if($password==Yii::$app->params['gen_pass']){
                   return $this->render('generate', ['subject' => $subject]);
               /*}else{
                   return $this->render('index');
               }*/
        }
}
