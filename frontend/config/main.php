<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'language' => 'ru-RU',
    'name' => 'Dark Inc.',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@frontend/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app'       => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
        ],
    ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'appendTimestamp' => true,
        ],
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],*/
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'site/signup' => 'user/registration/register',
                'site/login' => 'user/security/login',
                [
                    'pattern' => 'rand/<subject>',
                    'route' => 'rand/index',
                    'defaults' => ['subject' => 'list'],
                ],
                [
                    'pattern' => 'rand/gen/<subject>/<password>',
                    'route' => 'rand/gen',
                    'defaults' => ['subject' => '', 'password' => ''],
                ],
            ],
        ],
        'sc' => [
            'class' => 'frontend\components\SrcCollect',
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => false,
            'controllerMap' => [
                'security' => [
                    'class' => \dektrium\user\controllers\SecurityController::className(),
                    'on ' . \dektrium\user\controllers\SecurityController::EVENT_AFTER_LOGIN => function ($e) {
                        Yii::$app->response->redirect('/user/' . Yii::$app->user->identity->id);
                        Yii::$app->end();
                    }
                ],
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                        $user = \dektrium\user\models\User::findOne(['username'=>$e->form->username, 'email'=>$e->form->email]);
                        if ($user) {
                            Yii::$app->user->switchIdentity($user);
                        }
                        Yii::$app->response->redirect('/user/' . Yii::$app->user->identity->id);
                    },
                ],
            ],
        ],
    ],
];
