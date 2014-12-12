<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "responsavel_estudio".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_estudio
 *
 * @property Estudio $idEstudio
 * @property User $idUser
 */
class ResponsavelEstudio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'responsavel_estudio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_estudio'], 'required'],
            [['id_user', 'id_estudio'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_estudio' => 'Id Estudio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'id_estudio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    
    /**
     * Verifica se este user é responsável deste estúdio
     * @param unknown $id_user
     * @param unknown $id_estudio
     */
    public static function isResponsavel($id_user, $id_estudio) {
    	$r = ResponsavelEstudio::find()->where(['id_user'=>$id_user])->andWhere(['id_estudio'=>$id_estudio])->all();
    	if (count($r) != 0) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
}












