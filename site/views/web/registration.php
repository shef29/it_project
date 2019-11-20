<?php

use app\vendor\mvc\models\Lang;

?>

<div class="limiter">
    <div class="container-login" style="background-image: url('/images/bg-01.jpg');">
        <div class="wrap-login">
            <?php include_once toSiteViews('/web/lang.php'); ?>
            <form action="/web/registration" method="post" class="login-form validate-form form-auth"
                  enctype="multipart/form-data">
					<span class="login-form-title">
						<?= Lang::t('reg') ?>
            </span>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" value="<?= $model->username ?>" name="username"
                           placeholder="<?= Lang::t('username') ?>" required>
                    <i class="focus-input100"></i>
                    <i class="fa fa-user-circle my-fa"></i>
                    <?php if (isset($model->errors['username'])) : ?>
                        <label id="email-error" class="error" for="username"><?= $model->errors['username'] ?></label>
                    <?php endif; ?>
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="email" name="email" value="<?= $model->email ?>"
                           placeholder="<?= Lang::t('email') ?>" required>
                    <i class="focus-input100"></i>
                    <i class="fa fa-envelope my-fa"></i>
                    <?php if (isset($model->errors['email'])) : ?>
                        <label id="email-error" class="error" for="email"><?= $model->errors['email'] ?></label>
                    <?php endif; ?>
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100" id="password" type="password" name="password"
                           placeholder="<?= Lang::t('password') ?>" required>
                    <span class="focus-input100"></span>
                    <i class="fa fa-lock my-fa"></i>
                    <?php if (isset($model->errors['password'])) : ?>
                        <label id="email-error" class="error" for="password"><?= $model->errors['password'] ?></label>
                    <?php endif; ?>
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" name="confirm_password" name="pass"
                           placeholder="<?= Lang::t('confirm password') ?>" required>
                    <span class="focus-input100"></span>
                    <i class="fa fa-lock my-fa"></i>
                    <?php if (isset($model->errors['confirm_password'])) : ?>
                        <label id="email-error" class="error"
                               for="confirm_password"><?= $model->errors['confirm_password'] ?></label>
                    <?php endif; ?>
                </div>
                <div class="wrap-input100 validate-input">
                    <label class="custom-file-upload ">
                        <input type="file" name="photo" accept="image/*" class="input-user-photo">
                        <?= Lang::t('upload photo') ?>
                    </label>

                    <div class="user-avatar d-none">
                        <a href="#" class="delete-photo">
                            <i class="fa fa-times text-danger"></i>
                        </a>
                        <img id="user-photo" class="hide" src="#"/>
                    </div>
                    <?php if (isset($model->errors['photo'])) : ?>
                        <label id="photo-error" class="error"
                               for="photo"><?= $model->errors['photo'] ?>
                        </label>
                    <?php endif; ?>
                </div>
                <div class="container-login-form-btn">
                    <div class="wrap-login-form-btn">
                        <div class="login-form-bgbtn"></div>
                        <button class="login-form-btn" name="send">
                            <?= Lang::t('reg') ?>
                        </button>
                    </div>
                </div>
                <div class="sp-nav">
                    <div class="tab-enter">
                        <a href="/web/login"><?= Lang::t('login') ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
