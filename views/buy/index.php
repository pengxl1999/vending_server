<?php

use app\models\MedicineSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '购买药品';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicine-index">

    <h1><strong style="font-size: large"><?= Html::encode($this->title) ?></strong></h1>
    <br/>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <form action="./index.php?r=buy/index" method="post">
        <input type="text" name="search_med" placeholder="搜索药品" style="font-size: small"/>
        <input type="submit" value="搜索" class="btn btn-primary" style="font-size: x-small"/>
    </form>

    <br/>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pager' => [
            'maxButtonCount' => 7,
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'m_id',
            [
                'label' => '图片',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img('images/medicine/'.$model->img, ['alt' => $model->name, 'width' => '80']);
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 80px'],
                'contentOptions' => ['style' => 'vertical-align: middle; font-size: x-small; width: 80px', 'align' => 'center'],
            ],
            //'img',
            [
                'header' => "名称",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{name}',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 150px'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle; width: 150px'],
                'buttons' => [
                    'name' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        return Html::a($model->name, ['buy/detail', 'medId' => $model->m_id]);
                    },
                ],
            ],
            //'name',
            //'commodity_name',
            //'common_name',
            //'other_name',
            //'english_name',
            //'type',
            //'composition',
            //'usage',
            //'symptom',
            //'attention',
            //'interaction',
            //'dose',
            //'number',
            //'guarantee',
            //'fomulation',
            //'brand',
            //'cert',
            //'manufacturer',
            [
                'label' => '价格',
                'enableSorting' => true,
                'value' => function($model) {
                    return $model->money;
                },
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
                'contentOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
            ],
            //'money',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'header' => "购买",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{buyNow}{addToCart}',
                'headerOptions' => ['style' => 'text-align:center; font-size: x-small; vertical-align: middle'],
                'contentOptions' => ['align' => 'center', 'style' => 'vertical-align: middle'],
                'buttons' => [
                    'buyNow' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        return Html::a('立即购买', ['buy/cart', 'medId' => $model->m_id], ['class' => "btn btn-sm btn-success",
                            'style' => 'font-size:x-small']);
                    },
                    'addToCart' => function ($url, $model) {
                        //$_SESSION['medId'] = $model->m_id;
                        return Html::a('加入购物车', ['buy/index', 'medId' => $model->m_id], ['class' => "btn btn-sm btn-info",
                            'style' => 'font-size:x-small; margin-top:5px']);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
