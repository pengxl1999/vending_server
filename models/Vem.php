<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vem".
 *
 * @property int $vem_id
 * @property string $vem_name
 * @property string $vem_addr
 * @property int $vem_type
 */
class Vem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vem_id', 'vem_name', 'vem_type'], 'required'],
            [['vem_id', 'vem_type'], 'integer'],
            [['vem_name', 'vem_addr'], 'string', 'max' => 255],
            [['vem_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vem_id' => '编号',
            'vem_name' => '名称',
            'vem_addr' => '地址',
            'vem_type' => '类型',
        ];
    }
}
