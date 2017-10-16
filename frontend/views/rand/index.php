<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use dektrium\user\models\Profile;
$this->title = Yii::t('app', 'Subject list');
echo Breadcrumbs::widget([
    'itemTemplate' => "<li>{link}</li>\n", // template for all links
    'links' => [
        Yii::t('app', 'Subject list'),
    ],
]);
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead"><?= Yii::t('app', 'Subject list');?></p>
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
