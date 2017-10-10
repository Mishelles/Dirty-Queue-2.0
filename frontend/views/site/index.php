<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Hello World!</h1>

        <p class="lead">Simple Yii2 app with yii2-user extension.</p>

       <p><a class="btn btn-lg btn-warning" href="https://www.dvnm.tech/rand">Random List Generator 1.0</a></p>
        <p class="lead">Simple AJAX with Yii Controller</p>
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
