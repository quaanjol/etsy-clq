// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
function drawPieChart(labels, data, color, hoverColor) {
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["Direct", "Referral", "Social"],
            labels: labels,
            datasets: [{
                // data: [55, 30, 15],
                data: data,
                //backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                backgroundColor: color,
                // backgroundColor: ['#e74a3b', '#f6c23e', '#4e73df', '#1cc88a'],
                // hoverBackgroundColor: ['#e74a3b', '#f6c23e', '#4e73df', '#1cc88a'],
                hoverBackgroundColor: hoverColor,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
}