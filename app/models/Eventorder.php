<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eventorder".
 *
 * @property string $id
 * @property string $email
 * @property string $phone
 * @property integer $date_created
 * @property integer $eventcard
 * @property string $namecard
 */
class Eventorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eventorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'phone'], 'required'],
            [['date_created', 'eventcard'], 'integer'],
            [['email'], 'email'],
            [['email', 'namecard'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'date_created' => 'Date Created',
            'eventcard' => 'Eventcard',
            'namecard' => 'Name card',
        ];
    }
}
