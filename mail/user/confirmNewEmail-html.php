<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/user/confirm-email', 'token' => $token->new_email_token]);
?>
<div class="password-reset">
    <p>Уважаемый, <?= Html::encode($user->username) ?>,</p>

    <p>перейдите по следующей ссылке, что бы подтвердить email:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
