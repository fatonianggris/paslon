$(function () {
    "use strict";
    var chart = c3.generate({
        bindto: '#visitor',
        data: {
            columns: [
                ['Other', 30],
                ['Desktop', 10],
                ['Tablet', 40],
                ['Mobile', 50],
            ],

            type: 'donut',
            onclick: function (d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function (d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function (d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            label: {
                show: false
            },
            title: "Visits",
            width: 40,

        },

        legend: {
            hide: true
                    //or hide: 'data1'
                    //or hide: ['data1', 'data2']
        },
        color: {
            pattern: ['#eceff1', '#f62d51', '#6772e5', '#009efb']
        }
    });
    // ============================================================== 
    // Our Income
    // ==============================================================
    var chart = c3.generate({
        bindto: '#income',
        data: {
            x: 'x',
            columns: [
                ['x', 'rudi', 'sony', 'rona'],
                ['Jumlah e-KTP', 90, 100, 140],
            ],
            type: 'bar'
        },
        bar: {
            space: 0.2,
            // or
            width: 40 // this makes bar width 100px
        },
        axis: {
            x: {
                type: 'category',
                tick: {centered: true},

            }
        },
        legend: {
            hide: true
                    //or hide: 'data1'
                    //or hide: ['data1', 'data2']
        },
        grid: {
            x: {
                show: false
            },
            y: {
                show: true
            }
        },
        size: {
            height: 290
        },
        color: {
            pattern: ['#7460ee', '#009efb']
        }
    });
    // Dashboard 1 Morris-chart
});
