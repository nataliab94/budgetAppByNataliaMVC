<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_navbar.php"); ?>

<section id="transactions" class="py-4">
    <div class="container">
        <h2 class="text-center mt-3 mb-4">Your Transactions</h2>

        <!-- ======= PIE CHART ======= -->
        <div class="d-flex justify-content-center mb-4">
            <div class="chart-container" style="max-width: 250px; width: 100%;">
                <canvas id="totalChart"></canvas>
            </div>
        </div>

        <!-- ======= FILTER BY DATE RANGE ======= -->
        <form method="GET" action="/balance" class="mb-5">
            <div class="row justify-content-center g-3">
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="start_date" class="form-label fw-semibold">From:</label>
                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        class="form-control"
                        value="<?= htmlspecialchars($startDate ?? date('Y-m-01')) ?>">
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label for="end_date" class="form-label fw-semibold">To:</label>
                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        class="form-control"
                        value="<?= htmlspecialchars($endDate ?? date('Y-m-d')) ?>">
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- ======= INCOMES ======= -->
        <div class="section-incomes mb-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 text-center text-md-start">
                <h3 class="text-success mb-2 mb-md-0">Incomes</h3>
                <a href="/transaction/income" class="btn btn-success btn-sm">+ Add Income</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($incomes)): ?>
                            <?php foreach ($incomes as $income): ?>
                                <tr>
                                    <td><?= htmlspecialchars($income['amount']) ?></td>
                                    <td><?= htmlspecialchars($income['date_of_income']) ?></td>
                                    <td><?= htmlspecialchars($income['category']) ?></td>
                                    <td><?= htmlspecialchars($income['description']) ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No incomes found for selected date range.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="my-5">

        <!-- ======= EXPENSES ======= -->
        <div class="section-expenses">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 text-center text-md-start">
                <h3 class="text-danger mb-2 mb-md-0">Expenses</h3>
                <a href="/transaction/expense" class="btn btn-danger btn-sm">+ Add Expense</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center shadow-sm">
                    <thead class="table-danger">
                        <tr>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($expenses)): ?>
                            <?php foreach ($expenses as $expense): ?>
                                <tr>
                                    <td><?= htmlspecialchars($expense['amount']) ?></td>
                                    <td><?= htmlspecialchars($expense['date']) ?></td>
                                    <td><?= htmlspecialchars($expense['category']) ?></td>
                                    <td><?= htmlspecialchars($expense['payment']) ?></td>
                                    <td><?= htmlspecialchars($expense['description']) ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No expenses found for selected date range.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ====== Chart.js ====== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const totalIncomes = <?= $totalIncomes ?>;
    const totalExpenses = <?= $totalExpenses ?>;

    const ctx = document.getElementById('totalChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Incomes', 'Expenses'],
            datasets: [{
                data: [totalIncomes, totalExpenses],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<?php include $this->resolve("partials/_footer.php"); ?>