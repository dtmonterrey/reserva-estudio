<?php

namespace app\controllers;

use Yii;
use app\models\Estudio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ResponsavelEstudio;

/**
 * EstudioController implements the CRUD actions for Estudio model.
 */
class EstudioController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Estudio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Estudio::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estudio model.
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
     * Creates a new Estudio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Estudio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Estudio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Estudio model.
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
     * Finds the Estudio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Estudio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estudio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Adiciona o utilizador como responsável ao estúdio
     * @param unknown $idEstudio
     * @param unknown $login
     * @throws NotFoundHttpException
     * @return \yii\web\Response
     */
    public function actionAddResponsavel($idEstudio, $login) {
    	if ((!isset($idEstudio) || !isset($login)) && ($idEstudio=='' || $login==NULL)) {
    		throw new NotFoundHttpException('Pedido não disponível!');
    	}
    	
    	$user = \app\models\User::findByUsername($login);
    	if ($user != null) {
	    	$re = new ResponsavelEstudio();
	    	$re->id_estudio = $idEstudio;
	    	$re->id_user = $user->id;
	    	$re->save();
    	}
    	
    	return $this->redirect(['view', 'id' => $idEstudio]);
    }
    
    public function actionDelResponsavel($idEstudio, $idUser) {
    	if ((!isset($idEstudio) || !isset($idUser)) && ($idEstudio=='' || $idUser==NULL)) {
    		throw new NotFoundHttpException('Pedido não disponível!');
    	}
    	
    	$re = \app\models\ResponsavelEstudio::findAll(['id_estudio'=>$idEstudio, 'id_user'=>$idUser]);
    	if ($re!=null && count($re)==1) {
    			$re[0]->delete();
    	}
    	 
    	return $this->redirect(['view', 'id' => $idEstudio]);
    }
    
}














