<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use dektrium\user\models\Profile;
$this->title = Html::encode($subject);
echo Breadcrumbs::widget([
    'itemTemplate' => "<li>{link}</li>\n", // template for all links
    'links' => [
      [
        'label' => Yii::t('app', 'Subject list'),
        'url' => ['/rand'],
      ],
      Html::encode($subject),
    ],
  ]);
  ?>
  <div class="site-index">

    <div class="jumbotron">

      <p class="lead"><?= Yii::t('app', 'Queue for ');?><?= Html::encode($subject); ?></p>
      <?php


      $rows = (new \yii\db\Query())
      ->select(['id_user', 'work'])
      ->from('queue')
      ->where(['=', 'subject', $subject])
      ->orderBy('pos DESC')
      ->all();
      $i=1;
      if(empty($rows)){
        $rows = (new \yii\db\Query())
        ->select(['date_start'])
        ->from('cron_jobs')
        ->where(['=', 'subject', $subject])
        ->orderBy('id ASC')
        ->all();
        if(empty($rows)){
          echo Yii::t('app', "Queue doesn't exists");
        }else{
          if(strtotime($rows[0]['date_start'])<time()){
            $datetime1 = new DateTime('now');
            $datetime2 = new DateTime(str_replace("this", "next", $rows[0]['date_start']));
            $interval = $datetime1->diff($datetime2);
            echo $interval->format('Очередь будет сгенерирована через %d дн. %h ч. %i мин. %s сек.');
          }else{
           $datetime1 = new DateTime('now');
           $datetime2 = new DateTime($rows[0]['date_start']);
           $interval = $datetime1->diff($datetime2);
           echo $interval->format('Очередь будет сгенерирована через %d дн. %h ч. %i мин. %s сек.');
         }
       }
     }else{
      ?>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <table id="queue" class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center"><?= Yii::t('app', 'Name');?></th>
                <th class="text-center"><?= Yii::t('app', 'Work');?></th>
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
</div>
