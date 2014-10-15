<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estudio */

$this->title = 'Create Estudio';
$this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
