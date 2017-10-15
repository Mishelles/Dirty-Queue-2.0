<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use dektrium\user\models\Profile;
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Rand queue for <?= Html::encode($subject); ?></p>
<?php


$rows = (new \yii\db\Query())
->select(['id_user', 'work'])
->from('queue')
->where(['=', 'subject', $subject])
->orderBy('pos ASC')
->all();
$i=1;
if(empty($rows)){
echo "Something went wrong";//!IMPORTANT! Get and display time before random if subject exists
}else{
?>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <table id="queue" class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Student</th>
              <th class="text-center">Work</th>
            </tr>
          </thead>
          <tbody>
<?php foreach($rows as $row):
$profile = Profile::find()->where(['user_id' => $row['id_user']])->one();
empty($profile->name) ? $user=$profile->user->username : $user=$profile->name;?>
            <tr>
              <td>
                <?= $i++;?>
              </td>
              <td>
                <?= Html::a($user, ['/user/' . $row['id_user']]);?>
              </td>
              <td>
                <?= $row['work'];?>
              </td>
            </tr>
<?php endforeach;}?>
          </tbody>
        </table>
</div>
        </div>
</div>
