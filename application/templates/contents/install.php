<?php

$main_template_content = 

'
	<h3 style="text-align: center; padding: 1em; color: #900;">Instalacja serwisu</h3>

	<table width="100%">
		<tr class="install">
			<td style="vertical-align: top; padding: 1em 0;">
				<p style="color: #369;">Pierwsze trzy kroki instalacji, tj. skopiowanie skryptów na serwer, utworzenie bazy danych oraz ustawienie połączenia z bazą danych, zostały wykonane poprawnie.</p>
				<p style="color: #369;">Jednak serwis nie został jeszcze do końca zainstalowany. Aby ukończyć instalację serwisu, proszę wykonać kroki oznaczone kolorem czerwonym:</p>
				<ol>
					<li style="color: #0c0;">
						<b>OK:</b><br> Instalacja skryptów aplikacji na serwerze w katalogu <b>public_html</b>.
					</li>
					<li style="color: #0c0;">
						<b>OK:</b><br> Utworzenie bazy danych. Należy zapamiętać podane przy zakładaniu bazy parametry dostępu, tj. <b>host</b>, <b>user</b>, <b>password</b> oraz <b>baza</b>.
					</li>
					<li style="color: #0c0;">
						<b>OK:</b><br> Edycja <b>pliku konfiguracji</b> serwisu (<b>config/config.php</b>) - w sekcji dot. połączenia z bazą danych podać parametry <b>host</b>, <b>user</b>, <b>password</b> oraz <b>baza</b> takie same, jak podczas tworzenia bazy.
					</li>
					<li style="color: #0c0;">
						<b>OK:</b><br> Uruchomienie instalatora serwisu - link: <b>http://{domena_serwisu}/install</b>.
					</li>
					<li style="color: #c00;">
						<b>Pozostało:</b><br> Wprowadzić podstawowe informacje konfiguracyjne serwisu za pomocą formularza <b>Ustawienia serwisu</b>.
					</li>
					<li style="color: #c00;">
						<b>Pozostało:</b><br> Zalogować się na konto administratora, używając podanych w formularzu konfiguracyjnym <b>logina</b> oraz <b>hasła</b>, i rozpocząć zarządzanie serwisem.
					</li>
				</ol>
			</td>
			<td style="vertical-align: top; padding: 5px 0px 0px 10px;">
				'
					. $this->get_content() .
				'
			</td>
		</tr>
	</table>
'

. $this->show_message();

?>
