<?php

use app\models\Medicine;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medicine */

$this->title = '订单信息';
$this->params['breadcrumbs'][] = ['label' => '我的订单', 'url' => ['purchase']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="medicine-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('返回', ['purchase'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ca_id',
            'ca_order',
            //'c_id',
            'm_id',
            'ca_time',
            'status',
            'v_id',
            'deadline',
            'num',
            //'img',
            //'pa_id',
        ],
    ]) ?>

</div>
