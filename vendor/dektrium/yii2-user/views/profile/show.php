<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use dektrium\user\helpers\Profile;
/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row profile">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <?= Html::img($profile->getAvatarUrl(230), [
                    'class' => 'img-rounded img-responsive',
                    'alt' => $profile->user->username,
                ]) ?>
            </div>
            <div class="col-sm-6 col-md-8">
                <h3><?= $this->title ?></h3>
                <ul style="padding: 0; list-style: none outside none;">
                    <?php if (!empty($profile->location)): ?>
                        <li>
                            <i class="mdi mdi-map-marker-outline"></i> <?= Html::encode($profile->location) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($profile->website)): ?>
                        <li>
                            <i class="mdi mdi-web"></i> <?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($profile->public_email)): ?>
                        <li>
                            <i class="mdi mdi-email-outline"></i> <?= Html::a(Html::encode($profile->public_email), 'mailto:' . Html::encode($profile->public_email)) ?>
                        </li>
                    <?php endif; ?>
                    <li>
                        <i class="mdi mdi-clock"></i> <?= Yii::t('user', 'Joined on {0, date}', $profile->user->created_at) ?>
                    </li>
                <?php if (!empty($profile->bio)): ?>
                   <li>
                   <i class="mdi mdi-comment-account-outline"></i> <?= Html::encode($profile->bio) ?>
                   </li>
                <?php endif; ?>
                <?php if (!empty($profile->info)): ?>
                   <li>
                   <i class="mdi mdi-comment-text-outline"></i> <?= Html::encode($profile->info) ?>
                   </li>
                <?php endif; ?>
            </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">

<br>
<div class="input-group">
  <span class="input-group-addon" id="sizing-addon2"><i class="mdi mdi-18px mdi-magnify"></i></span>
  <input type="text" id="dosearch" class="form-control" placeholder=<?= '"' . Yii::t('app', 'Search here...') . '"';?> onkeyup="doSearch()" aria-describedby="sizing-addon2">
</div>
<br>

<table id="works" class="table table-bordered">
    <thead>
      <tr>
        <th><?= Yii::t('app', 'Subject');?></th>
        <th><?= Yii::t('app', 'Work');?></th>
        <th><?= Yii::t('app', 'Status');?></th>
        <th><?= Yii::t('app', 'Actions');?></th>
      </tr>
    </thead>
    <tbody>
<?php
    $statuses=array("Не готово", "Готово", "Сдано");
    $works=Profile::getWorkList();
    $user_works=Profile::getUserWorks($profile->user->id);
    foreach($works as $work):
        $status=0;
        $key=array_search($work['id'], array_column($user_works, 'id_work'));
	if($key!==FALSE){
            $status=$user_works[$key]['status'];
        }
?>
      <tr>
        <td class="col-md-4">
          <?= Html::encode($work['subject'])?>

        </td>
        <td class="col-md-4">
          <?= Html::encode($work['name'])?>

        </td>
        <td class="col-md-1" id="status_<?echo $work['id']?>">
          <?= Html::encode($statuses[$status])?>

        </td>
        <td class="col-md-3">
<?php
        if(Yii::$app->user->id==$profile->user->id){
?>
          <?= Html::a(Yii::t('app', 'Ready'), ['/ajax/action?id=' . $work['id'] . '&status=1'], [
                            'class' => 'btn-primary td-btn',
                            'id' => 'ready_' . $work['id'],
                            'data-on-done' => 'actionDone',
                    ]
            );
            $this->registerJs("$('#ready_" . $work['id'] . "').click(handleAjaxLink);", \yii\web\View::POS_READY);?>

          <?= Html::a(Yii::t('app', 'Done'), ['/ajax/action?id=' . $work['id'] . '&status=2'], [
                            'class' => 'btn-success td-btn',
                            'id' => 'done_' . $work['id'],
                            'data-on-done' => 'actionDone',
                    ]
            );
            $this->registerJs("$('#done_" . $work['id'] . "').click(handleAjaxLink);", \yii\web\View::POS_READY);?>
          <?= Html::a(Yii::t('app', 'Reset'), ['/ajax/action?id=' . $work['id'] . '&status=0'], [
                            'class' => 'btn-danger td-btn',
                            'id' => 'reset_' . $work['id'],
                            'data-on-done' => 'actionDone',
                    ]
            );
            $this->registerJs("$('#reset_" . $work['id'] . "').click(handleAjaxLink);", \yii\web\View::POS_READY);?>
        </td>
<?php
        }else{
?>
          Can't edit
        </td>
<?php }?>
      </tr>
<?php
    endforeach;
?>
    </tbody>
  </table>
</div>
