<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
//use frontend\components\BaseController;
use yii\web\Response;
class AjaxController extends Controller //BaseController
{
	public $jsFile;
	public function init() {
		parent::init();
		$this->jsFile = '@frontend/views/' . $this->id . '/ajax.js';
		// Publish and register the required JS file
		Yii::$app->assetManager->publish($this->jsFile);
		$this->getView()->registerJsFile(
			Yii::$app->assetManager->getPublishedUrl($this->jsFile),
			['yii\web\YiiAsset'] // depends
		);
	}
	public function actionIndex() {
		// note: ajax.js is loaded by the init() method
		return $this->render('ajax');
	}
	public function actionRand100() {
		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$res = array(
				'body'    => rand(0, 100),
				'success' => true,
			);
			return $res;
		}
	}
	public function actionLinkForm() {
		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$res = array(
				'body'    => print_r($_POST, true),
				'success' => true,
			);
			return $res;
		}
	}
        public function actionAction($id, $status) {
                if (Yii::$app->request->isAjax && Yii::$app->user->id>0) {
                        $rows = (new \yii\db\Query())
                        ->select(['id'])
                        ->from('users_work_status')
                        ->where(['=', 'id_user', Yii::$app->user->id])
                        ->andWhere(['=', 'id_work', $id])
                        ->limit(1)
                        ->all();
                        $connection = new \yii\db\Connection([
                            'dsn' => Yii::$app->db->dsn,
                            'username' => Yii::$app->db->username,
                            'password' => Yii::$app->db->password,
                        ]);
                        $connection->open();

                        if(!empty($rows)){
                           // if($rows[0]['status']>$status){
                            //    $status=-1;
                           // }else{
                                $connection->createCommand()
                                ->update('users_work_status', ['status' => $status], 'id = ' . $rows[0]['id'])
                                ->execute();
                            //}
                        }else{
                            $connection->createCommand()
                            ->insert('users_work_status', ['id_user' => Yii::$app->user->id, 'id_work' => $id, 'status' => $status])
                            ->execute();
                        }
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        $res = array(
                                'id'      => $id,
                                'status'  => $status,
                                'success' => true,
                        );
                        return $res;
                }
        }
}
