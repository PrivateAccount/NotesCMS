<?php

$main_template_content = '

	<style>
		section.admin { color: #666; }
		section.admin h3 { text-align: left; }
	</style>
	
	<table width="100%">
		<tr>
			<td>&nbsp;</td>
			<td style="border-bottom: 1px solid #ccc;">
				<h3 class="panel-title"><i class="fas fa-tools"></i>&nbsp; Panel administratora</h3>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="10%">&nbsp;</td>
			<td width="80%">
				'
					.$this->get_content().
				'
			</td>
			<td width="10%">&nbsp;</td>
		</tr>
	</table>

';

?>

