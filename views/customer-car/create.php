<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerCar */

$this->title = 'Create Customer Car';
$this->params['breadcrumbs'][] = ['label' => 'Customer Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-car-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
