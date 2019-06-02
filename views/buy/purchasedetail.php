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

    <p>
        <?= Html::a('返回', ['purchase'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1><strong style="font-size: large"><?= Html::encode($this->title) ?></strong></h1>

    <br/>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ca_id',
            'ca_order',
            //'c_id',
            [
                'label' => '药品名称',
                'value' => function($model) {
                    $medicine = Medicine::findOne(['m_id', $model->m_id]);
                    return $medicine->name;
                }
            ],
            'ca_time',
            [
                'label' => '状态',
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
                        default:
                            return "错误！";
                    }
                }
            ],
            [
                'label' => '药店地址',
                'value' => function($model) {
                    $vem = \app\models\Vem::findOne(['vem_id' => $model->v_id]);
                    return $vem->vem_location;
                }
            ],
            'deadline',
            'num',
            //'img',
            //'pa_id',
            'money',
        ],
    ]) ?>

</div>
