<?php


namespace app\models;

class BuyStatus
{
    public static $curOrder;    //当前要购买的订单号
    public static $totalAmount = 0;     //总金额
    public static $hasRx = false;       //是否有处方药
    public static $isUploaded = false;      //是否已上传照片
}