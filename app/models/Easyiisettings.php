<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "easyii_settings".
 *
 * @property integer $setting_id
 * @property string $name
 * @property string $title
 * @property string $value
 * @property integer $visibility
 */
class Easyiisettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'easyii_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'value'], 'required'],
            [['visibility'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 128],
            [['value'], 'string', 'max' => 1024],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'name' => 'Name',
            'title' => 'Title',
            'value' => 'Value',
            'visibility' => 'Visibility',
        ];
    }
}
