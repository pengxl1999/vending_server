<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        'brandLabel' => 'Vending Machine',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '首页', 'url' => ['/site/index']],
            ['label' => '售货机信息', 'url' => ['/vem/index']],
            ['label' => '购买药品', 'url' => ['/buy/index']],
            /*['label' => '购买药品', 'url' => ['/buy/index&userId='
                . Yii::$app->user->identity->username .
                '&medId=']],*/
            ['label' => '我的订单', 'url' => ['/buy/purchase']],
            ['label' => '我的购物车', 'url' => ['/buy/cart']],
            Yii::$app->user->isGuest ? (
                ['label' => '登录/注册', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '退出登录(' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>


    <?php
    if(Yii::$app->controller->getRoute() === 'buy/index') {
        echo '
            <div class="footer" style="position: fixed; bottom: 0;height: 80px; width: 100%" >' .
                Html::a('我的购物车', ['buy/cart'], ['class' => 'btn btn-default pull-right',
                    'style' => 'margin-right: 30px; font-size: small']) .
            '</div>'
        ;
    }
    ?>
    <?php
        if(Yii::$app->controller->getRoute() === 'buy/cart') {
            echo '
                <div class="footer" style="position: fixed; bottom: 0;height: 80px; width: 100%" >
                    <p class="pull-left" style="margin-left: 30px; margin-top:10px; color: #496f89; font-size: small">合计：￥' .
                        number_format(\app\models\BuyStatus::$totalAmount, 2) .
                    '</p>' .
                    Html::a('提交订单', ['buy/addr', 'cart' => -1, 'mMoney' => \app\models\BuyStatus::$totalAmount], ['class' => 'btn btn-default pull-right',
                    'style' => 'margin-right: 30px; font-size: small']) .
                '</div>'
            ;
        }
    ?>

    <?php
    if(Yii::$app->controller->getRoute() === 'buy/addr' && (!\app\models\BuyStatus::$hasRx || \app\models\BuyStatus::$isUploaded)) {
        echo '
            <div class="footer" style="position: fixed; bottom: 0;height: 80px; width: 100%" >
                <p class="pull-left" style="margin-left: 30px; margin-top:10px; color: #496f89; font-size: small">合计：￥' .
                    number_format(\app\models\BuyStatus::$totalAmount, 2) .
                '</p>' .
                Html::a('支付', ['pay', 'mMoney' => \app\models\BuyStatus::$totalAmount], ['class' => 'btn btn-default pull-right',
                    'style' => 'margin-right: 30px; font-size: small', 'onclick' => 'checkPermission']) .
            '</div>'
        ;
    }
    else if(Yii::$app->controller->getRoute() === 'buy/addr'){
        echo '
            <div class="footer" style="position: fixed; bottom: 0;height: 80px; width: 100%" >
                <p class="pull-left" style="margin-left: 30px; margin-top:10px; color: #496f89; font-size: small">合计：￥' .
            number_format(\app\models\BuyStatus::$totalAmount, 2) .
                '</p>
                <p style="font-size: small; margin-right: 30px; margin-top: 10px" class="pull-right">请上传处方照片</p>
            </div>'
        ;
    }
    ?>

    <?php
    if(Yii::$app->controller->getRoute() === 'buy/payorder' && (!\app\models\BuyStatus::$hasRx || \app\models\BuyStatus::$isUploaded)) {
        echo '
            <div class="footer" style="position: fixed; bottom: 0;height: 80px; width: 100%" >
                <p class="pull-left" style="margin-left: 30px; margin-top:10px; color: #496f89; font-size: small">合计：￥' .
            number_format(\app\models\BuyStatus::$totalAmount, 2) .
            '</p>' .
            Html::a('支付', ['pay', 'mMoney' => \app\models\BuyStatus::$totalAmount], ['class' => 'btn btn-default pull-right',
                'style' => 'margin-right: 30px; font-size: small', 'onclick' => 'checkPermission']) .
            '</div>'
        ;
    }
    else if(Yii::$app->controller->getRoute() === 'buy/payorder'){
        echo '
            <div class="footer" style="position: fixed; bottom: 0;height: 80px; width: 100%" >
                <p class="pull-left" style="margin-left: 30px; margin-top:10px; color: #496f89; font-size: small">合计：￥' .
            number_format(\app\models\BuyStatus::$totalAmount, 2) .
            '</p>
                <p style="font-size: small; margin-right: 30px; margin-top: 10px" class="pull-right">请上传处方照片</p>
            </div>'
        ;
    }
    ?>

</div>

<script>
    function checkPermission() {
        var hasRx = <?php echo \app\models\BuyStatus::$hasRx ?>;
        var isUploaded = <?php echo \app\models\BuyStatus::$isUploaded ?>
        if(hasRx && !isUploaded) {
            alert("请上传处方照片！");
        }
    }
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
