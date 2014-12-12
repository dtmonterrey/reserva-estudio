<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\reserva */

$this->title = 'Reserva ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
        	if (Yii::$app->user->identity->id_role == \app\models\Role::$ROLE_ADMIN ||
        			\app\models\ResponsavelEstudio::isResponsavel(Yii::$app->user->identity->id, $model->id_estudio)) {
        		echo Html::a('Aprovar', ['aprovar', 'id' => $model->id], ['class' => 'btn btn-success']);
        		echo ' ';
        		echo Html::a('Rejeitar', ['rejeitar', 'id' => $model->id], ['class' => 'btn btn-warning']);
        	}
        ?>
        
        <?php
         	if (Yii::$app->user->identity->id == $model->id_user) {
         		echo Html::a('Remover', ['delete', 'id' => $model->id], [
            			'class' => 'btn btn-danger',
            			'data' => [
                			'confirm' => 'Are you sure you want to delete this item?',
                			'method' => 'post',
            			],
        		]);
         	}
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.nome:text:Nome',
            'estudio.nome_estudio:text:Estúdio',
            'inicio',
            'fim',
            [
            	'label' => 'Estado',
            	'value' => $model->getStatusAsString(),
            ],
        ],
    ]) ?>

</div>
