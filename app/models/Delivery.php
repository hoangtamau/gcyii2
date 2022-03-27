<?php

namespace app\models;

use Yii;

class Delivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'easyii_shopcart_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_name', 'delivery_phone', 'delivery_address', 'delivery_date',], 'required'],
            [['delivery_date', 'delivery_transport'], 'integer'],
            [['delivery_address', 'delivery_message'], 'string'],
            [['delivery_fee'], 'number'],
            [['delivery_name', 'delivery_phone'], 'string', 'max' => 100],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [            
            'delivery_name' => 'Tên người nhận',
            'delivery_phone' => 'Điện thoại',
            'delivery_address' => 'Địa chỉ',
            'delivery_message' => 'Lời nhắn',
            'delivery_date' => 'Ngày giao',
            'delivery_fee' => 'Delivery Fee',
            'delivery_transport' => 'Delivery Transport',
        ];
    }
}
