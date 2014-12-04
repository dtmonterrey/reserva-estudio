<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Estudio */

$this->title = $model->nome_estudio;
$this->params['breadcrumbs'][] = ['label' => 'Estudios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudio-view">

    <h1><?= Html::encode($model->id . ' - ' . $model->nome_estudio) ?></h1>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
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
            'nome_estudio',
        ],
    ]) ?>
    
    <h3>Responsáveis</h3>
    
    <table id="responsaveis" class="table table-hover table-responsive">
    <thead><tr><th style="width:20%">Login</th><th>Nome</th><th style="width:1%"></th></tr></thead>
    <?php
    	foreach ($model->responsaveis as $responsavel) {
    		echo "<tr><td>$responsavel->login</td><td>$responsavel->nome</td><td>";
    		echo Html::a("remover", ['estudio/del-responsavel', 'idEstudio'=>$model->id, 'idUser'=>$responsavel->id]);
    		echo "</td></tr>";
    	} 
    ?>
    </table>
    
    <hr />
    
    <h3>Adicionar Responsáveis</h3>
    
    <?= Html::beginForm(); ?>
    
    <?= Html::input('text', 'procurar', '',['id'=>'procurar']); ?>
    
    <table id="procurarResultados" class="table table-hover table-responsive">
    <thead><tr><th style="width:20%">Login</th><th>Nome</th><th style="width:1%;">&nbsp;</th></tr></thead>
    <tbody></tbody>
    </table>
    
    <?= Html::endForm(); ?>
    <?php 
    	$js = '
var idEstudio = ' . $model->id . ';
$("#procurar").on("keyup", function(event) {
	var pesquisa = $("#procurar").val();
	if (pesquisa.length>=3) {
		$.ajax({
			url: "?r=user/search&search="+pesquisa,
			success: function(data) {
				var rows = "";
				data = $.parseJSON(data);
				$.each(data, function(i, item) {
					rows += "<tr><td>";
					rows += item.login;
					rows += "</td><td>";
					rows += item.nome;
					rows += "</td><td><a href=\"?r=estudio/add-responsavel&idEstudio="+idEstudio+"&login="+item.login+"\">adicionar</a></td></tr>";
				});
				$("#procurarResultados tbody").html(rows);
			}
		});
	}
});
    ';
    	$this->registerJs($js);
    ?>
    

</div>

