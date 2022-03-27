<?php

namespace app\modules\usermoney\models;

use Yii;

/**
 * This is the model class for table "user_history_money".
 *
 * @property string $id
 * @property string $money_send
 * @property string $currency_send
 * @property string $payment_method
 * @property string $currency_payment_method
 * @property string $date
 * @property string $uid
 * @property string $status
 * @property string $fee_send
 * @property string $money_payment_method
 * @property string $total_payment_method
 * @property string $data
 * @property integer $rounding
 * @property integer $workflow
 * @property string $ip
 * @property string $money_usd
 */
class UserHistoryMoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_history_money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money_send', 'currency_send', 'payment_method', 'currency_payment_method', 'date', 'uid', 'status', 'fee_send', 'money_payment_method', 'total_payment_method', 'workflow', 'ip', 'money_usd'], 'required'],
            [['money_send', 'fee_send', 'money_payment_method', 'total_payment_method', 'money_usd'], 'number'],
            [['date', 'uid', 'rounding', 'workflow'], 'integer'],
            [['data'], 'string'],
            [['currency_send', 'currency_payment_method'], 'string', 'max' => 3],
            [['payment_method', 'status'], 'string', 'max' => 20],
            [['ip'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'money_send' => 'Money Send',
            'currency_send' => 'Currency Send',
            'payment_method' => 'Payment Method',
            'currency_payment_method' => 'Currency Payment Method',
            'date' => 'Date',
            'uid' => 'Uid',
            'status' => 'Status',
            'fee_send' => 'Fee Send',
            'money_payment_method' => 'Money Payment Method',
            'total_payment_method' => 'Total Payment Method',
            'data' => 'Data',
            'rounding' => 'Rounding',
            'workflow' => 'Workflow',
            'ip' => 'Ip',
            'money_usd' => 'Money Usd',
        ];
    }
    function check_paypal_auto_complete($order_id, $created) {
        if ($order_id != null && $created != null) {           
            $count = Order::find()->where(['id'=>$order_id, 'date'=>$created,'status'=>'paypal_pending'])->count();
            if ($count == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
