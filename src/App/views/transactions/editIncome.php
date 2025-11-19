<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_navbar.php"); ?>

<section id="edit_income">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5">

                <div class="header_income d-flex justify-content-center align-items-center">
                    <h2>Edit Income</h2>
                    <div class="bag m-2">
                        <img class="money" src="/pictures/money-6687386_640.png" height="90px" alt="bag with money" />
                    </div>
                </div>

                <form id="incomeForm" method="POST" action="/editIncome?id=<?= $income['id'] ?>">


                    <?php include $this->resolve("partials/_csrf.php"); ?>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold">Amount</label>
                        <input
                            id="amount"
                            type="text"
                            name="amount"
                            class="form-control <?= isset($errors['amount']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($income['amount']) ?>">
                        <?php if (!empty($errors['amount'][0])): ?>
                            <div class="invalid-feedback d-block"><?= htmlspecialchars($errors['amount'][0]) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="date" class="form-label fw-semibold">Date</label>
                        <input
                            type="date"
                            class="form-control <?= isset($errors['date']) ? 'is-invalid' : '' ?>"
                            name="date"
                            id="dateInput"
                            value="<?= htmlspecialchars($income['date']) ?>">
                        <?php if (!empty($errors['date'][0])): ?>
                            <div class="invalid-feedback d-block"><?= htmlspecialchars($errors['date'][0]) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Type -->
                    <div class="mb-3">
                        <label for="incomeType" class="form-label fw-semibold">Type</label>
                        <select
                            class="form-select <?= isset($errors['type']) ? 'is-invalid' : '' ?>"
                            id="incomeType"
                            name="type">
                            <option value="">-- Choose income type --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>"
                                    <?= $income['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="__new__" style="color: blue;">Add new type</option>
                        </select>
                    </div>

                    <!-- New type input (JS controlled) -->
                    <div id="newIncomeTypeGroup" style="display: none;">
                        <label for="newIncomeTypeInput" class="form-label fw-semibold">New income type:</label>
                        <input type="text" name="new_income_type" id="newIncomeTypeInput" class="form-control">
                        <div id="newIncomeType-error" class="text-danger" style="display: none;">
                            Enter new income type.
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="income_description" class="form-label fw-semibold">Description</label>
                        <input
                            id="income_description"
                            type="text"
                            class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                            name="description"
                            value="<?= htmlspecialchars($income['description']) ?>">
                        <?php if (!empty($errors['description'][0])): ?>
                            <div class="invalid-feedback d-block"><?= htmlspecialchars($errors['description'][0]) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3 mt-4 mb-2">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="/" class="btn btn-secondary text-center">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<script>
    // Pokazywanie pola dla nowego typu, jeśli wybrano opcję "Add new type"
    document.getElementById('incomeType').addEventListener('change', function() {
        document.getElementById('newIncomeTypeGroup').style.display =
            this.value === '__new__' ? 'block' : 'none';
    });
</script>

<?php include $this->resolve("partials/_footer.php"); ?>