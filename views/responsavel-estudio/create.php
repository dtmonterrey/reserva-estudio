<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResponsavelEstudio */

$this->title = 'Create Responsavel Estudio';
$this->params['breadcrumbs'][] = ['label' => 'Responsavel Estudios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="responsavel-estudio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
