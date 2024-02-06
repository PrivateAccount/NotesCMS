<?php

$main_template_content = '

	<style>
		section.admin h3.panel-title { margin: 2em; }
	</style>
	
	<table width="100%">
		<tr>
			<td>
				<h3 class="panel-title"><i class="fas fa-tools"></i>&nbsp; Panel administratora</h3>
			</td>
		</tr>
		<tr>
			<td>
				'
					. $this->get_content() .
				'
			</td>
		</tr>
	</table>

';

?>

