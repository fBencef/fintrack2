@props(['data'])

<div class="relative h-64">
    <canvas id="expenseChart"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('expenseChart');
        if (!ctx) return;

        const chartData = @json($data);

        // Standard colors categories
        const colors = [
            '#4F46E5', // Indigo
            '#10B981', // Emerald
            '#F59E0B', // Amber
            '#EF4444', // Red
            '#8B5CF6', // Violet
            '#EC4899', // Pink
            '#3B82F6', // Blue
            '#6B7280'  // Gray
        ];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartData.map(item => item.category_name),
                datasets: [{
                    data: chartData.map(item => item.total),
                    backgroundColor: colors,
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: { size: 11 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>