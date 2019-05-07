<?php


namespace app\controllers;

use app\models\CustomerCar;
use app\models\CustomerCarSearch;
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

class BuyController extends Controller
{
    public $enableCsrfValidation = false;
    public static $money = 0;       //总金额
    public static $hasRx = false;       //是否有处方药
    public static $isUploaded = false;      //是否上传图片
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

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

    public function actionIndex($medId = -1) {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('./index.php?r=site/login');
        }

        self::$hasRx = false;
        self::$isUploaded = false;
        if($medId !== -1) {
            $this->addMedToCart($medId);
        }

        $searchModel = new MedicineSearch();
        $post = Yii::$app->request->post();

        if(isset($_POST['search'])) {       //判断是否有search
            $search = $post['search'];
            $dataProvider = $searchModel->searchByParams($search);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCart($medId = -1, $operation = -1)    //medId不为-1，新增药品；operation不为-1，0增加、1减少或2删除
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('./index.php?r=site/login');
        }
        self::$money = 0;
        self::$isUploaded = false;
        if($operation !== -1) {
            switch ($operation) {
                case 0:
                    $cart = CustomerCar::findOne([
                        'c_id' => $_SESSION['userId'],
                        'cc_medicine' => $medId,
                    ]);
                    $cart->cc_num++;
                    $cart->save();
                    break;
                case 1:
                    $cart = CustomerCar::findOne([
                            'c_id' => $_SESSION['userId'],
                            'cc_medicine' => $medId,
                    ]);
                    $cart->cc_num--;
                    if($cart->cc_num === 0) {
                        $cart->delete();
                    } else {
                        $cart->save();
                    }
                    break;
                case 2:
                    $cart = CustomerCar::findOne([
                        'c_id' => $_SESSION['userId'],
                        'cc_medicine' => $medId,
                    ]);
                    $cart->delete();

                    break;
                default:
                    break;
            }
        }
        else if($medId !== -1) {
            $this->addMedToCart($medId);
        }

        $searchModel = new CustomerCarSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->searchByUser($_SESSION['userId']);

        return $this->render('cart', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetail($medId) {
        return $this->render('detail', [
            'model' => Medicine::findOne($medId),
        ]);
    }

    public function actionAddr($cart, $mMoney) {     //支付页面， medId == -1 ? 全部购买 : 只购买medId
        if($mMoney == 0) {     //总金额为0，不进行操作
            return $this->redirect(['cart']);
        }
        self::$isUploaded = false;
        if($cart == -1) {
            $searchModel = new CustomerCarSearch();
            $dataProvider = $searchModel->searchByUser($_SESSION['userId']);    //购买信息provider
            $searchModel = new VemSearch();
            $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams);     //售货机信息provider
        } else {
            $searchModel = new CustomerCarSearch();
            $dataProvider = $searchModel->searchById($cart);
            $searchModel = new VemSearch();
            $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('addr', [
            'medId' => $cart,
            'mMoney' => $mMoney,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            'searchModel' => $searchModel,
        ]);
    }

    public function addMedToCart($medId) {
        if(($cart = CustomerCar::findOne([
            'c_id' => $_SESSION['userId'],
            'cc_medicine' => $medId,
        ])) != null) {
            $cart->cc_num++;         //购物车存在同种药，则数量增加1
            $cart->save();
        }
        else {
            $cart = new CustomerCar();
            $cart['cc_id'] = CustomerCar::getMaxId() + 1;
            $cart['c_id'] = $_SESSION['userId'];      //用户id
            $cart['cc_medicine'] = $medId;      //药品id
            $cart['cc_num'] = 1;
            $cart->save();
        }
    }
}