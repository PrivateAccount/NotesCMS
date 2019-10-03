<?php

$main_template_content = NULL;

$mode = isset($_GET['mode']) ? $_GET['mode'] : NULL;

$main_template_content .= '

    <script src="js/chart/Chart.js"></script>
    <script src="js/chart/Chart.HorizontalBar.js"></script>
    <script src="js/chart/Ajax.js"></script>
	
';

if ($mode == 'ip')
{
	$main_template_content .= $this->get_content() . $this->show_message() .
	'
		<script type="text/javascript">

			$(document).ready(function(){
				horizontal_chart();
			});

		</script>
	'
	;
}
else
{
	$main_template_content .= $this->get_content() . $this->show_message() .
	'
		<script type="text/javascript">

			$(document).ready(function(){
				$("#months_1").click();
			});

		</script>
	'
	;
}

?>
