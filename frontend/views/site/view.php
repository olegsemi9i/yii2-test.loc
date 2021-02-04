<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\Author */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'heading',
            'name',
            'text:ntext',
            'date_add',
            [
                'attribute' => 'img',
                'format' => ['image',['width'=>'100','height'=>'100']],
                'value' => function($data) { return $data->imageurl; }
            ],
        ],
    ]) ?>
    
    <?= Html::beginForm(['message', 'id' => $model->id], 'post', ['id' => 'comments-form', 'data-pjax' => '#messages']); ?>
    <?= Html::input('text', 'text', Yii::$app->request->post('text')) ?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm() ?>
        
    <?php Pjax::begin([
        'enablePushState' => false,
        'formSelector' => '#comments-form'   
    ]); ?>

        <?= $this->render('_messages', [ 
            'messages' => $messages,
        ]) ?>

    <?php Pjax::end(); ?>

</div>
