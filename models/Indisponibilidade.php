<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indisponibilidade".
 *
 * @property string $id
 * @property string $id_estudio
 * @property string $inicio
 * @property string $fim
 * @property integer $repetir
 *
 * @property Estudio $idEstudio
 */
class Indisponibilidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indisponibilidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudio'], 'required'],
            [['id_estudio', 'repetir'], 'integer'],
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
            'id_estudio' => 'Id Estudio',
            'inicio' => 'Inicio',
            'fim' => 'Fim',
            'repetir' => 'Repetir',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'id_estudio']);
    }
}
