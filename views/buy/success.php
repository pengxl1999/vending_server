<?php
/* @var $order */
?>

<br/>
<div style="width: 100%; text-align: center; margin-top: 30px">
    <img src="images/icons/success.png" alt="success"/>
</div>
<br/>
<div style="width: 100%; text-align: center">
    <h2>支付成功!</h2>
</div>
<div style="width: 100%; text-align: center">
    <h4>订单编号<?php echo $order ?></h4>
</div>
<div style="width: 100%; text-align: center; margin-top: 40px">
    <a href="./index.php?r=buy%2Fpurchase" class="btn btn-default" style="font-size: large; color: #0a73bb; width: 120px">查看订单</a>

</div>
<div style="width: 100%; text-align: center; margin-top: 20px">
    <a href="./index.php?r=buy%2Findex" class="btn btn-primary" style="font-size: large; width: 120px">继续购买</a>
</div>