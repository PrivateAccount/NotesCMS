<?php

$main_template_content = 

$this->get_content() . 

'
	<p style="text-align: center; font-size: small;">
		<a href="index.php?route=login">Mam konto w serwisie. Przejdź do logowania.</a>
	</p>
	<p style="text-align: center; font-size: small;">
		<a href="index.php?route=register">Nie mam konta w serwisie. Zarejestruj konto.</a>
	</p>
'

. $this->show_message();

?>
