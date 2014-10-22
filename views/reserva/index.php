<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reserva-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Reserva', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
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
    ]); ?>
    
    
    <div>
<?php 

$events = array();
  //Testing
  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 1;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\TH:m:s\Z');
  $events[] = $Event;

  $Jsclick = "function(date, jsEvent, view){alert('xpto');}";
        
  $options = array();
  $options = [
  		'lang'=>'pt',
  		'defaultView' =>'agendaWeek',
  		'axisFormat'=> 'HH:mm',
  		'agendaWeek'=>':ddd - DD/MM',
  		'agendaWeek'=> ' LL',
  		'minTime'=> '09:00:00',
  		'maxTime'=> '19:00:00',
  		'defaultView'=> 'agendaWeek',
  		'firstDay'=>'1' ,
  		'Duration'=> '01:00:00',
  		'height'=>525,
  		'allDaySlot'=> false,
  		'editable'=> true,
  		'selectable' => true,
  		'selectHelper'=> true,
  		'dayClick'=> new JsExpression($Jsclick)
  ];

  
  
  ?>

  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
  		'clientOptions'=> $options,
      	'events'=> $events
  ));
?>




</div>

    
    

</div>
