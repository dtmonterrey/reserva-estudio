<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estudios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estudio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'nome_estudio',
            [
            	'label'=>'Responsáveis',
            	'value'=> function($estudio) {
            		$responsaveis = '<ul>';
            		foreach ($estudio->responsaveis as $responsavel) {
            			$responsaveis .= '<li>' . $responsavel->nome . ' - ' . $responsavel->email . '</li>';
            		}
            		return $responsaveis . '</ul>';
            	},
            	'format'=>'raw',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
