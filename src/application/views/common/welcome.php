 <section class="content-header">
          <h1>
            Dashboard
            <small>TMS</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">General</li>
          </ol>
        </section>
  
  <style>
  chart-1{
	  width:100% !important;}
	 .highcharts-container{
		width:100% !important; }
  </style>

	  <section class="content">
      <div class="row">
		
	  
		<div class="col-md-4">
		<div class="box box-primary" style='min-height:200px'>
            <div class="box-header with-border">
              <h3 class="box-title">Chart KPI of Delivery</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				
				<div id="container4" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
				
              </div>
              <!-- /.box-body -->
            </form>
          </div>
		</div>

        <div class="col-md-4">
        <div class="box box-primary" style='min-height:200px'>
            <div class="box-header with-border">
              <h3 class="box-title">Chart KPI of Delivery</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                
                <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                
              </div>
              <!-- /.box-body -->
            </form>
          </div>
        </div>
		
		<div class="col-md-4">
		<div class="box box-primary" style='min-height:200px'>
            <div class="box-header with-border">
              <h3 class="box-title">Chart KPI Arrival Truck Ontime</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				
				<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
				
              </div>
              <!-- /.box-body -->
            </form>
          </div>
		</div>
		
		
		
		
		</section>

<script>

// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'KPI Arrival Truck Ontime'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Late - Driver Late',
            y: 56.33
        }, {
            name: 'Late - Load Trip 2',
            y: 24.03,
            sliced: true,
            selected: true
        }, {
            name: 'Late - Muat Gantung',
            y: 10.38
        }, {
            name: 'OnTime',
            y: 4.77
        }]
    }]
});
</script>		
	


<script>

// Create the chart
Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Avarage of waiting time to load'
    },
    
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Average'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: '02-Jan-2018',
            y: 56.33,
            drilldown: '02-Jan-2018'
        }, {
            name: '03-Jan-2018',
            y: 24.03,
            drilldown: '03-Jan-2018'
        }, {
            name: '04-Jan-2018',
            y: 10.38,
            drilldown: '04-Jan-2018'
        }, {
            name: '05-Jan-2018',
            y: 4.77,
            drilldown: '05-Jan-2018'
        }, {
            name: '06-Jan-2018',
            y: 0.91,
            drilldown: '06-Jan-2018'
        }, {
            name: '07-Jan-2018',
            y: 56.33,
            drilldown: '07-Jan-2018'
        }]
    }],
    drilldown: {
        series: [{
            name: 'Microsoft Internet Explorer',
            id: 'Microsoft Internet Explorer',
            data: [
                [
                    'v11.0',
                    24.13
                ],
                [
                    'v8.0',
                    17.2
                ],
                [
                    'v9.0',
                    8.11
                ],
                [
                    'v10.0',
                    5.33
                ],
                [
                    'v6.0',
                    1.06
                ],
                [
                    'v7.0',
                    0.5
                ]
            ]
        }, {
            name: 'Chrome',
            id: 'Chrome',
            data: [
                [
                    'v40.0',
                    5
                ],
                [
                    'v41.0',
                    4.32
                ],
                [
                    'v42.0',
                    3.68
                ],
                [
                    'v39.0',
                    2.96
                ],
                [
                    'v36.0',
                    2.53
                ],
                [
                    'v43.0',
                    1.45
                ],
                [
                    'v31.0',
                    1.24
                ],
                [
                    'v35.0',
                    0.85
                ],
                [
                    'v38.0',
                    0.6
                ],
                [
                    'v32.0',
                    0.55
                ],
                [
                    'v37.0',
                    0.38
                ],
                [
                    'v33.0',
                    0.19
                ],
                [
                    'v34.0',
                    0.14
                ],
                [
                    'v30.0',
                    0.14
                ]
            ]
        }, {
            name: 'Firefox',
            id: 'Firefox',
            data: [
                [
                    'v35',
                    2.76
                ],
                [
                    'v36',
                    2.32
                ],
                [
                    'v37',
                    2.31
                ],
                [
                    'v34',
                    1.27
                ],
                [
                    'v38',
                    1.02
                ],
                [
                    'v31',
                    0.33
                ],
                [
                    'v33',
                    0.22
                ],
                [
                    'v32',
                    0.15
                ]
            ]
        }, {
            name: 'Safari',
            id: 'Safari',
            data: [
                [
                    'v8.0',
                    2.56
                ],
                [
                    'v7.1',
                    0.77
                ],
                [
                    'v5.1',
                    0.42
                ],
                [
                    'v5.0',
                    0.3
                ],
                [
                    'v6.1',
                    0.29
                ],
                [
                    'v7.0',
                    0.26
                ],
                [
                    'v6.2',
                    0.17
                ]
            ]
        }, {
            name: 'Opera',
            id: 'Opera',
            data: [
                [
                    'v12.x',
                    0.34
                ],
                [
                    'v28',
                    0.24
                ],
                [
                    'v27',
                    0.17
                ],
                [
                    'v29',
                    0.16
                ]
            ]
        }]
    }
});
</script>	


<script>


Highcharts.chart('container3', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Shipment By Area'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: ['Jakarta', 'Bandung', 'Cikupa', 'Jakarta Timur', 'Jakarta Barat', 'Jakarta Selatan',
            'Depok', 'Tangerang', 'Bekasi', 'Jakarta Pusat', 'Jakarta Utara', 'Bogor'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Total Shipment',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: 'Total Shipment',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        opposite: true
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'Total Shipment',
        type: 'column',
        yAxis: 1,
        data: [49, 71, 106, 129, 144, 176, 135, 148, 216, 194, 95, 54],
        tooltip: {
            valueSuffix: ''
        }

    }, {
        name: 'Total Shipment',
        type: 'spline',
        data: [49, 71, 106, 129, 144, 176, 135, 148, 216, 194, 95, 54],
        tooltip: {
            valueSuffix: '°C'
        }
    }]
});
</script>


<script>


// Make monochrome colors
var pieColors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('container4', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'KPI of Delivery'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        data: [
            { name: 'OnTime', y:90 },
            { name: 'Late', y: 10 }
        ]
    }]
});
</script>



<script>


Highcharts.chart('container5', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Untilization Of Dedicated Truck'
    },
    xAxis: [{
        categories: ['B 900 UB', 'B 901 UB', 'B 902 UB', 'B 903 UB', 'B 904 UB', 'B 905 UB',
            'B 906 UB', 'B 907 UB', 'B 908 UB', 'B 909 UB', 'B 910 UB', 'B 911 UB'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Total Shipment',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: 'Total Shipment',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        opposite: true
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'Utilization',
        type: 'column',
        yAxis: 1,
        data: [49, 71, 106, 129, 144, 176, 135, 148, 216, 194, 95, 54],
        tooltip: {
            valueSuffix: ''
        }

    },{
        name: 'Utilization',
        type: 'spline',
        data: [49, 71, 106, 129, 144, 176, 135, 148, 216, 194, 95, 54],
        tooltip: {
            valueSuffix: ''
        },
		
	
    },{
        name: 'Target',
        type: 'spline',
        data: [300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300, 300],
        tooltip: {
            valueSuffix: ''
        },
		
	
    }]
});
</script>

<script>

Highcharts.chart('container6', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Utilization Per truck'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Utilization Per truck'
    },
    series: [{
        name: 'Population',
        data: [
            ['01-jan-2018', 23.7],
            ['02-jan-2018', 16.1],
            ['03-jan-2018', 14.2],
            ['04-jan-2018', 14.0],
            ['05-jan-2018', 12.5],
            ['06-jan-2018', 12.1],
            ['07-jan-2018', 11.8],
            ['08-jan-2018', 11.7],
            ['09-jan-2018', 11.1],
            ['10-jan-2018', 11.1],
            ['11-jan-2018', 10.5],
            ['12-jan-2018', 10.4],
            ['13-jan-2018', 10.0],
            ['14-jan-2018', 9.3],
            ['15-jan-2018', 9.3],
            ['16-jan-2018', 9.0],
            ['17-jan-2018', 8.9],
            ['18-jan-2018', 8.9],
            ['19-jan-2018', 8.9],
            ['20-jan-2018', 8.9]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>


<script>

Highcharts.chart('container7', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Waiting time to load Muat Gantung'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Waiting time to load Muat Gantung: <b>{point.y:.1f} millions</b>'
    },
    series: [{
        name: 'Population',
        data: [
            ['01-jan-2018', 23.7],
            ['02-jan-2018', 16.1],
            ['03-jan-2018', 14.2],
            ['04-jan-2018', 14.0],
            ['05-jan-2018', 12.5],
            ['06-jan-2018', 12.1],
            ['07-jan-2018', 11.8],
            ['08-jan-2018', 11.7],
            ['09-jan-2018', 11.1],
            ['10-jan-2018', 11.1],
            ['11-jan-2018', 10.5],
            ['12-jan-2018', 10.4],
            ['13-jan-2018', 10.0],
            ['14-jan-2018', 9.3],
            ['15-jan-2018', 9.3],
            ['16-jan-2018', 9.0],
            ['17-jan-2018', 8.9],
            ['18-jan-2018', 8.9],
            ['19-jan-2018', 8.9],
            ['20-jan-2018', 8.9]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
</script>




<script>


// Make monochrome colors
var pieColors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('container10', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'KPI By Mechanic'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        data: [
            { name: 'OnTime', y:80 },
            { name: 'Late', y: 20 }
        ]
    }]
});
</script>






<script>


// Make monochrome colors
var pieColors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('container11', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'KPI All Mechanic'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        data: [
            { name: 'OnTime', y:70 },
            { name: 'Late', y: 30 }
        ]
    }]
});
</script>


<script>


Highcharts.chart('container13', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'KPI BY Mechanic'
    },
    xAxis: {
        categories: [
            'Mechanic 1',
            'Mechanic 2',
            'Mechanic 3',
            'Mechanic 4',
            'Mechanic 5',
            'Mechanic 6',
            'Mechanic 7',
            'Mechanic 8',
            'Mechanic 9',
            'Mechanic 10',
            'Mechanic 11',
            'Mechanic 12'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: '%'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Late',
        data: [30, 15, 25, 23, 27, 13, 43, 3, 13,21, 22, 27]

    }, {
        name: 'Ontime',
        data: [70, 85, 75, 77, 73, 87, 57, 97, 87, 79, 78, 73]

    }]
});
</script>


<script>


Highcharts.chart('container20', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Chart Sales and Cost'
    },
    xAxis: {
        categories: [
            '01-feb-2018',
            '02-feb-2018',
            '03-feb-2018',
            '04-feb-2018',
            '05-feb-2018',
            '06-feb-2018',
            '07-feb-2018',
            '08-feb-2018',
            '09-feb-2018',
            '10-feb-2018',
            '11-feb-2018',
            '12-feb-2018'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'IDR'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Sales',
        data: [1500000, 1200000, 1500000, 1100000, 1700000, 1800000, 1900000, 2000000, 2500000,2100000, 2500000, 2600000]

    }, {
        name: 'Cost',
        data: [1000000, 1000000, 1000000, 700000, 1000000, 1000000, 1000000, 1500000, 1600000,1800000, 1500000, 2200000]

    }, {
        name: 'Gross Profit',
        data: [500000, 200000, 500000, 400000, 700000, 800000, 900000, 500000, 900000,300000, 500000, 400000]

    }]
});
</script>