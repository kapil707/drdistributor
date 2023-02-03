<script>
$(function() {
    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.8
                    }, {
                        opacity: 0.8
                    }]
                }
            }
        },
        xaxis: {
            tickDecimals: 0
        },
        colors: ["#1ab394"],
        grid: {
            color: "#999999",
            hoverable: true,
            clickable: true,
            tickColor: "#D4D4D4",
            borderWidth:0
        },
        legend: {
            show: false
        },
        tooltip: true,
        tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar",
        data: [
            [1, 34],
            [2, 25],
            [3, 19],
            [4, 34],
            [5, 32],
            [6, 44],
			[7, 32],
			[8, 32],
			[9, 32]
        ]
    };
    $.plot($("#flot-bar-chart"), [barData], barOptions);

});
$(function() {
	Morris.Bar({
		element: 'morris-bar-chart',
		/*data: [{ y: '2006', a: 60},
			{ y: '2007', a: 75},
			{ y: '2008', a: 50},
			{ y: '2009', a: 75},
			{ y: '2010', a: 50},
			{ y: '2011', a: 75},
			{ y: '2012', a: 100}],*/
		data: [<?php echo $top_10_medicine ?>],			
		xkey: 'y',
		ykeys: ['a'],
		labels: ['Series A'],
		hideHover: 'auto',
		resize: true,
		barColors: ['#1ab394', '#cacaca'],
	});
});
</script>