<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $searchModel app\models\MedicineSearch */
/* @var $caProvider yii\data\ActiveDataProvider */
?>
<?= GridView::widget([
    'dataProvider' => $caProvider,
    // 'filterModel' => $searchModel,
    'pager' => [
        'maxButtonCount' => 7,
    ],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        //'m_id',
        'ca_order',
        [
            'label' => '图片',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img('images/prescription/' . $model->ca_order . '.jpg', ['alt' => $model->ca_order, 'width' => '500']);
                //return Html::img('images/prescription/' . $model->ca_order . '.jpg', ['alt' => $model->ca_order, 'width' => '500']);
                //return dirname(__FILE__) . DIRECTORY_SEPARATOR  . '../../../prescription/' . $model->ca_order . '.jpg';
            },
            'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 80px'],
            'contentOptions' => ['style' => 'vertical-align: middle; font-size: x-small; width: 80px', 'align' => 'center'],
        ],
        [
            'header' => '操作',
            'class' => 'yii\grid\ActionColumn',
            'template'=> '{accept}{reject}',
            'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
            'contentOptions' => ['align' => 'center', 'style' => 'vertical-align: middle'],
            'buttons' => [
                'accept' => function ($url, $model) {
                    //$_SESSION['medId'] = $model->m_id;
                    return Html::a('通过', ['pharmacist/list', 'option' => 1, 'order' => $model->ca_order], ['class' => "btn btn-sm btn-success",
                        'style' => 'font-size:x-small']);
                },
                'reject' => function ($url, $model) {
                    //$_SESSION['medId'] = $model->m_id;
                    return Html::a('不通过', ['pharmacist/list', 'option' => 2, 'order' => $model->ca_order], ['class' => "btn btn-sm btn-danger",
                        'style' => 'font-size:x-small; margin-top:5px']);
                }
            ],
        ],
        //'img',
    ],
]);