
/*==== result-chart =====*/
var ctx = document.getElementById('line-chart');
Chart.defaults.global.defaultFontFamily = 'Cabin';
Chart.defaults.global.defaultFontSize = 14;
Chart.defaults.global.defaultFontStyle = '500';
Chart.defaults.global.defaultFontColor = '#808996';
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Result",
            data: [0, 20, 5, 40, 15, 40, 20, 50],
            backgroundColor: 'transparent',
            borderColor: '#287dfa',
            pointBorderColor: '#ffffff',
            pointBackgroundColor: '#287dfa',
            pointBorderWidth: 2,
            pointRadius: 4

        }, {
            label: "Result 2",
            data: [10, 40, 25, 15, 45, 25, 50, 30],
            backgroundColor: 'transparent',
            borderColor: '#28d5a7',
            pointBorderColor: '#ffffff',
            pointBackgroundColor: '#28d5a7',
            pointBorderWidth: 2,
            pointRadius: 4
        }]
    },

    // Configuration options go here
    options: {
        tooltips: {
            // xPadding: 12,
            // yPadding: 12,
            backgroundColor: '#1c2540'
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    offsetGridLines: false,
                    display: false
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: '#eee',
                },
                ticks: {
                    fontSize: 14,
                }
            }]

        }
    }
});