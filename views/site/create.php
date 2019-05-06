
<?php
/* Sign in for a new account.
*/
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <br/>

    <p>请输入注册信息:</p>

    <br/>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <div class="hidden">
        <?= $form->field($model, 'id')->textInput() ?>
        <?= $form->field($model, 'user_type')->textInput() ?>
    </div>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['id' => 'password']) ?>

    <?= $form->field($model, 'confirmPassword')->passwordInput(['id' => 'confirmPassword']) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-1">
            <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'style' => 'width:120px']) ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>