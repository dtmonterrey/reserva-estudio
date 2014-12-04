<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property string $id
 * @property string $role
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord {
	public static $ROLE_ADMIN = 1;
	public static $ROLE_USER = 2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_role' => 'id']);
    }
}
