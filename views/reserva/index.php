<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 2;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\TH:m:s\Z',strtotime('tomorrow 6am'));
  $events[] = $Event;
 
  $events=array();
  
  	$Event-> title= 'Meeting';
  	$Event -> start= '2014-09-30T10:00:00';
  	$Event -> end= '2014-09-30T12:00:00';
  
        		
        
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
  		'height'=>' 525',
  		'allDaySlot'=> false,
  		'editable'=> true,
  		'selectable' => true,
  		'selectHelper'=> true,
  		'select'=>' function(start, end)xispe(start, end)',
  		'dayClick'=>' function(date, jsEvent, view) teste(date, jsEvent, view)'
  ];

  
  
  ?>

  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
  		'clientOptions'=> $options,
      	'events'=> $events
  ));
?>


</div>
    
    

</div>
