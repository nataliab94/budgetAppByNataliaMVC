<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve('partials/_banner.php'); ?>

<div class="d-flex justify-content-center mb-3">
    <div class="col-md-6 col-lg-5 col-xl-5">
        <p class="text-center text-body h4 fw-bold mb-3 mt-4">Sign up</p>

        <form method="POST">

            <?php include $this->resolve('partials/_csrf.php'); ?>
            <div class="form-outline mb-2">
                <input
                    type="text"
                    id="login"
                    name="login"
                    class="form-control form-control-sm"
                    placeholder="Login"
                    value="<?= htmlspecialchars($oldFormData['login'] ?? '') ?>">
            </div>

            <?php if (!empty($errors['login'][0])): ?>
                <div class="text-danger">
                    <?= htmlspecialchars($errors['login'][0]) ?>
                </div>
            <?php endif; ?>



            <div class="form-outline mb-2">
                <input value="<?php echo e($oldFormData['email'] ?? ''); ?>" type="email" id="email" name="email" class="form-control form-control-sm" placeholder="E-mail">
            </div>
            <?php if (array_key_exists('email', $errors)): ?>
                <div class="text-danger">
                    <?php echo e($errors['email'][0]); ?>
                </div>
            <?php endif; ?>

            <div class="form-outline mb-2">
                <input type="password" id="password" name="password" class="form-control form-control-sm" placeholder="Password">
            </div>
            <?php if (array_key_exists('password', $errors)): ?>
                <div class="text-danger">
                    <?php echo e($errors['password'][0]); ?>
                </div>
            <?php endif; ?>

            <div class="form-outline mb-3">
                <input type="password" id="passwordRepeat" name="confirmPassword" class="form-control form-control-sm" placeholder="Repeat Password">
            </div>
            <?php if (array_key_exists('confirmPassword', $errors)): ?>
                <div class="text-danger">
                    <?php echo e($errors['confirmPassword'][0]); ?>
                </div>
            <?php endif; ?>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-sm">Log in</button>
            </div>
        </form>
    </div>
</div>


<?php include $this->resolve("partials/_footer.php"); ?>