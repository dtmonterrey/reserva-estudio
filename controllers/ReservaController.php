<?php

namespace app\Controllers;

use Yii;
use app\models\Reserva;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservaController implements the CRUD actions for reserva model.
 */
class ReservaController extends Controller {
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        	// todos os utilizadores autenticados podem aceder
        	'access' => [
        		'class' => \yii\filters\AccessControl::className(),
        		'rules' => [
        			[
        				'allow' => true,
        				'roles' => ['@',],
        			],
        		],
        	],
        ];
    }

    /**
     * Lists all reserva models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\Reserva::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single reserva model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	
	 /**
     * Insere Reserva 
     */
    public function actionNovareserva($dados)
    {	
		$qry = new \app\models\Role();
		$qry->role = $dados;
		$qry->save();
    }
    
    /**
     * Update Reserva
     */
    public function actionActualizareserva($dados, $idf)
    {
    	$qry = new \app\models\Role();
		$qry = $qry->findOne($idf);
		$qry->role = $dados;
		$qry->update();
    }

    /**
     * Creates a new reserva model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($estudio=-1, $start=-1, $end=-1) {
    	if ($estudio!=-1 && $start!=-1 && $end!=-1) {
    		$inicio = date('Y-m-d H:i:s', $start);
    		$fim = date('Y-m-d H:i:s', $end);
    		// validar que não existe reserva em conflito
    		$registosColisao = Reserva::find()->where(["and", "inicio>='$inicio'", "fim<='$fim'", "id_estudio=$estudio"])
    			->orWhere(["and", "inicio>='$inicio'", "inicio<'$fim'", "id_estudio=$estudio"])
    			->orWhere(["and", "fim>'$inicio'", "fim<'$fim'", "id_estudio=$estudio"])->all();
    		if (count($registosColisao) > 0) {
    			throw new \yii\web\ConflictHttpException();
    		}
    		// guardar nova reserva
    		$model = new Reserva();
    		$model->id_user = \Yii::$app->user->identity->id;
    		$model->id_estudio = $estudio;
    		$model->inicio = $inicio;
    		$model->fim = $fim;
    		$model->by_user = \Yii::$app->user->identity->id;
    		$model->status = Reserva::$PENDENTE;
    		$model->save();
    		// retornar id da reserva
    		$response = Yii::$app->response;
    		$response->format = \yii\web\Response::FORMAT_JSON;
    		$json = \yii\helpers\Json::encode($model);
    		$response->data = $json;
    		return $response;
    	} else {
	        $model = new reserva();
	
	        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	            return $this->redirect(['view', 'id' => $model->id]);
	        } else {
	            return $this->render('create', [
	                'model' => $model,
	            ]);
	        }
    	}
    }
    

    /**
     * Updates an existing reserva model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $start=-1, $end=-1) {
        $model = $this->findModel($id);
        if ($start!=-1 && $end!=-1) {
        	$model->inicio = date('Y-m-d H:i:s', $start);
        	$model->fim = date('Y-m-d H:i:s', $end);
        	$model->save();
        } else {
	        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	            return $this->redirect(['view', 'id' => $model->id]);
	        } else {
	            return $this->render('update', [
	                'model' => $model,
	            ]);
	        }
        }
    }

    /**
     * Deletes an existing reserva model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the reserva model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return reserva the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = reserva::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Aprovar esta reserva
     * @param unknown $id
     * @return \yii\web\Response
     */
    public function actionAprovar($id) {
    	$reserva = Reserva::findAll($id);
    	if (count($reserva) != 1) {
	    	return $this->redirect(['reserva/view', 'id'=>$id]);
    	} else {
    		$reserva = $reserva[0];
    		$reserva->status = Reserva::$APROVADA;
    		$reserva->save();
    		return $this->redirect(['reserva/view', 'id'=>$id]);
    	}
    }
    
    /**
     * Rejeitar esta reserva
     * @param unknown $id
     * @return \yii\web\Response
     */
    public function actionRejeitar($id) {
    	$reserva = Reserva::findAll($id);
    	if (count($reserva) != 1) {
    		return $this->redirect(['reserva/view', 'id'=>$id]);
    	} else {
    		$reserva = $reserva[0];
    		$reserva->status = Reserva::$REJEITADA;
    		$reserva->save();
    		return $this->redirect(['reserva/view', 'id'=>$id]);
    	}
    }
    
    public function actionJson($idEstudio, $start, $end) {
    	$events = [];
    	$reservas = \app\models\Reserva::find()->where(['and', "id_estudio=$idEstudio", "inicio>='$start'", "fim<='$end'"])->all();
    	foreach ($reservas as $reserva) {
    		array_push($events, [
    		'id'=>$reserva->id,
    		'title'=>$reserva->getUser()->email,
    		'start'=>$reserva->inicio,
    		'end'=>$reserva->fim,
    		'url'=>'?r=reserva/view&id='.$reserva->id,
    		'className'=>($reserva->status==(\app\models\Reserva::$PENDENTE) ? 'eventoPendente' : ''),
    		'overlap'=>false,
    		'editable'=>(($reserva->status==(\app\models\Reserva::$PENDENTE)) && ($reserva->id_user==Yii::$app->user->identity->id) ? true : false),
    		]);
    	}
    	$response = Yii::$app->response;
    	$response->format = \yii\web\Response::FORMAT_JSON;
    	$response->data = $events;
    	return $response;
    }
}















