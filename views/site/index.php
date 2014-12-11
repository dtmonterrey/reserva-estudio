<?php
/* @var $this yii\web\View */
$this->title = 'Reserva';


?>

<div>
	<div><i class="fa fa-check-square" style="color:green;"></i> <span style="text-decoration:line-through;">Integrar fullcalendar</span></div>
	<div><i class="fa fa-check-square" style="color:green;"></i> <span style="text-decoration:line-through;">Autenticação por LDAP</span></div>
	<div><i class="fa fa-check-square" style="color:green;"></i> <span style="text-decoration:line-through;">Autenticação dummy (E)</span></div>
	<div><i class="fa fa-check-square" style="color:green;"></i> <span style="text-decoration:line-through;">Guardar eventos na BD (J&amp;L)</span></div>
	<div><i class="fa fa-circle-o-notch fa-spin"></i> <span>Painel de validação de pedidos</span></div>
	<div><i class="fa fa-check-square" style="color:green;"></i> <span style="text-decoration:line-through;">Painel de gestão de estúdios</span></div>
	<div><i class="fa fa-square" style="color:red;"></i> <span>Notificações</span></div>
</div>

<?php
	 $user = Yii::$app->user->identity;
	 $responsaveisEstudio = \app\models\ResponsavelEstudio::find()->where(['id_user'=>$user->id])->orderBy(['id_estudio'=>SORT_ASC])->all();
	 if (count($responsaveisEstudio) > 0) {
	 	$reservas = [];
		foreach ($responsaveisEstudio as $re) {
			$reservasDoEstudio = \app\models\Reserva::find()->where(
					['id_estudio'=>$re->id_estudio, 'status'=>\app\models\Reserva::$PENDENTE])->orderBy(['inicio'=>SORT_ASC])->all();
			foreach ($reservasDoEstudio as $rde) {
				array_push($reservas, $rde);
			}
		}
		echo '<h3>Pedidos de reservas pendentes</h3>';
	 	echo '<table class="table table-striped table-hover" style="width:100%;">';
		echo '<tr><th>&nbsp;</th><th>ID</th><th>Requerente</th><th>Estúdio</th><th>Início</th><th>Fim</th><th>&nbsp;</th></tr>';
		foreach ($reservas as $r) {
			echo '<tr>';
			echo '<td>';
			echo \yii\helpers\Html::a("", ['reserva/aprovar', 'id'=>$r->id], ['class'=>'glyphicon glyphicon-ok', 'style'=>'color:green', 'title'=>'Aprovar']);
			echo '</td>';
			$user = $r->getUser();
			$estudio = $r->getEstudio();
			echo "<td>$r->id</td><td>$user->nome - $user->email</td><td>$estudio->nome_estudio</td><td>$r->inicio</td><td>$r->fim</td>";
			echo '<td>';
			echo \yii\helpers\Html::a("", ['reserva/rejeitar', 'id'=>$r->id], ['class'=>'glyphicon glyphicon-remove', 'style'=>'color:red', 'title'=>'Rejeitar']);
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	 }
?>