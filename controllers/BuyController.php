<?php


namespace app\controllers;

use app\models\CustomerCar;
use app\models\CustomerCarSearch;
use app\models\CustomerPurchase;
use app\models\CustomerPurchaseSearch;
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

require "../vendor/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";
require "../vendor/alipay/wappay/service/AlipayTradeService.php";
require "../vendor/alipay/config.php";

class BuyController extends Controller
{
    public $enableCsrfValidation = false;

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

    /**
     * 购买药品
     * @param int $medId
     * @return string|Response
     */
    public function actionIndex($medId = -1) {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('./index.php?r=site/login');
        }

        BuyStatus::$hasRx = false;
        if($medId !== -1) {
            $this->addMedToCart($medId);
        }

        $searchModel = new MedicineSearch();
        $post = Yii::$app->request->post();

        if(isset($post['search_med'])) {       //判断是否搜索
            $search = $post['search_med'];
            $dataProvider = $searchModel->searchByParams($search);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 我的订单
     * @return string
     */
    public function actionPurchase() {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('./index.php?r=site/login');
        }

        $searchModel = new CustomerPurchaseSearch();

        $post = Yii::$app->request->post();
        if(isset($post['search_cp'])) {
            $search = $post['search_cp'];
            $dataProvider = $searchModel->searchByParams($search);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('purchase', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 我的购物车
     * @param int $medId
     * @param int $operation
     * @return string|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCart($medId = -1, $operation = -1)    //medId不为-1，新增药品；operation不为-1，0增加、1减少或2删除
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('./index.php?r=site/login');
        }
        BuyStatus::$totalAmount = 0;
        //self::$isUploaded = false;
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

    /**
     * 药品详细信息
     * @param $medId
     * @return string
     */
    public function actionDetail($medId) {
        return $this->render('detail', [
            'model' => Medicine::findOne($medId),
        ]);
    }

    /**
     * 选择地址
     * @param $cart
     * @param $mMoney
     * @param bool $isUploaded
     * @return string|Response
     */
    public function actionAddr($cart, $mMoney, $isUploaded = false) {     //支付页面， cart == -1 ? 全部购买 : 只购买cart
        if($mMoney == 0) {     //总金额为0，不进行操作
            return $this->redirect(['cart']);
        }
        BuyStatus::$isUploaded = $isUploaded;
        BuyStatus::$totalAmount = 0;
        if($cart == -1) {
            $searchModel = new CustomerCarSearch();
            $dataProvider = $searchModel->searchByUser($_SESSION['userId']);    //购买信息provider
        } else {
            $searchModel = new CustomerCarSearch();
            $dataProvider = $searchModel->searchById($cart);
        }
        $searchModel = new VemSearch();
        $dataProvider1 = $searchModel->search(Yii::$app->request->queryParams);     //售货机信息provider
        return $this->render('addr', [
            'mMoney' => $mMoney,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPay($mMoney) {

        if($mMoney == 0) {
            echo "Fatal Error!";
            return;
        }

        //实例化builder
        $alipay = new \AlipayTradeWapPayContentBuilder();
        $alipay->setOutTradeNo(date("Ymdhis"));
        $alipay->setTotalAmount($mMoney);
        $alipay->setSubject('智能药品售货机预约购药');
        $alipay->setBody('药品');

        //获取config
        $config = Yii::$app->params['alipay'];
        //实例化service
        $service = new \AlipayTradeService($config);
        //支付
        $result = $service->wapPay($alipay, $config['return_url'], $config['notify_url']);
        var_dump($result);
    }

    /**
     * 添加id为medId的药品
     * @param $medId
     */
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