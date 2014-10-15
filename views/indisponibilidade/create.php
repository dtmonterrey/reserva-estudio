<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\indisponibilidade */

$this->title = 'Create Indisponibilidade';
$this->params['breadcrumbs'][] = ['label' => 'Indisponibilidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indisponibilidade-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
