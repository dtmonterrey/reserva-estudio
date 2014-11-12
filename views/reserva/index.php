<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Tabs;
use yii\widgets\Menu;
use yii\web\View;

use app\models\Estudio;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;

?>
 <div class="reserva-index"> 

    <h1><?= Html::encode($this->title) ?></h1>
<!--
    <p>
         //Html::a('Create Reserva', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

     /*GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'id_estudio',
            'inicio',
            'fim',
            // 'by_user',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>
    -->
    
    <div> 
 
   
<?php 

$events = array();
  //Testing
  /*$Event = new \yii2fullcalendar\models\Event();
  $Event->id = 1;
  $Event->title = 'Testing';
  $Event->className = 'eventoAprovado';
  $Event->start = date('Y-m-d\TH:m:s\Z');
  $events[] = $Event;*/
  
$estudios = Estudio::find()->all();
$js = "";
$items = [];
foreach ($estudios as $estudio) {
	$JsSelect = "
function(start, end) {
	var title = 'testeUpdate';
	var eventData;
	eventData = {
		title: title,
		className: 'eventoPendente',
		start: start,
		end: end
	}
	$('#reservaCal$estudio->id').fullCalendar('renderEvent', eventData, true); // stick? = true
	$('#reservaCal$estudio->id').fullCalendar('unselect');
	//$.get('index.php?r=reserva/novareserva', {dados: eventData.title});
}
";
	$JsUpdate = "
function(event, delta, revertFunc, jsEvent, ui, view) {
	var id = 7;
  	$.get('index.php?r=reserva/actualizareserva', {dados: event.title, idf: id});
}
";
	$colunas = "
{
	agendaWeek: 'ddd - DD/MM'
}
";
	$titulo = "
{
	agendaWeek: 'LL'
}
";
	$options = [
  		'class' => 'fullcalendar',
  		'id' => 'reservaCal'.$estudio->id,
  	];
	$clOptions = [
  		'lang'=>'pt',
  		'defaultView' =>'agendaWeek',
  		'axisFormat' => 'HH:mm',
		'columnFormat' => new JsExpression($colunas),
		'titleFormat' => new JsExpression($titulo),
  		'minTime' => '09:00:00',
  		'maxTime' => '19:00:00',
  		'firstDay' =>'1',
		'snapDuration' => '01:00:00',
  		'height' => 513,
  		'allDaySlot' => false,
  		'editable' => true,
  		'selectable' => true,
  		'selectHelper'=> true,
        'select' => new JsExpression($JsSelect),
		'eventDrop' => new JsExpression($JsUpdate),
		'eventResize' => new JsExpression($JsUpdate),
  	];
    $loptions = [];
    $loptions['id'] = 'tab'.$estudio->id;
    
	$item = [];
	$item['label'] = $estudio->nome_estudio;
	$item['content'] = '<br /><br />'.\yii2fullcalendar\yii2fullcalendar::widget(['options'=> $options, 'clientOptions'=> $clOptions, 'events'=> $events]);
	$item['linkOptions'] = $loptions;
	
	array_push($items, $item);

	$js .= "$('#$loptions[id]').on('shown.bs.tab', function (e) {
		$('#reservaCal$estudio->id').fullCalendar('render');
	});";
	
} // end for loop

// echo widget
echo Tabs::widget([
	'items' => $items,
 	'id' => 'estudiosTab'
]);

// register our javascript tabs event handling
$this->registerJs($js,View::POS_READY);
 
?>



</div>

    
    

</div>
