<?php

use app\models\CustomerPurchaseSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerPurchaseSearch */
/* @var $appointmentDataProvider yii\data\ActiveDataProvider */

$this->title = '我的订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-purchase-index">

    <h1><strong style="font-size: large"><?= Html::encode($this->title) ?></strong></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <br/>
    <form action="./index.php?r=buy/purchase" method="post">
        <input type="text" name="search_cp" placeholder="输入订单号" style="font-size: medium"/>
        <input type="submit" value="搜索" class="btn btn-primary" />
    </form>
    <br/>

    <?= GridView::widget([
        'dataProvider' => $appointmentDataProvider,
        //'filterModel' => $searchModel,
        'pager' => [
            'maxButtonCount' => 7,
        ],
        'columns' => [
            [
                'label' => '订单信息',
                'enableSorting' => false,
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->m_id]);
                    return $model->ca_order . "\n" . $medicine->name.' × '.$model->num;
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 100px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 100px'],
            ],
            //'m_id',
            [
                'attribute' => 'ca_time',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
            ],
            [
                'attribute' => 'status',
                'enableSorting' => false,
                'value' => function($model) {
                    switch ($model->status) {
                        case \app\models\AppointmentStatus::$NOT_PAID:
                            return '未支付';
                        case \app\models\AppointmentStatus::$ALREADY_PAID:
                            return '已支付';
                        case \app\models\AppointmentStatus::$ALREADY_FINISHED:
                            return '已完成';
                        case \app\models\AppointmentStatus::$TIME_OUT:
                            return '已超时';
                        case \app\models\AppointmentStatus::$CHECKING:
                            return '待审核';
                        default:
                            return "错误！";
                    }
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 50px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 50px'],
            ],
            //'v_id',
            //'num',
            [
                'attribute' => 'deadline',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
            ],

            [
                'header' => '选项',
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{pay}{cancel}',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 60px'],
                'contentOptions' => ['style' => 'vertical-align: center', 'align' => 'center'],
                'buttons' => [
                    'pay' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        switch ($model->status) {
                            case \app\models\AppointmentStatus::$NOT_PAID:
                                return Html::a('付款', ['buy/payorder', 'order' => $model->ca_order],
                                    ['class' => "btn btn-sm btn-success",
                                        'style' => 'font-size:xx-small']);
                            case \app\models\AppointmentStatus::$ALREADY_PAID:
                                return Html::a('取货码', null, ['class' => "btn btn-sm btn-success",
                                    'style' => 'font-size:xx-small', 'onclick' => 'window.android.createQRCode(\''.$model->ca_order.'\', '. $model->m_id .','. $model->num .')']);
                            case \app\models\AppointmentStatus::$ALREADY_FINISHED:
                                return null;
                            case \app\models\AppointmentStatus::$TIME_OUT:
                                return null;
                            case \app\models\AppointmentStatus::$CHECKING:
                                return null;
                            default:
                                return "错误！";
                        }

                    },
                    'cancel' => function ($url, $model) {
                        switch ($model->status) {
                            case \app\models\AppointmentStatus::$NOT_PAID:
                                return Html::a('取消', ['buy/purchase', 'cancel' => $model->ca_order],
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px']);
                            case \app\models\AppointmentStatus::$ALREADY_PAID:
                                return null;
                            case \app\models\AppointmentStatus::$ALREADY_FINISHED:
                                return null;
                            case \app\models\AppointmentStatus::$TIME_OUT:
                                return Html::a('删除', ['buy/purchase', 'cancel' => $model->ca_order],
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px']);
                            case \app\models\AppointmentStatus::$CHECKING:
                                return Html::a('取消', ['buy/purchase', 'cancel' => $model->ca_order],
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px']);
                            default:
                                return "错误！";
                        }
                    },
                ],
            ],
        ],
    ]); ?>

</div>
