<?php include $this->resolve("partials/_header.php"); ?>

<section id="account_settings">
    <div class="container container-sm w-50 w-md-25">
        <div class="header_income d-flex justify-content-center align-items-center mb-4">
            <h2>Account Settings</h2>
            <div class="bag m-3">
                <img class="money" src="/pictures/settings.png" height="70px" alt="settings icon" />
            </div>
        </div>


        <form id="accountForm" method="POST">
            <?php include $this->resolve("partials/_csrf.php"); ?>

            <!-- Email -->
            <div class="mb-1">
                <label for=" email" class="form-label fw-semibold">Email Address</label>
                <input
                    type="email"
                    class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                    id="email"
                    name="email"
                    value="<?php echo e($oldFormData['email'] ?? ''); ?>">
                <?php if (array_key_exists('email', $errors)): ?>
                    <div class="bg-gray-100 mt-2 p-2 text-red-500">
                        <?php echo e($errors['email'][0]); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="mb-1">
                <label for="password" class="form-label fw-semibold">New Password</label>
                <input
                    type="password"
                    class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>"
                    id="password"
                    name="password">
                <?php if (array_key_exists('password', $errors)): ?>
                    <div class="bg-gray-100 mt-2 p-2 text-red-500">
                        <?php echo e($errors['password'][0]); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div class="mb-1">
                <label for="confirmPassword" class="form-label fw-semibold">Confirm Password</label>
                <input
                    type="password"
                    class="form-control <?php echo isset($errors['confirmPassword']) ? 'is-invalid' : ''; ?>"
                    id="confirmPassword"
                    name="confirmPassword">
                <?php if (array_key_exists('confirmPassword', $errors)): ?>
                    <div class="bg-gray-100 mt-2 p-2 text-red-500">
                        <?php echo e($errors['confirmPassword'][0]); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Save + Cancel + DeleteAccount-->
            <div class="d-flex flex-wrap flex-md-row flex-column align-items-center justify-content-center mt-3 gap-1 mb-2">
                <button type="submit" class="btn btn-primary w-auto m-1">Save changes</button>
                <a href="/" class="btn btn-secondary w-auto m-1">Cancel</a>
                <a href="/" class="btn btn-danger w-auto m-1">Delete Account</a>
            </div>
        </form>
    </div>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>