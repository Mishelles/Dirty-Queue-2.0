<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use dektrium\user\models\Profile;
use common\models\User;

class CronController extends Controller
{
    public $message, $subject;
    
    public function options($actionID)
    {
        return ['message', 'subject'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message', 's' => 'subject'];
    }
    
    public function actionIndex()
    {
        echo $this->message . "\n";
        $user = User::findOne(1);
        $counter = 0;
        $subject = $this->subject;
$user_list = [];
$total = 0;
Yii::$app->db->createCommand("DELETE FROM `queue` WHERE `subject`='" . $subject . "' AND `status`>0")
->execute();

$rows = (new \yii\db\Query())
->select(['id', 'name'])
->from('work_list')
->where(['=', 'subject', $subject])
->orderBy('number ASC')
->all();

$pos=(new \yii\db\Query())
->select(['pos'])
->from('queue')
->where(['=', 'subject', $subject])
->orderBy('pos DESC')
->limit(1)
->all();

if(!empty($pos)){
    $pos = $pos[0]['pos'] + 1;
}else{
    $pos = 0;
}

foreach($rows as $row){
    $users = (new \yii\db\Query())
    ->select(['id_user'])
    ->from('users_work_status')
    ->where(['=', 'id_work', $row['id']])
    ->andWhere(['=', 'status', 1])
    ->all();
    shuffle($users);

    foreach($users as $user){
        if(array_search($user['id_user'], $user_list)===FALSE){
            $profile = Profile::find()->where(['user_id' => $user['id_user']])->one();

            Yii::$app->db->createCommand()
            ->insert('queue', ['id_user' => $user['id_user'], 'pos' => $pos, 'subject' => $subject, 'work' => $row['name'], 'status' => 1])
            ->execute();
            $pos++;
            if(!empty($profile->name)){
                echo $counter+1 . ". " . $profile->name . "\n";
            }else{
                echo $counter+1 . ". " . $profile->user->username . "\n";
            }
            $user_list[$counter++] = $user['id_user'];
        }
    }
}
    }
}
