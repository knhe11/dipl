<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/confirm-email', 'token' => $token->new_email_token]);
?>
Уважаемый, <?= $user->username ?>,

перейдите по следующей ссылке, что бы подтвердить email:

<?= $confirmLink ?>
