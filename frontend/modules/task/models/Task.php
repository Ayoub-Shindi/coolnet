<?php

namespace frontend\modules\task\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $custom_name
 * @property string $custom_phone
 * @property string $created_at
 * @property string $task_date
 * @property string $service_type
 */
class Task extends \yii\db\ActiveRecord
{
    public $Follower;
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['custom_name', 'custom_phone', 'created_at', 'task_date', 'service_type'], 'required'],
            [['custom_phone', 'service_type'], 'string'],
            [['created_at', 'task_date'], 'safe'],
            [['custom_name'], 'string', 'max' => 255],
            [['Follower'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'custom_name' => 'Custom Name',
            'custom_phone' => 'Custom Phone',
            'created_at' => 'Created At',
            'task_date' => 'Task Date',
            'service_type' => 'Service Type',
        ];
    }
}
