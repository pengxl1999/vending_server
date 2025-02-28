<?php

use app\models\CustomerCarSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerCarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的购物车';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-car-index">
    <p>
        <?= Html::a('继续购买', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1><strong style="font-size: large"><?= Html::encode($this->title) ?></strong></h1>

    <br/>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'options' => ['id' => 'grid'],
        'pager' => [
            'maxButtonCount' => 7,
        ],
        'columns' => [
            //'cc_id',
            //'c_id',
            [
                'label' => '图片',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->cc_medicine]);
                    return Html::img('images/medicine/'.$medicine->img, ['alt' => $medicine->name, 'width' => 80]);
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'vertical-align: middle; font-size: x-small', 'align' => 'center'],
            ],
            [
                'label' => '药品名称',
                'enableSorting' => false,
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->cc_medicine]);
                    return $medicine->name;
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 150px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 150px'],
            ],
            [
                'label' => '价格',
                'enableSorting' => false,
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->cc_medicine]);
                    return $medicine->money;
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
            ],
            //'cc_medicine',
            [
                'label' => '数量',
                'enableSorting' => false,
                'value' => function($model) {
                    $medicine = \app\models\Medicine::findOne(['m_id' => $model->cc_medicine]);
                    \app\models\BuyStatus::$totalAmount += $medicine->money * $model->cc_num;
                    return $model->cc_num;
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 45px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 45px'],
            ],
            //'cc_num',

            [
                'header' => '选项',
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{add}{sub}{delete}{buy}',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 60px'],
                'contentOptions' => ['style' => 'vertical-align: center', 'align' => 'center'],
                'buttons' => [
                    'add' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        return Html::a('增加', ['buy/cart', 'medId' => $model->cc_medicine, 'operation' => 0],
                            ['class' => "btn btn-sm btn-success",
                            'style' => 'font-size:xx-small']);
                    },
                    'sub' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        return Html::a('减少', ['buy/cart', 'medId' => $model->cc_medicine, 'operation' => 1],
                            ['class' => "btn btn-sm btn-primary",
                            'style' => 'font-size:xx-small; margin-top:5px']);
                    },
                    'delete' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        return Html::a('删除', ['buy/cart', 'medId' => $model->cc_medicine, 'operation' => 2],
                            ['class' => "btn btn-sm btn-danger",
                                'style' => 'font-size:xx-small; margin-top:5px']);
                    },
                    'buy' => function ($url, $model) {
                        $medicine = \app\models\Medicine::findOne(['m_id' => $model->cc_medicine]);
                        $mMoney = $medicine->money * $model->cc_num;
                        return Html::a('购买', ['buy/addr', 'cart' => $model->cc_id, 'mMoney' => $mMoney],
                            ['class' => "btn btn-sm btn-default",
                                'style' => 'font-size:xx-small; margin-top: 5px']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>

