
/*==== result-chart =====*/
var ctx = document.getElementById('bar-chart');
Chart.defaults.global.defaultFontFamily = 'Cabin';
Chart.defaults.global.defaultFontSize = 14;
Chart.defaults.global.defaultFontStyle = '500';
Chart.defaults.global.defaultFontColor = '#808996';
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
        datasets: [{
            label: "One",
            data: [40, 35, 54, 40, 45, 60, 70, 65, 70, 90],
            backgroundColor: '#287dfa',
            hoverBackgroundColor: '#2273e5',
            pointBackgroundColor: '#fff',
            borderWidth: 0,
            pointRadius: 4
        }]
    },

    // Configuration options go here
    options: {
        tooltips: {
            /*xPadding: 12,
            yPadding: 12,*/
            backgroundColor: '#1c2540'
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                barPercentage: 0.4,
                barThickness: 15,
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
                    /*beginAtZero: true,
                    stepSize: 25,
                    suggestedMin: 50,
                    suggestedMax: 100*/
                }
            }]

        }
    }
});
