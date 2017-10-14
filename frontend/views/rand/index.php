<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use dektrium\user\models\Profile;
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Rand page.</p>
<?php
$subject = 'ВычМат';
$counter = 0;
$user_list = [];
$rows = (new \yii\db\Query())
->select(['id'])
->from('work_list')
->where(['=', 'subject', $subject])
->orderBy('number DESC')
->all();

foreach($rows as $row){
    $users = (new \yii\db\Query())
    ->select(['id_user'])
    ->from('users_work_status')
    ->where(['=', 'id_work', $row['id']])
    //->andWhere(['=', 'status', 1])
    ->all();
    shuffle($users);

    foreach($users as $user){
        if(array_search($user['id_user'], $user_list)===FALSE){
            $profile = Profile::find()->where(['user_id' => $user['id_user']])->one();
            if(!empty($profile->name)){
                echo $profile->name . ' id_work ' . $row['id'] . ' id_user ' . $user['id_user'] . '<br>';
            }else{
                echo $profile->user->username . ' id_work' . $row['id'] . ' id_user ' . $user['id_user'] . '<br>';
            }
            $user_list[$counter++] = $user['id_user'];
        }
    }
}
?>
        </div>
</div>
