<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app', 'Dirty Queue V2.0');?></h1>

        <p class="lead"><?= Yii::t('app', 'Random queue with priority');?></p>

       <p><a class="btn btn-lg btn-warning" href="https://www.dvnm.tech/rand">Random List Generator 1.0</a></p>
        <p class="lead"><?= Yii::t('app', 'Simple AJAX with Yii Controller');?></p>
                <?php
                echo Html::a('Click me', ['ajax/rand100'], [
                                'class' => 'btn btn-lg btn-warning',
                                'id' => 'rand_ajax',
                                'data-on-done' => 'randDone',
                        ]
                );
                echo Html::tag('h1', '...', ['id' => 'rand_result']);
                $this->registerJs("$('#rand_ajax').click(handleAjaxLink);", \yii\web\View::POS_READY);
                ?>

        </div>
</div>
