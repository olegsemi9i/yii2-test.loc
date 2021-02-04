<?php

use yii\helpers\Html;
use yii\grid\GridView;

use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AuthorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
     'heading',
     'name',
     'text:ntext',
     'date_add',
    ['class' => 'yii\grid\ActionColumn'],
];

?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);

        echo \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns
        ]);
    ?>
</div>
