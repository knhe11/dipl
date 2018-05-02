<?php

namespace app\controllers;

use Yii;
use app\components\MainController;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\ContactForm;
use budyaga\users\models\forms\LoginForm;
use app\models\forms\SignupForm;
use yii\helpers\Url;
use yii\filters\AccessControl;

class SiteController extends MainController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm;
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->user->setFlash('success', 'Данные успешно отправлены.');
        }

        if ($model->hasErrors())
            Yii::$app->user->setFlash('dangers', Html::errorSummary($model));

        return $this->render('contact',['model' => $model]);
    }


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            if ($user = $model->signup()) {
                if ($user->createEmailConfirmToken() && $user->sendEmailConfirmationMail(Yii::$app->getModule('user')->getCustomMailView('confirmNewEmail'), 'new_email')) {
                    Yii::$app->getSession()->setFlash('success', 'Проверьте свой Email и следуйте инструкциям.');
                    $transaction->commit();
                    return $this->redirect(Url::toRoute('/login'));
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Невозможно отправить сообщение на заданный Email.');
                    $transaction->rollBack();
                };
            }
            else {
                Yii::$app->getSession()->setFlash('error', 'Во время добавления пользователя возникла ошибка');
                $transaction->rollBack();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
