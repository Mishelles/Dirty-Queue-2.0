<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use dektrium\user\models\Profile;
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Rand subjects list.</p>
<?php
$rows = (new \yii\db\Query())
->select(['subject'])
->from('work_list')
->distinct()
->orderBy('number DESC')
->all();
foreach($rows as $row):
?>
    <div class="row">
    <?= Html::a($row['subject'], ['/rand/' . $row['subject']], [
                        'class' => 'lead',
                        ]
                );
    ?>
    </div>
    <br>
<?php endforeach;?>
    </div>
</div>
