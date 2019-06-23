<?php

namespace app\controllers;

use app\models\CustomerCar;
use app\models\CustomerPurchase;
use app\models\Medicine;
use app\models\MedicineSearch;
use app\models\SignInForm;
use app\models\User;
use app\models\Vem;
use app\models\VemSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\BuyStatus;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        if(!Yii::$app->user->isGuest) {
            if(!session_id())   session_start();
            $username = Yii::$app->user->identity->username;
            $user = User::findByUsername($username);
            $_SESSION['userId'] = $user['id'];
        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $session = \yii::$app->session;
            if(!$session->isActive)
            {
                $session->open();

            }
            $type = $model->getUser()->getUserType();
            //$id = $model->getUser()->id;
            //$session->set('type',$type);
            //if($type === '1'){
            //    $pro = Professor::findOne($id);
            //    $session->set('depart',$pro->pro_depart);
            //}
            //$session->set('user',$id);
            //$session->set('password',$model->getUser()->password);
            return $this->goHome();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
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


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionSuccess()
    {
        return $this->render('success');
    }

    /*public function actionBuy($userId, $medId)
    {

    }*/

//    public function actionCart($userId, $medId)
//    {
//        $CustomerPurchase = CustomerPurchase::findOne($userId);
//        $cart = new CustomerCar();
//        $cart['cc_id'] = $CustomerPurchase['cp_id'];
//        $cart['c_id'] = $userId;        //用户id
//        $cart['cc_medicine'] = $medId;      //药品id
//        return $this->render('cart', ['model' => $cart]);
//    }

    /**
     * Displays sign-in page.
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new SignInForm();
        if ($model->signIn()) {
            $this->redirect(['success']);
        }
//
//            $session = \yii::$app->session;
//            if(!$session->isActive)
//            {
//                $session->open();
//
//            }
//            $type = $model->getUser()->getUserType();
//            $id = $model->getUser()->id;
//            $session->set('type',$type);
//            if($type === '1'){
//                $pro = Professor::findOne($id);
//                $session->set('depart',$pro->pro_depart);
//            }
//            $session->set('user',$id);
//            $session->set('password',$model->getUser()->password);
//            return $this->goHome();
//        }
        $model->id = User::getMaxID() + 1;
        $model->user_type = 2;
        $model->password = '';
        $model->confirmPassword = '';
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
