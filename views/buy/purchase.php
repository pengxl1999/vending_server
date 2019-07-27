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
                        case \app\models\AppointmentStatus::$DEADLINE_EXCEED:
                            return '收货超出期限';
                        case \app\models\AppointmentStatus::$ALREADY_REFUND:
                            return '已退款';
                        case \app\models\AppointmentStatus::$CHECKED_OK:
                            return '审核通过';
                        case \app\models\AppointmentStatus::$CHECKED_BAD:
                            return '审核未通过';
                        default:
                            return "错误！";
                    }
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 47px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 47px'],
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
                'template'=> '{detail}{pay}{cancel}',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 60px'],
                'contentOptions' => ['style' => 'vertical-align: middle', 'align' => 'center'],
                'buttons' => [
                    'detail' => function ($url, $model) {
                        return Html::a('详细', ['buy/purchasedetail', 'order' => $model->ca_order],
                            ['class' => "btn btn-sm btn-primary", 'style' => 'font-size:xx-small']);
                    },
                    'pay' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        switch ($model->status) {
                            case \app\models\AppointmentStatus::$NOT_PAID:
                                return Html::a('付款', ['buy/payorder', 'order' => $model->ca_order],
                                    ['class' => "btn btn-sm btn-success",
                                        'style' => 'font-size:xx-small; margin-top: 5px']);
                            case \app\models\AppointmentStatus::$ALREADY_PAID:
                                return Html::a('取货码', null, ['class' => "btn btn-sm btn-success",
                                    'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => "window.android.createQRCode('".$model->ca_order."',".$model->m_id.",".$model->num.",". $model->v_id .")"]);
                            case \app\models\AppointmentStatus::$ALREADY_FINISHED:
                                return null;
                            case \app\models\AppointmentStatus::$TIME_OUT:
                                return null;
                            case \app\models\AppointmentStatus::$CHECKING:
                                return null;
                            case \app\models\AppointmentStatus::$DEADLINE_EXCEED:
                                return null;
                            case \app\models\AppointmentStatus::$ALREADY_REFUND:
                                return null;
                            case \app\models\AppointmentStatus::$CHECKED_OK:
                                return Html::a('付款', ['buy/payorder', 'order' => $model->ca_order],
                                    ['class' => "btn btn-sm btn-success",
                                        'style' => 'font-size:xx-small; margin-top: 5px']);
                            case \app\models\AppointmentStatus::$CHECKED_BAD:
                                return null;
                            default:
                                return "错误！";
                        }

                    },
                    'cancel' => function ($url, $model) {
                        switch ($model->status) {
                            case \app\models\AppointmentStatus::$NOT_PAID:
                                return Html::a('取消', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("取消",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$ALREADY_PAID:
                                return Html::a('退款', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("退款",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$ALREADY_FINISHED:
                                return Html::a('删除', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("删除",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$TIME_OUT:
                                return Html::a('删除', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("删除",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$CHECKING:
                                return Html::a('取消', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("取消",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$DEADLINE_EXCEED:
                                return Html::a('退款', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("退款",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$ALREADY_REFUND:
                                return Html::a('删除', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("删除",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$CHECKED_OK:
                                return Html::a('取消', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("取消",'. $model->ca_order . ')']);
                            case \app\models\AppointmentStatus::$CHECKED_BAD:
                                return Html::a('删除', null,
                                    ['class' => "btn btn-sm btn-danger", 'style' => 'font-size:xx-small; margin-top: 5px', 'onclick' => 'confirmDelete("删除",'. $model->ca_order . ')']);
                            default:
                                return "错误！";
                        }
                    }
                ],
            ],
        ],
    ]); ?>
</div>
<script>
    function confirmDelete(message, order) {
        var result = confirm(message);
        if(result) {
            switch (message) {
                case "退款":
                    window.location.href = "./index.php?r=buy/refund&order=" + order;
                    break;
                default:
                    window.location.href = "./index.php?r=buy/purchase&cancel=" + order;
            }
        }
    }
</script>
