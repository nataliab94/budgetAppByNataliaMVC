<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($title ?? 'BudgetApp') ?> - BudgetAppByNatalia</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/main.css">

    <!-- Przekazywanie danych PHP do JS -->
    <script>
        const totalIncomes = <?= json_encode($totalIncomes ?? 0) ?>;
        const totalExpenses = <?= json_encode($totalExpenses ?? 0) ?>;
    </script>

    <!-- Chart.js i Twój JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="/balance.js" defer></script>
</head>

<body>