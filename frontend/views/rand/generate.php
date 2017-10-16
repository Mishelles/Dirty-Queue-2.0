<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use dektrium\user\models\Profile;
use common\models\User;
use frontend\notifications\QueueNotification;
$this->title = Yii::$app->name;
$user = User::findOne(1);
QueueNotification::create(QueueNotification::KEY_QUEUE_GENERATED, ['queue' => $subject])->setUserId($user->id)->send();
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Generated queue for <?= Html::encode($subject); ?></p>
<?php
if($password==Yii::$app->params['gen_pass']){
$counter = 0;
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
                echo $profile->name . ' id_work ' . $row['id'] . ' id_user ' . $user['id_user'] . '<br>';
            }else{
                echo $profile->user->username . ' id_work ' . $row['id'] . ' id_user ' . $user['id_user'] . '<br>';
            }
            $user_list[$counter++] = $user['id_user'];
        }
    }
}
}else{
echo 'Something went wrong';
}
?>
        </div>
</div>
