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
$this->registerCssFile('//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css');
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
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Subject</th>
        <th>Work</th>
        <th>Status</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $works=Profile::getWorkList();
    $user_works=Profile::getUserWorks($profile->user->id);
    foreach($works as $work){
        $status=0;
        $key=array_search($work['id'], array_column($user_works, 'id_work'));
	if($key!==FALSE){
            $status=$user_works[$key]['status'];
        }
        echo '<tr id="' . $work['id'] . '"><td>' . $work['subject'] . '</td><td>' . $work['name'] . ' ' . $work['number'] . '</td><td>' . $status . '</td>';
        if(Yii::$app->user->id==$profile->user->id){
            echo '<td><button type="button" class="btn btn-warning td-button">Ready</button><button type="button" class="btn btn-success td-button">Done</button></td></tr>';
        }else{
            echo "<td>Can't edit</td></tr>";
        }
    }
    ?>
    </tbody>
  </table>
</div>
