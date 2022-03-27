<?php
namespace app\modules\usermoney\models;


use yii\base\Model;

class AddToUserMoneyForm extends Model
{
    const SUCCESS_VAR = 'success';
    public $money;
    public $currency;
    public $payment_method;
    public $currency_payment_method;

    public function rules()
    {
        return [
            [['money','currency','payment_method','currency_payment_method'], 'required'],
            ['money', 'integer', 'min' => 1]
        ];
    }

    public function attributeLabels()
    {
        return [
            'money' => 'Money',
            'currency' => 'Currency',
            'payment_method' => 'Payment method',
            'currency_payment_method' => 'Currency payment',
        ];
    }
}