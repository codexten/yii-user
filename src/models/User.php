<?php

namespace codexten\yii\models;

use codexten\yii\db\ActiveRecord;
use codexten\yii\user\models\query\UserQuery;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * User ActiveRecord model.
 *
 * Database fields:
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property integer $confirmed_at
 * @property integer $logged_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 *
 * Defined relations:
 *
 * @property Account[] $accounts
 * @property Profile $profile
 *
 * Dependencies:
 *
 */
class User extends ActiveRecord
{
    // events
    const BEFORE_CREATE = 'beforeCreate';
    const AFTER_CREATE = 'afterCreate';

    public $password;
    public $confirm_password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['logged_at', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['password', 'confirm_password'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm Password'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'logged_at' => Yii::t('app', 'Logged At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), ['password', 'confirm_password']);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'access_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token',
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'created_at' => function ($model) {
                return Yii::$app->formatter->asDatetime($model->created_at);
            },
        ];

    }
}
