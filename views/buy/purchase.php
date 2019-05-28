<?php

use app\models\CustomerPurchaseSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerPurchaseSearch */
/* @var $purchaseDataProvider yii\data\ActiveDataProvider */
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
        'dataProvider' => $purchaseDataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '订单编号',
                'enableSorting' => false,
                'value' => function($model) {
                    return $model->cp_id;
                },
                'headerOptions' => ['style' => 'text-align:center', 'width' => '40'],
                'contentOptions' => ['style' => 'text-align:center', 'width' => '40'],
            ],
            [
                'label' => '购买药品',
                'enableSorting' => false,
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->m_id]);
                    return $medicine->name.' ×  '.$model->num;
                },
                'headerOptions' => ['style' => 'text-align:center', 'width' => '140'],
                'contentOptions' => ['style' => 'text-align:center', 'width' => '140'],
            ],
            //'m_id',
            [
                'attribute' => 'cp_time',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
            ],
            'status',
            //'v_id',
            //'num',
            //'img',
            //'pa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $appointmentDataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '订单信息',
                'enableSorting' => false,
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->m_id]);
                    return $model->ca_order . "\n" . $medicine->name.' × '.$model->num;
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle'],
            ],
            //'m_id',
            [
                'attribute' => 'ca_time',
                'headerOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle'],
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
                'headerOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle; width: 60px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle; width: 60px'],
            ],
            //'v_id',
            //'num',
            [
                'attribute' => 'deadline',
                'headerOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: xx-small; vertical-align: middle'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
