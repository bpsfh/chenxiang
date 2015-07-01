<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-eye"></i> <?php echo $heading_title; ?></h3>
  </div>
  <div class="panel-body">
    <div id="vmap" style="width: 100%; height: 260px;"></div>
  </div>
</div>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="view/javascript/jquery/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.js"></script>
<!--<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.js"></script> -->
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$.ajax({
		url: 'index.php?route=dashboard/map/map&token=<?php echo $token; ?>',
		dataType: 'json',
		success: function(json) {

	        var dataSet = [
	            { label: "Asia", data: 4119630000, color: "#005CDE" },
	            { label: "Latin America", data: 590950000, color: "#00A36A" },
	            { label: "Africa", data: 1012960000, color: "#7D0096" },
	            { label: "Oceania", data: 35100000, color: "#992B00" },
	            { label: "Europe", data: 727080000, color: "#DE000F" },
	            { label: "North America", data: 344120000, color: "#ED7B00" }    
	        ];

	        var options = {
	        	    series: {
	        	        pie: {
	        	            show: true,
	        	            label: {
	        	                show: true,
	        	                radius: 180,
	        					formatter: function(label, series) {
	        						return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
	        					},
	        	                background: {
	        	                    opacity: 0.8,
	        	                    color: '#000'
	        	                }
	        	            }
	        	        }
	        	    },
	        	    legend: {
	        	        show: true
	        	    },
	        	    grid: {
	        	        hoverable: true
	        	    }
	        	};
	
	        var option = {
	          series: {
	            pie: {
	              show: true,                
	              label: {
	                show:true,
	                radius: 0.8,
					formatter: function(label, series) {
						return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
					},
	                background: {
	                    opacity: 0.8,
	                    color: '#000'
	                },
	                threshold: 0.03
	              }
	            }
	          }
	        };

		    $.plot('#vmap', dataSet, options);

		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
