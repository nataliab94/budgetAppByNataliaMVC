document.addEventListener("DOMContentLoaded", () => {

    // ===== DATE RANGE BUTTONS =====
    document.querySelectorAll("[data-range]").forEach(btn => {
        btn.addEventListener("click", () => {
            const startInput = document.getElementById("start_date");
            const endInput = document.getElementById("end_date");
            const today = new Date();

            if (btn.dataset.range === "currentYear") {
                startInput.value = formatLocalDate(new Date(today.getFullYear(), 0, 1));
                endInput.value = formatLocalDate(new Date(today.getFullYear(), 11, 31));
            } else if (btn.dataset.range === "lastMonth") {
                startInput.value = formatLocalDate(new Date(today.getFullYear(), today.getMonth() - 1, 1));
                endInput.value = formatLocalDate(new Date(today.getFullYear(), today.getMonth(), 0));
            } else if (btn.dataset.range === "currentMonth") {
                startInput.value = formatLocalDate(new Date(today.getFullYear(), today.getMonth(), 1));
                endInput.value = formatLocalDate(new Date(today.getFullYear(), today.getMonth() + 1, 0));
            }

            document.getElementById("dateFilterForm").submit();
        });
    });

    function formatLocalDate(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, "0");
        const d = String(date.getDate()).padStart(2, "0");
        return `${y}-${m}-${d}`;
    }

    // ===== PIE CHART =====
    const ctx = document.getElementById("totalChart");
    if (ctx && typeof totalIncomes !== "undefined" && typeof totalExpenses !== "undefined") {
        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Incomes", "Expenses"],
                datasets: [{
                    data: [totalIncomes, totalExpenses],
                    backgroundColor: ["#28a745", "#dc3545"]
                }]
            },
            options: {
                plugins: { legend: { position: "bottom" } }
            }
        });
    }

});
