( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSChartHandler = function( $scope, $ ) {
        elementorFrontend.waypoint($scope.find('.cms-charts-wrap'), function () {
            var charts = $(this).find(".cms-charts"),
                data = charts.data(), 
                settings = data.settings;
            // Doughnut chart
            chart_settings = { 
                type: settings['type'],
                data: {
                    labels: settings['labels'],
                    datasets: [{
                        data: settings['value'],
                        backgroundColor: settings['colors'],
                        borderWidth: 0,
                        borderColor: '#ffffff',
                        //fill: false,
                        //borderColor: 'rgb(75, 192, 192)',
                        //tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display:  settings['title_display'],
                            text:  settings['title_text'],
                            position: settings['title_position'],
                            fontSize: 16,
                            fontColor: '#111',
                            padding: 20
                        },
                        legend: {
                            display: settings['legend_display'],
                            position: settings['legend_position'],
                            labels: {
                                boxWidth: 10,
                                fontColor: '#9b9b9b',
                                padding: 15
                            }
                        },
                        tooltips: {
                            enabled: true
                        },
                        datalabels: {
                            color: '#111',
                            textAlign: 'center',
                            font: {
                                lineHeight: 1.6
                            },
                            formatter: function(value, ctx) {
                                return ctx.chart.data.labels[ctx.dataIndex] + 'n'+ 'n'+ 'n'+ 'n'+ 'n'+ 'n' + value + '%';
                            }
                        },
                        deferred: {           // enabled by default
                            //xOffset: 150,     // defer until 150px of the canvas width are inside the viewport
                            yOffset: '100%',    // defer until 50% of the canvas height are inside the viewport
                            delay: 1000       // delay of 500 ms after the canvas is considered inside the viewport
                        }
                    }
                }
            };
            charts.each(function(index, element) {
                var ctx = charts.attr('id');
                var myChart = new Chart(ctx, chart_settings);
            });
        },{
            offset: '95%',
            triggerOnce: true
        });
    };
    // Bar chart
    var WidgetCMSChartBarHandler = function( $scope, $ ) {
        var charts = $scope.find(".cms-charts-bar"),
            data = charts.data(), 
            settings = data.settings;
        chart_settings = { 
            type: settings['type'],
            data: {
                labels: settings['labels'],
                datasets: settings['datasets']
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display:  settings['title_display'],
                        text:  settings['title_text'],
                        position: settings['title_position'],
                        fontSize: 16,
                        fontColor: '#111',
                        padding: 20
                    },
                    legend: {
                        display: settings['legend_display'],
                        position: settings['legend_position'],
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            useBorderRadius: true,
                            borderRadius: 5,
                            color: '#9B9B9B',
                            padding: 15
                        }
                    },
                    tooltips: {
                        enabled: true
                    },
                    datalabels: {
                        color: '#00ff00',
                        font: function(context) {
                          var w = context.chart.width;
                          return {
                            size: 20, //w < 512 ? 12 : 14,
                            weight: 'bold',
                          };
                        },
                        formatter: function(value, ctx) {
                            return ctx.chart.data.labels[ctx.dataIndex] + 'n'+ 'n'+ 'n'+ 'n'+ 'n'+ 'n' + value + '%';
                        }
                    }
                },
                elements: {
                  line: {
                    fill: false,
                    tension: 0.4
                  }
                },
                scales: {
                  x: {
                    display: true, // remove horizontal label
                    //offset: false,
                    ticks: {
                        font: {
                            size: 15
                        },
                        color: '#9b9b9b',
                    },
                    grid: { 
                      color: 'transparent', // remove horizontal line
                      borderColor: 'transparent',
                      tickColor: 'transparent' // remove tick line
                    }
                  },
                  y: {
                    beginAtZero: true,
                    //offset: false,
                    ticks: {
                        font: {
                            size: 15
                        },
                        color: '#9b9b9b',
                    }
                  }
                }
            }
        };
        charts.each(function(index, element) {
            var ctx = charts.attr('id');
            var myChart = new Chart(ctx, chart_settings);
        });  
        
    };
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        // Chart Circle
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_chart.default', WidgetCMSChartHandler );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_contact_form.default', WidgetCMSChartHandler );
        // Chart Bar
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_chart_bar.default', WidgetCMSChartBarHandler );
    } );
} )( jQuery );