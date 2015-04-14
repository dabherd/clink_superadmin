<?php include('calendar_functions.php'); ?>
<section>
	<?php
	$thisMonth = 0;
	$thisYear = 0;
	if(isset($_GET['month'])) {
		$thisMonth = $_GET['month'];
	} else {
		$thisMonth = date('n');
	}

	if(isset($_GET['year'])) {
		$thisYear = $_GET['year'];
	} else {
		$thisYear = date('Y');
	}
	?>
	<div>
		<h3 style="margin-top: -10px;">
			<?php
				//echo '<center>'.date('F', mktime(0, 0, 0, $thisMonth)).' '.$thisYear.'</center>';
			?>
		</h3>
	</div>
	<div class="controls">
		<?php
			//echo calendar_controls($thisMonth, $thisYear);
		?>
	</div>	
	<div>
		<?php
		$events = calendar_events($thisYear, $thisMonth);
		echo '<center>'.draw_calendar($thisMonth, $thisYear, $events).'</center>';
		?>
	</div>			
</section>
