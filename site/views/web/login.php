<?php

use app\vendor\mvc\models\Lang;

?>
<div class="limiter">
    <div class="container-login" style="background-image: url('/images/bg-01.jpg');">
        <div class="wrap-login">
            <?php include_once toSiteViews('/web/lang.php'); ?>
            <form class="login-form validate-form form-auth" method="post" action="/web/login">
					<span class="login-form-title">
						<?= Lang::t('login') ?>
					</span>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="email" value="<?= $model->email ?>"
                           placeholder="<?= Lang::t('email') ?>" required>
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                    <?php if (isset($model->errors['email'])) : ?>
                        <label id="email-error" class="error" for="email"><?= $model->errors['email'] ?></label>
                    <?php endif; ?>
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="password" placeholder="<?= Lang::t('password') ?>"
                           required>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                    <?php if (isset($model->errors['password'])) : ?>
                        <label id="email-error" class="error" for="password"><?= $model->errors['password'] ?></label>
                    <?php endif; ?>
                </div>
                <div class="container-login-form-btn">
                    <div class="wrap-login-form-btn">
                        <div class="login-form-bgbtn"></div>
                        <button class="login-form-btn" name="send">
                            <?= Lang::t('login') ?>
                        </button>
                    </div>
                </div>
                <div class="sp-nav">
                    <div class="tab-enter">
                        <a href="/web/registration"><?= Lang::t('reg') ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
