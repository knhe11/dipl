<?php
namespace app\models;
use budyaga\users\models\User as MainUser;

class User extends MainUser
{
    public function rules()
    {
        return [
            [['email'], 'required', 'except' => ['oauth']],
            [['username'], 'required'],
            [['username', 'photo', 'email', 'auth_key', 'password_hash'], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'status', 'sex'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_NEW, self::STATUS_ACTIVE, self::STATUS_BLOCKED]],
            ['sex', 'in', 'range' => [self::SEX_MALE, self::SEX_FEMALE]]
        ];
    }

    public function sendEmailConfirmationMail($view, $toAttribute)
    {
        return \Yii::$app->mailer->compose(['html' => $view . '-html', 'text' => $view . '-text'], ['user' => $this, 'token' => $this->emailConfirmToken])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->emailConfirmToken->{$toAttribute})
            ->setSubject('Подтверждение Email || ' . \Yii::$app->name)
            ->send();
    }
}
