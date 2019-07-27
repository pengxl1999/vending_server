<?php


namespace app\models;


class AppointmentStatus
{
    public static $NOT_PAID = 0;    //未支付
    public static $ALREADY_PAID = 1;    //已支付
    public static $ALREADY_FINISHED = 2;    //已完成
    public static $TIME_OUT = 3;    //已超时
    public static $CHECKING = 4;    //待审核
    public static $CHECKED_OK = 5;     //通过审核
    public static $DEADLINE_EXCEED = 6;     //超出deadline，退款
    public static $ALREADY_REFUND = 7;      //已退款
    public static $CHECKED_BAD = 8;     //未通过审核
}