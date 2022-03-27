<?php

namespace app\modules\usermoney\models;

use Yii;

/**
 * This is the model class for table "user_money".
 *
 * @property integer $id
 * @property string $uid
 * @property string $money
 * @property string $currency
 */
class UserMoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'money', 'currency'], 'required'],
            [['uid'], 'integer'],
            [['money'], 'number'],
            [['currency'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'money' => 'Money',
            'currency' => 'Currency',
        ];
    }
    public static function checkUid($uid){
        $check=  UserMoney::find()->where('uid='.$uid)->one();
        if($check){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
