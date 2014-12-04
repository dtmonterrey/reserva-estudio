<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Responsavel Estudios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="responsavel-estudio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Responsavel Estudio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user.nome',
            'estudio.nome_estudio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
