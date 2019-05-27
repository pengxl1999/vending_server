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
        <input type="text" name="search_cp" placeholder="搜索订单" style="font-size: medium"/>
        <input type="submit" value="搜索" class="btn btn-primary" />
    </form>
    <br/>

    <?= GridView::widget([
        'dataProvider' => $purchaseDataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align:center', 'width' => '20'],
                'contentOptions' => ['style' => 'text-align:center', 'width' => '20'],
            ],


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
                    return $medicine->name.'×'.$model->num;
                },
                'headerOptions' => ['style' => 'text-align:center', 'width' => '140'],
                'contentOptions' => ['style' => 'text-align:center', 'width' => '140'],
            ],
            //'m_id',
            'cp_time',
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
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'text-align:center', 'width' => '20'],
                'contentOptions' => ['style' => 'text-align:center', 'width' => '20'],
            ],


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
                    return $medicine->name.'×'.$model->num;
                },
                'headerOptions' => ['style' => 'text-align:center', 'width' => '140'],
                'contentOptions' => ['style' => 'text-align:center', 'width' => '140'],
            ],
            //'m_id',
            'ca_time',
            'status',
            //'v_id',
            //'num',
            'deadline',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
