<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Vending Machine';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>欢迎！</h1>

        <p class="lead">您现在可以进行预约购药！</p>

        <p><a class="btn btn-lg btn-success" href="./index.php?r=buy%2Findex">立即购买</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>使用指南</h2>

                <p>本应用程序是基于TO Group of Jilin University开发的智能药品售货机设计，可进行预约购药。导航栏中有以下几个页面：售货机信息、购买药品、我的订单、我的购物车。
                    <br/>
                    在购买处方药时，需提供有相关执照的医师或药师提供的处方，并上传给我们。经过药师审核后，方可到指定售货机取药。
                    <br/>
                    <br/>
                    获取更多信息，请点击此按钮。
                </p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/"> 详细使用说明&raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>关于我们</h2>

                <p>TO Group of Jilin University是吉林大学计算机科学与技术学院无线传感器网络实验室物联网设备小组，</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
