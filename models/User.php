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
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $ldap_uid;
    public $nome;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        	'login' => 'admin',
        	'id_role' => 1,
        	'nome' => 'Administrador',
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
    public static function findIdentity($id) {
    	$users = User::findAll($id);
    	if (count($users) == 1) {
    		$user = $users[0];
    		$user->username = $user->login;
    		return $users[0];
    	} else {
        	return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    	}
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
	    		$entries = ldap_get_entries($connection, $search);
    			// ver se este user já existe na base de dados
    			$user = new User();
    			$dbUsers = User::find()->where(['login'=>$username])->all();
    			if (count($dbUsers) > 0) {	// já existe, atualizamos
    				$user = $dbUsers[0];
    				$user->login = $entries[0]['uid'];
    				$user->save();
    			} else {	// não existe, adicionamos
    				$user->login = $username;
    				$user->id_role = \app\models\Role::$ROLE_USER;
    				$user->save();
    			}
    			$user->username = $username;
				$user->ldap_uid = $entries[0]['dn'];
                return $user;
    		}
    	}
    	
    	// nao foi possível encontrar o utilizador
    	if (YII_ENV_DEV && $username=='admin') {
    		// estamos em desenvolvimento, devolvemos o admin
    		return new static(self::$users[100]);
    	} else {
    		// falhamos a autenticação
    		return null;
    	}
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
    	$connection = ldap_connect($options['host']);
    	ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
    	
    	// Note: in general it is bad to hide errors, however we're checking for an error below
    	try {
	    	$bind = @ldap_bind($connection, $this->ldap_uid, $password);
	    	// a autenticação no LDAP falhou
	    	if (YII_ENV_DEV && !$bind) {
	    		// estamos em modo de desenvolvimento
	    		if ($password=='admin') {
	    			return true;
	    		} else {
	    			return false;
	    		}
	    	}
	    	return $bind;
    	} catch (Exception $e) {
    		// a autenticação no LDAP falhou
    		if (YII_ENV_DEV) {
    			// estamos em modo de desenvolvimento 
    			if ($password=='admin') {
    				return true;
    			} else {
    				return false;
    			}
    		}
    		// falhamos a autenticação
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
    	'id_role' => 'ID Role',
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
    public function getRole()
    {
    	return $this->hasOne(Role::className(), ['id' => 'id_role']);
    }
    
    /**
     * Procurar utilizadores por login e nome
     * @param unknown $search
     */
    public static function search($search = '') {
		$users = [];
		if ($search=='') {
			return $users;
		}
    	// ldap search
    	$options = \Yii::$app->params['ldap'];
    	$dc_string = "dc=" . implode(",dc=",$options['dc']);
    	$ou_string = "ou=" . implode(",ou=",$options['ou']);
    	// connect
    	$connection = ldap_connect($options['host']);
    	ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
    	ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
    	// search
    	$tokens = '';
    	foreach (explode(' ', $search) as $word) {
    		if ($word != '') {
    			$tokens .= '*' . $word;
    		}
    	}
    	$searchRecords = ldap_search($connection, $ou_string.','.$dc_string, '(|(cn='.$tokens.'*)(uid='.$tokens.'*))');
		$ldapEntries = ldap_get_entries($connection, $searchRecords);
		// build list
		foreach ($ldapEntries as $entry) {
			if (is_array($entry)) {
				$user = new User();
				$user->login = $entry['uid'][0];
				$user->username = $entry['uid'][0];
				$user->nome = $entry['cn'][0];
				array_push($users, $user);
			}
		}
    	return $users;
    } 
    
}












