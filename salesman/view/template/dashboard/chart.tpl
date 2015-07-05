<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> <?php echo $heading_title; ?></h3>
  </div>
  <div class="panel-body">
    <div id="chart-all" style="width: 100%; height: 260px;"></div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.js"></script> 
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=dashboard/chart/chart&token=<?php echo $token; ?>&salesman_id=<?php echo $salesman_id?>', 
		dataType: 'json',
		success: function(json) {
       		     	if (typeof json['order'] == 'undefined') { return false; }
			var option = {	
				shadowSize: 0,
				colors: ['#1065D2', '#DE000F', '#8CEA00']
				,bars: { 
					show: true
					,align: "center"
//					,fill: true     // comment when use [lines]
					,lineWidth: 2   // comment when use [bars]
					,steps: false   // comment when use [bars]
				}
				,grid: {
					backgroundColor: '#FFFFFF'
					,hoverable: true
				}
				,points: {
					show: true
				}
				,xaxis: {
					show: true
					,tickSize: 2
		            		,ticks: json['xaxis']
				}
			};

			$.plot('#chart-all', [json['order'], json['sale'], json['commission']], option);
			$("#chart-all").UseTooltip();

		},
       		error: function(xhr, ajaxOptions, thrownError) {
           		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
       		}
	});
});

var previousPoint = null, previousLabel = null;
$.fn.UseTooltip = function () {
	$(this).bind("plothover", function (event, pos, item) {
		if (item) {
			if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
				previousPoint = item.dataIndex;
				previousLabel = item.series.label;
				$("#tooltip").remove();

				var x = item.datapoint[0];
				var y = item.datapoint[1];

				var color = item.series.color;

				//console.log(item.series.xaxis.ticks[x].label);				

				showTooltip(item.pageX,
				item.pageY,
				color,
				"<strong>" + item.series.label + "</strong><br>" + item.series.xaxis.ticks[x].label + " : <strong>" + y + "</strong>");
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
	});
};

function showTooltip(x, y, color, contents) {
	$('<div id="tooltip">' + contents + '</div>').css({
		position: 'absolute',
		display: 'none',
		top: y - 40,
		left: x - 120,
		border: '2px solid ' + color,
		padding: '3px',
		'font-size': '9px',
		'border-radius': '5px',
		'background-color': '#fff',
		'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
		opacity: 0.9
	}).appendTo("body").fadeIn(200);
}
//--></script> 
