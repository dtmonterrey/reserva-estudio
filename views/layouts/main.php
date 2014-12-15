<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Reserva-Estudios',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [];
            if (Yii::$app->user->isGuest) {
            	array_push($menuItems, ['label' => 'Login', 'url' => ['/site/login']]);
            } else {
            	array_push($menuItems, ['label' => 'Reservar Estúdio', 'url' => ['/reserva/index']]);
            	//array_push($menuItems, ['label' => 'Indisponibilidades', 'url' => ['/indisponibilidade/index']]);
            	if (Yii::$app->user->identity->role == \app\models\Role::findOne(\app\models\Role::$ROLE_ADMIN)) {
            		// user admin
            		array_push($menuItems, ['label' => 'Estudios', 'url' => ['/estudio/index']]);
            		array_push($menuItems, ['label' => 'Responsavel do Estudio', 'url' => ['/responsavel-estudio/index']]);
            	}
            	array_push($menuItems, ['label' => 'Logout (' . Yii::$app->user->identity->nome . ')',
            			'url' => ['/site/logout'],
            			'linkOptions' => ['data-method' => 'post']
            		]);
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; IPB <?= date('Y') ?></p>
           
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
