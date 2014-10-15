<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserva".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_estudio
 * @property string $inicio
 * @property string $fim
 * @property string $by_user
 * @property integer $status
 *
 * @property Estudio $idEstudio
 * @property User $idUser
 * @property User $byUser
 */
class Reserva extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserva';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_estudio', 'inicio', 'fim', 'by_user'], 'required'],
            [['id_user', 'id_estudio', 'by_user', 'status'], 'integer'],
            [['inicio', 'fim'], 'safe']
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
            'inicio' => 'Inicio',
            'fim' => 'Fim',
            'by_user' => 'By User',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'id_estudio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'by_user']);
    }
}
