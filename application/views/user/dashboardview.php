<div class="container">
	<div class="hero-unit">
	        <h1>Dashboard view</h1>
	        <p>This is a placeholder for content to come. I would like to include more graphs, capture more issue metrics, and display meaningful information in a way that is beneficial to the user. This screen is only an overview; the main content of the application is found in the issues and test case sections.</p>
	        <p><a href="<?= site_url('home/issueList'); ?>" class="btn btn-primary btn-large">Go to issues &raquo;</a></p>
	</div>
	

	
	<div class="row">	
		<div class="span6">
			<div id='chart1'></div>
		</div>
		<div class="span6">
			<div id='chart3'></div>
		</div>
	</div>
	
	<div class="row">	
		<div class="span12">
			<h3>Recent Activity</h3>
				<? foreach ($edits as $q): ?>
					<p><?=$q['fullname'];?> made changes to <a href="<?=site_url('home/viewIssue/').'/'.$q['issue_id']; ?>" title="<?=$q['item']; ?>" class="linktip"><?=$q['short_tag'];?>-<?=$q['issue_id']; ?></a> <?=$q['time'] ?> ago</p>
				<? endforeach ?>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
  var data = <?=$counts; ?>;
  var plot1 = jQuery.jqplot ('chart1', [data],
    {
	title: 'Outstanding Issues by Type',
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      legend: { show:true, location: 'e' }
    }
  );

  var powPoints1 = [];
  for (var i=0; i<2*Math.PI; i+=0.4) {
      powPoints1.push([i, 2.5 + Math.pow(i/4, 2)]);
  }
    
  var powPoints2 = [];
  for (var i=0; i<2*Math.PI; i+=0.4) {
      powPoints2.push([i, -2.5 - Math.pow(i/4, 2)]);
  }
 
  var plot3 = $.jqplot('chart3', [powPoints1, powPoints2],
    {
      title:'UNIMPLEMENTED CHART',
      legend: { show:true, location: 'e' },
      series:[
          {
            lineWidth:2,
            markerOptions: { style:'diamond' }
          },
          {
            showLine:false,
            markerOptions: { size: 7, style:"x" }
          },
          {
            // Use (open) circlular markers.
            markerOptions: { style:"circle" }
          },
          {
            lineWidth:5,
            markerOptions: { style:"filledSquare", size:10 }
          },
      ]
    }
  );
});

$('li').removeClass('active');
$('#dashboard').addClass('active');
$('.linktip').tooltip();

</script>