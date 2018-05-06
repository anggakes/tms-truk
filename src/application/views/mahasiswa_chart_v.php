<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="http://code.highcharts.com/highcharts.src.js"></script>

<script>
var chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container',
        defaultSeriesType: 'column',
        borderWidth: 1,
        borderColor: '#ccc',
        marginLeft: 110,
        marginRight: 50,
        //backgroundColor:'#eee',
        //plotBackgroundColor:'#fff',
    },
    title: {
        text: 'Pareto Test 1'
    },
    legend: {

    },
    tooltip: {
        formatter: function () {
            if (this.series.name == 'Line') {
                var pcnt = Highcharts.numberFormat((this.y / 415 * 100), 0, '.');
                return pcnt + '%';
            }
            return this.y;
        }
    },
    plotOptions: {
        series: {
            shadow: false,
        }
    },
    xAxis: {
        categories: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
        lineColor: '#999',
        lineWidth: 1,
        tickColor: '#666',
        tickLength: 3,
        title: {
            text: 'X Axis Title',
            style: {
                color: '#000'
            }

        }
    },
    yAxis: [{
        min: 0,
        //endOnTick:false,
        //lineColor:'#999',
        lineWidth: 1
        //tickColor:'#666',
        //tickWidth:1,
        //tickLength:3,
        //gridLineColor:'#ddd',
        /* title:{
            text:'Y Axis Title',
            rotation:0,
            margin:50,
            style:{
                color:'#000'
            }
        }*/
    }, {
        title: {
            text: ''
        },
        //alignTicks:false,
        gridLineWidth: 0,
        lineColor: '#999',
        lineWidth: 1,
        tickColor: '#666',
        tickWidth: 1,
        tickLength: 3,
        tickInterval: 415 / 20,
        endOnTick: false,
        opposite: true,
        linkedTo: 0,
        labels: {
            formatter: function () {
                var pcnt = Highcharts.numberFormat((this.value / 415 * 100), 0, '.');
                return pcnt + '%';
            }
        },
        plotLines: [{
            color: '#FF0000',
            width: 2,
            value: .80 * 415 // Need to set this probably as a var.
        }]
    }],
    series: [{
        //yAxis:0,
        data: [115, 75, 60, 55, 45, 30, 20, 15]
    }, {
        type: 'line',
        name: 'Line',
        //yAxis:0,
        data: [115, 190, 250, 305, 350, 380, 400, 415]
    }]
});
</script>
</head>
<body>

<div id="container" style="height: 400px"></div>
 
</body>
</html>