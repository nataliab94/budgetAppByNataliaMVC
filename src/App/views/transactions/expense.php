<?php include $this->resolve("partials/_header.php"); ?>

<section id="add_expense">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5">

                <div class="header_income d-flex justify-content-center align-items-center">
                    <h2>Add expense</h2>
                    <div class="bag m-3">
                        <img class="money" src="/pictures/wydatek.png" height="50px" alt="bag with money" />
                    </div>
                </div>

                <form id="expenseForm" method="POST">
                    <?php include $this->resolve("partials/_csrf.php"); ?>

                    <!-- Amount -->
                    <div class="mb-1">
                        <label for="expense_amount" class="form-label fw-semibold">Amount</label>
                        <input
                            value="<?php echo e($oldFormData['amount'] ?? ''); ?>"
                            type="text"
                            class="form-control <?php echo isset($errors['amount']) ? 'is-invalid' : ''; ?>"
                            id="expense_amount"
                            name="amount">
                        <?php if (!empty($errors['amount'][0])) : ?>
                            <div class="invalid-feedback d-block">
                                <?php echo e($errors['amount'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Date -->
                    <div class="mb-1">
                        <label for="dateInput" class="form-label fw-semibold">Date</label>
                        <input
                            value="<?php echo e($oldFormData['date'] ?? date('Y-m-d')); ?>"
                            type="date"
                            class="form-control <?php echo isset($errors['date']) ? 'is-invalid' : ''; ?>"
                            name="date"
                            id="dateInput">
                        <?php if (!empty($errors['date'][0])) : ?>
                            <div class="invalid-feedback d-block">
                                <?php echo e($errors['date'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment method</label>
                        <select name="paymentMethod" id="paymentMethod" class="form-select">
                            <option value="">-- Choose payment method --</option>
                            <?php foreach ($paymentMethods as $method): ?>
                                <option value="<?= htmlspecialchars($method['id']) ?>"><?= htmlspecialchars($method['name']) ?></option>
                            <?php endforeach; ?>
                            <option value="__new__">Add new payment method</option>
                        </select>
                    </div>

                    <div id="newPaymentMethodGroup" style="display:none;">
                        <label for="newPaymentMethodInput">New payment method:</label>
                        <input type="text" name="new_payment_method" id="newPaymentMethodInput" class="form-control">
                    </div>

                    <!-- Expense Type -->
                    <div class="mb-3">
                        <label for="expenseType" class="form-label">Expense type</label>
                        <select name="type" id="expenseType" class="form-select">
                            <option value="">-- Choose expense type --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                            <option value="__new__">➕ Add new expense type</option>
                        </select>
                    </div>

                    <!-- New Expense Type -->
                    <div id="newExpenseTypeGroup" style="display:none;">
                        <label for="newExpenseTypeInput">New expense type:</label>
                        <input type="text" name="new_expense_type" id="newExpenseTypeInput" class="form-control">
                        <div id="newExpenseType-error" class="text-danger" style="display: none;">
                            Enter new type.
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-1">
                        <label for="ex_description" class="form-label fw-semibold">Description</label>
                        <input
                            value="<?php echo e($oldFormData['description'] ?? ''); ?>"
                            type="text"
                            class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>"
                            name="description"
                            id="ex_description">
                        <?php if (!empty($errors['description'][0])) : ?>
                            <div class="invalid-feedback d-block">
                                <?php echo e($errors['description'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3 mt-4 mb-3">
                        <button type="submit" class="btn btn-primary">Add expense</button>
                        <a href="/" class="btn btn-secondary text-center">Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('expenseType').addEventListener('change', function() {
        document.getElementById('newExpenseTypeGroup').style.display =
            this.value === '__new__' ? 'block' : 'none';
    });

    document.getElementById('paymentMethod').addEventListener('change', function() {
        document.getElementById('newPaymentMethodGroup').style.display =
            this.value === '__new__' ? 'block' : 'none';
    });
</script>

<?php include $this->resolve("partials/_footer.php"); ?>