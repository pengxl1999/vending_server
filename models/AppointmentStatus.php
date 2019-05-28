<?php


namespace app\models;


class AppointmentStatus
{
    public static $NOT_PAID = 0;    //未支付
    public static $ALREADY_PAID = 1;    //已支付
    public static $ALREADY_FINISHED = 2;    //已完成
    public static $TIME_OUT = 3;    //已超时
    public static $CHECKING = 4;    //待审核
}