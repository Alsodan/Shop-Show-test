<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property float $price - используется для простоты, т.к. пока нет никаких математических действий. При наличии логики лучше использовать https://github.com/moneyphp/money
 * @property string $description
 * @property int $status
 * @property string $due_to
 * @property string $city
 * @property int $user_id
 *
 * @property User $user
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'code', 'status', 'due_to', 'city', 'user_id', 'price'], 'required'],
            [['price'], 'number', 'min' => 0],
            [['description'], 'string'],
            [['status', 'user_id'], 'integer'],
            [['due_to'], 'safe'],
            [['title', 'city'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'code' => 'Код',
            'price' => 'Цена',
            'description' => 'Описание',
            'status' => 'Услуга активна',
            'due_to' => 'Срок действия до',
            'city' => 'Город действия',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'code',
            'price',
            'description',
            'is_active' => function() {
                return $this->status ? 'Да' : 'Нет';
            },
            'due_to',
            'city',
        ];
    }
}
