<?php
declare(strict_types=1);

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%tasks}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'trim'],
            [['title', 'description'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['title', 'string', 'min' => 5],
            ['title', 'string', 'max' => 255],
            ['description', 'string', 'min' => 5],
            ['is_finished', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'created_at' => Yii::t('app','created_at'),
            'title' => Yii::t('app', 'task title'),
            'description' => Yii::t('app', 'task description'),
            'is_finished' => Yii::t('app', 'task is finished'),

        ];

    }

    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', false],
                    ActiveRecord::EVENT_BEFORE_UPDATE => [false],
                ],
            ],
        ];
    }
}