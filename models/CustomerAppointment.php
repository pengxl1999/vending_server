<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_appointment".
 *
 * @property int $ca_id
 * @property string $ca_order
 * @property int $c_id
 * @property int $m_id
 * @property string $ca_time
 * @property int $status
 * @property int $v_id
 * @property string $deadline
 * @property int $num
 * @property string $img
 * @property int $pa_id
 * @property string $money
 *
 * @property User $c
 * @property Medicine $m
 * @property Vem $v
 * @property PharmacistAppointment $pa
 */
class CustomerAppointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_appointment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_id', 'm_id'], 'required'],
            [['c_id', 'm_id', 'status', 'v_id', 'num', 'pa_id'], 'integer'],
            [['ca_time', 'deadline'], 'safe'],
            [['money'], 'number'],
            [['ca_order'], 'string', 'max' => 32],
            [['img'], 'string', 'max' => 255],
            [['c_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['c_id' => 'id']],
            [['m_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicine::className(), 'targetAttribute' => ['m_id' => 'm_id']],
            [['v_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vem::className(), 'targetAttribute' => ['v_id' => 'vem_id']],
            [['pa_id'], 'exist', 'skipOnError' => true, 'targetClass' => PharmacistAppointment::className(), 'targetAttribute' => ['pa_id' => 'pa_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ca_id' => 'Ca ID',
            'ca_order' => '订单编号',
            'c_id' => 'C ID',
            'm_id' => '药品ID',
            'ca_time' => '下单时间',
            'status' => '状态',
            'v_id' => '售货机ID',
            'deadline' => '取货截止时间',
            'num' => '数量',
            'img' => 'Img',
            'pa_id' => 'Pa ID',
            'money' => 'Money',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(User::className(), ['id' => 'c_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getM()
    {
        return $this->hasOne(Medicine::className(), ['m_id' => 'm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getV()
    {
        return $this->hasOne(Vem::className(), ['vem_id' => 'v_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPa()
    {
        return $this->hasOne(PharmacistAppointment::className(), ['pa_id' => 'pa_id']);
    }

    public static function getMaxID()
    {
        return CustomerAppointment::find()->max('ca_id');
    }
}
