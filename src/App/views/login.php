<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve('partials/_banner.php'); ?>

<div class="row justify-content-center ">

    <div class="row justify-content-center">
        <div class="d-flex justify-content-center mb-5">

            <div class="col-md-6 col-lg-5 col-xl-5 ">
                <p class="text-center text-body h4 fw-bold mb-3 mt-4">Sign in</p>

                <form action="/login" method="post">
                    <?php include $this->resolve('partials/_csrf.php'); ?>

                    <div class="form-outline mb-2">
                        <input value="<?php echo ($oldFormData['email']) ?? ''; ?>" type="text" id="email" name="email" class="form-control form-control-sm" placeholder="E-mail">
                    </div>
                    <?php if (array_key_exists('email', $errors)) : ?>
                        <div class="text-danger">
                            <?php echo e($errors['email'][0]); ?>
                        </div>
                    <?php endif ?>

                    <div class="form-outline mb-3">
                        <input type="password" id="password" name="password" class="form-control form-control-sm" placeholder="Password">
                        <?php if (array_key_exists('password', $errors)) : ?>
                            <div class="text-danger">
                                <?php echo e($errors['password'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-sm">Log in</button>
                    </div>
                </form>
            </div>

            <div class="col-md-2 d-flex align-items-center justify-content-end ms-3">
                <a href="/register" class="btn btn-info btn-sm text-white">Let's register!</a>
            </div>

        </div>
    </div>








    <?php include $this->resolve("partials/_footer.php"); ?>