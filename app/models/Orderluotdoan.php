<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_luotdoan".
 *
 * @property string $id
 * @property string $order_id
 */
class Orderluotdoan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_luotdoan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id'], 'required'],
            [['order_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
        ];
    }
    public static function checkOrder($order_id){
        $check=  Orderluotdoan::find()->where("order_id=".$order_id)->one();
        if($check){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
