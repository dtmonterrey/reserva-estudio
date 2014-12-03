<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudio".
 *
 * @property string $id
 * @property string $nome_estudio
 *
 * @property Indisponibilidade[] $indisponibilidades
 * @property Reserva[] $reservas
 * @property ResponsavelEstudio[] $responsavelEstudios
 */
class Estudio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome_estudio'], 'required'],
            [['nome_estudio'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome_estudio' => 'Nome Estudio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndisponibilidades()
    {
        return $this->hasMany(Indisponibilidade::className(), ['id_estudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::className(), ['id_estudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsaveis()
    {
        return $this->hasMany(User::className(), ['id' => 'id_user'])
        ->viaTable('responsavel_estudio', ['id_estudio'=>'id']);
    }
}











