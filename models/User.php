<?php

namespace app\models;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $login
 * @property integer $id_role
 *
 * @property Reserva[] $reservas
 * @property ResponsavelEstudio[] $responsavelEstudios
 * @property Role $idRole
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $ldap_uid;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
    	$options = \Yii::$app->params['ldap'];
    	$dc_string = "dc=" . implode(",dc=",$options['dc']);
    	$ou_string = "ou=" . implode(",ou=",$options['ou']);
    	
    	$connection = ldap_connect($options['host']);
    	ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
    	
    	if ($connection) {
    		$search = ldap_search($connection, $ou_string.','.$dc_string, "uid=".$username);
    		if (ldap_count_entries($connection, $search) == 1) {
    			// ver se este user já existe na base de dados
    			$dbUsers = User::find()->where(['login'=>$username])->all();
    			if (count($dbUsers) > 0) {	// já existe, atualizamos
    				$dbUser = $dbUsers[0];
    				$user = new User();
    				$user->id = $dbUser->id;
    				$user->login = $dbUser->login;
    				$user->id_role = $dbUser->id_role;
    				$user->save();
    			}
    			$search_entries = ldap_get_entries($connection, $search);
    			$user = [
					'id' => '100',
					'username' => $username,
					'ldap_uid' => $search_entries[0]['dn'],
    			];
                return new static($user);
    		}
    	}
    	return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
    	$options = \Yii::$app->params['ldap'];
    	$dc_string = "dc=" . implode(",dc=",$options['dc']);
    	
    	$connection = ldap_connect($options['host']);
    	ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
    	
    	// Note: in general it is bad to hide errors, however we're checking for an error below
    	try {
	    	$bind = @ldap_bind($connection, $this->ldap_uid, $password);
	    	return $bind;
    	} catch (Exception $e) {
    		return FALSE;
    	}
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
    	return 'user';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    	[['login'], 'required'],
    	[['id_role'], 'integer'],
    	[['login'], 'string', 'max' => 50]
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    	'id' => 'ID',
    	'login' => 'Login',
    	'id_role' => 'Id Role',
    	];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
    	return $this->hasMany(Reserva::className(), ['by_user' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsavelEstudios()
    {
    	return $this->hasMany(ResponsavelEstudio::className(), ['id_user' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRole()
    {
    	return $this->hasOne(Role::className(), ['id' => 'id_role']);
    }
    
}
