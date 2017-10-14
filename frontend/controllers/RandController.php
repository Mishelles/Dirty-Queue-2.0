<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Response;
class RandController extends Controller //BaseController
{
	public function actionIndex() {
		// note: ajax.js is loaded by the init() method
		return $this->render('index');
	}
}
