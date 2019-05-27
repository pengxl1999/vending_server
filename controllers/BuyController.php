<?php


namespace app\controllers;

use AlipayTradeService;
use app\models\CustomerAppointment;
use app\models\CustomerAppointmentSearch;
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

        $purchaseSearchModel = new CustomerPurchaseSearch();    //线下购买
        $appointmentSearchModel = new CustomerAppointmentSearch();      //预约购买

        $post = Yii::$app->request->post();
        if(isset($post['search_cp'])) {
            $search = $post['search_cp'];
            $purcaseDataProvider = $purchaseSearchModel->searchByParams($search);
            $appointmentProvider = $appointmentSearchModel->searchByParams($search);
        } else {
            $purcaseDataProvider = $purchaseSearchModel->search(Yii::$app->request->queryParams);
            $appointmentProvider = $appointmentSearchModel->searchByParams(Yii::$app->request->queryParams);
        }

        return $this->render('purchase', [
            'purchaseSearchModel' => $purchaseSearchModel,
            'purchaseDataProvider' => $purcaseDataProvider,
            'appointmentSearchModel' => $appointmentSearchModel,
            'appointmentProvider' => $appointmentProvider,
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

    /**
     * 接入支付宝
     * @param $mMoney
     * @throws \Exception
     */
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
        $alipay->setTimeExpress("1m");

        //获取config
        $config = Yii::$app->params['alipay'];
        //实例化service
        $service = new \AlipayTradeService($config);
        //支付
        $result = $service->wapPay($alipay, $config['return_url'], $config['notify_url']);
        var_dump($result);
    }

    /**
     * 支付宝支付成功返回页面
     * @throws \Exception
     */
    public function return_url() {

        $config = Yii::$app->params['alipay'];

        $arr=$_GET;
        $sevice = new \AlipayTradeService($config);
        $result = $sevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            //请在这里加上商户的业务逻辑程序代码

            $this->redirect(['success']);

        }
        else {
            //验证失败
            echo "验证失败";
        }
    }

    public function actionSuccess() {
        return $this->render('success');
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