<?php

$sql_script = array(
	array(
		'drop_constraints' => array(
			'ALTER TABLE `images` DROP FOREIGN KEY `fk_images_users`;',
			'ALTER TABLE `categories` DROP FOREIGN KEY `fk_categories_users`;',
			'ALTER TABLE `pages` DROP FOREIGN KEY `fk_pages_users`;',
			'ALTER TABLE `notes` DROP FOREIGN KEY `fk_notes_users`;',
			'ALTER TABLE `user_roles` DROP FOREIGN KEY `fk_roles_users`;',
			'ALTER TABLE `user_roles` DROP FOREIGN KEY `fk_roles_functions`;',
			'ALTER TABLE `archives` DROP FOREIGN KEY `fk_archives_users`;',
			'ALTER TABLE `archives` DROP FOREIGN KEY `fk_archives_pages`;',
			'ALTER TABLE `comments` DROP FOREIGN KEY `fk_comments_users`;',
			'ALTER TABLE `comments` DROP FOREIGN KEY `fk_comments_pages`;',
		),
	),
	array(
		'drop_tables' => array(
			'DROP TABLE IF EXISTS `admin_functions`;',
			'DROP TABLE IF EXISTS `archives`;',
			'DROP TABLE IF EXISTS `categories`;',
			'DROP TABLE IF EXISTS `comments`;',
			'DROP TABLE IF EXISTS `configuration`;',
			'DROP TABLE IF EXISTS `excludes`;',
			'DROP TABLE IF EXISTS `hosts`;',
			'DROP TABLE IF EXISTS `images`;',
			'DROP TABLE IF EXISTS `logins`;',
			'DROP TABLE IF EXISTS `pages`;',
			'DROP TABLE IF EXISTS `notes`;',
			'DROP TABLE IF EXISTS `searches`;',
			'DROP TABLE IF EXISTS `users`;',
			'DROP TABLE IF EXISTS `user_messages`;',
			'DROP TABLE IF EXISTS `user_roles`;',
			'DROP TABLE IF EXISTS `visitors`;',
			'DROP TABLE IF EXISTS `stat_main`;',
			'DROP TABLE IF EXISTS `stat_cat`;',
			'DROP TABLE IF EXISTS `stat_ip`;',
		),
	),
	array(
		'create_tables' => array(
			"
				CREATE TABLE IF NOT EXISTS `admin_functions` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `function` varchar(128) NOT NULL,
				  `meaning` varchar(512) NOT NULL,
				  `module` varchar(32) NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `module` (`module`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;			
			",
			"
				CREATE TABLE IF NOT EXISTS `archives` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `page_id` int(11) unsigned NOT NULL,
				  `main_page` tinyint(1) NOT NULL,
				  `system_page` tinyint(1) NOT NULL,
				  `category_id` int(11) unsigned NOT NULL,
				  `title` varchar(512) CHARACTER SET utf8 NOT NULL,
				  `contents` longtext CHARACTER SET utf8,
				  `description` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
				  `author_id` int(11) unsigned NOT NULL,
				  `visible` tinyint(1) NOT NULL,
				  `modified` datetime NOT NULL,
				  `previews` int(11) unsigned NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `page_id` (`page_id`),
				  KEY `fk_pages_users` (`author_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;			
			",
			"
				CREATE TABLE IF NOT EXISTS `categories` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `parent_id` int(11) unsigned NOT NULL,
				  `section` tinyint(1) NOT NULL,
				  `permission` int(11) NOT NULL,
				  `item_order` int(11) NOT NULL,
				  `caption` varchar(128) CHARACTER SET utf8 NOT NULL,
				  `link` varchar(1024) CHARACTER SET utf8 NOT NULL,
				  `page_id` int(11) unsigned NOT NULL,
				  `visible` tinyint(1) NOT NULL,
				  `target` tinyint(1) NOT NULL,
				  `author_id` int(11) unsigned NOT NULL,
				  `modified` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `page_id` (`page_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `comments` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `ip` varchar(20) NOT NULL,
				  `user_id` int(11) unsigned NOT NULL,
				  `page_id` int(11) unsigned NOT NULL,
				  `comment_content` longtext NOT NULL,
				  `send_date` datetime NOT NULL,
				  `visible` tinyint(1) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `user_id` (`user_id`),
				  KEY `page_id` (`page_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `configuration` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `key_name` varchar(30) NOT NULL,
				  `key_value` varchar(1024) NOT NULL,
				  `meaning` varchar(128) DEFAULT NULL,
				  `field_type` int(11) NOT NULL,
				  `active` tinyint(1) NOT NULL,
				  `modified` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `key` (`key_name`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `excludes` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `visitor_ip` varchar(20) NOT NULL,
				  `active` tinyint(1) NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `visitor_ip` (`visitor_ip`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `hosts` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `server_ip` varchar(20) NOT NULL,
				  `server_name` varchar(256) NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `server_ip` (`server_ip`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `images` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `owner_id` int(11) unsigned NOT NULL,
				  `file_format` varchar(32) NOT NULL,
				  `file_name` varchar(512) NOT NULL,
				  `file_size` int(11) NOT NULL,
				  `picture_width` int(11) NOT NULL,
				  `picture_height` int(11) NOT NULL,
				  `modified` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `fk_images_users` (`owner_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `logins` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `agent` varchar(250) NOT NULL,
				  `user_ip` varchar(20) NOT NULL,
				  `user_id` int(11) unsigned NOT NULL,
				  `login` varchar(128) NOT NULL,
				  `password` varchar(128) NOT NULL,
				  `login_time` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `pages` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `main_page` tinyint(1) NOT NULL,
				  `system_page` tinyint(1) NOT NULL,
				  `category_id` int(11) unsigned NOT NULL,
				  `title` varchar(512) CHARACTER SET utf8 NOT NULL,
				  `contents` longtext CHARACTER SET utf8,
				  `description` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
				  `author_id` int(11) unsigned NOT NULL,
				  `visible` tinyint(1) NOT NULL,
				  `modified` datetime NOT NULL,
				  `previews` int(11) unsigned NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `category_id` (`category_id`),
				  KEY `fk_pages_users` (`author_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `notes` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `title` varchar(512) CHARACTER SET utf8 NOT NULL,
				  `contents` longtext CHARACTER SET utf8,
				  `author_id` int(11) unsigned NOT NULL,
				  `modified` datetime NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `fk_notes_users` (`author_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `searches` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `agent` varchar(250) NOT NULL,
				  `user_ip` varchar(20) NOT NULL,
				  `search_text` varchar(128) NULL,
				  `search_time` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE `stat_cat` (
				  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				  `date` date NOT NULL,
				  `category_id` int(10) unsigned NOT NULL,
				  `counter` int(10) unsigned NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `date` (`date`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE `stat_ip` (
				  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				  `date` date NOT NULL,
				  `ip` varchar(15) CHARACTER SET latin2 NOT NULL,
				  `counter` int(10) unsigned NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `date` (`date`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE `stat_main` (
				  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				  `date` date NOT NULL,
				  `start` int(10) unsigned NOT NULL,
				  `contact` int(10) unsigned NOT NULL,
				  `admin` int(10) unsigned NOT NULL,
				  `login` int(10) unsigned NOT NULL,
				  `reset` int(10) unsigned NOT NULL,
				  `statistics` int(10) unsigned NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `date` (`date`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `users` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `user_login` varchar(32) NOT NULL,
				  `user_password` varchar(48) NOT NULL,
				  `user_name` varchar(64) NOT NULL,
				  `user_surname` varchar(128) NOT NULL,
				  `email` varchar(128) NOT NULL,
				  `status` tinyint(2) NOT NULL DEFAULT '3',
				  `registered` datetime NOT NULL,
				  `logged_in` datetime NOT NULL,
				  `modified` datetime NOT NULL,
				  `logged_out` datetime NOT NULL,
				  `active` tinyint(1) NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `user_login` (`user_login`),
				  UNIQUE KEY `email` (`email`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `user_messages` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `client_ip` varchar(20) NOT NULL,
				  `client_name` varchar(128) NOT NULL,
				  `client_email` varchar(256) NOT NULL,
				  `message_content` longtext NOT NULL,
				  `requested` tinyint(1) NOT NULL,
				  `send_date` datetime NOT NULL,
				  `close_date` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `user_roles` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `user_id` int(11) unsigned NOT NULL,
				  `function_id` int(11) unsigned NOT NULL,
				  `access` tinyint(1) NOT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `user_function` (`user_id`,`function_id`),
				  KEY `fk_roles_users` (`user_id`),
				  KEY `fk_roles_functions` (`function_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
			",
			"
				CREATE TABLE IF NOT EXISTS `visitors` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `visitor_ip` varchar(20) NOT NULL,
				  `http_referer` text,
				  `request_uri` text NOT NULL,
				  `visited` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
			",
		),
	),
	array(
		'fill_data' => array(
			"
				INSERT INTO `admin_functions` (`id`, `function`, `meaning`, `module`) VALUES
				(1, 'admin', 'Admin Panel', 'admin'),
				(2, 'config', 'Konfiguracja', 'config'),
				(3, 'template', 'Szablon strony', 'template'),
				(4, 'style', 'Styl strony', 'style'),
				(5, 'script', 'Skrypt strony', 'script'),
				(6, 'users', 'Użytkownicy', 'users'),
				(7, 'ACL', 'Access Control List', 'roles'),
				(8, 'visitors', 'Odwiedziny', 'visitors'),
				(9, 'gallery', 'Galeria', 'images'),
				(10, 'categories', 'Kategorie', 'categories'),
				(11, 'pages', 'Strony', 'pages'),
				(12, 'sites', 'Opisy', 'sites'),
				(13, 'notes', 'Notatki', 'notes'),
				(14, 'comments', 'Komentarze', 'comments'),
				(15, 'messages', 'Wiadomości', 'messages'),
				(16, 'searches', 'Wyszukiwania', 'searches'),
				(17, 'logins', 'Logowania', 'logins'),
				(18, 'excludes', 'Wykluczenia adresów', 'excludes');
			",
			"
				INSERT INTO `configuration` (`id`, `key_name`, `key_value`, `meaning`, `field_type`, `active`, `modified`) VALUES
				(1, 'logo_image', 'gallery/logo/2', 'obrazek logo w nagłówku strony', 1, 1, :save_time),
				(2, 'company_name', :main_title, 'nazwa firmy pokazywana obok obrazka logo', 1, 1, :save_time),
				(3, 'main_title', :main_title, 'tytuł strony internetowej', 1, 1, :save_time),
				(4, 'main_description', :main_description, 'meta tag descriptions nagłówka strony', 2, 1, :save_time),
				(5, 'main_keywords', :main_keywords, 'meta dane keywords strony internetowej', 2, 1, :save_time),
				(6, 'main_author', 'application logic & design: Andrzej Żukowski', 'autor serwisu - logiki biznesowej i designu', 2, 1, :save_time),
				(7, 'base_domain', :base_domain, 'domena (adres) serwisu', 1, 1, :save_time),
				(8, 'page_footer', '<ul class=\"list-inline mb-2\">\r\n  <li class=\"list-inline-item\">\r\n    <a href=\"index.php?route=page&id=3\">O systemie</a>\r\n  </li>\r\n  <li class=\"list-inline-item\">⋅</li>\r\n  <li class=\"list-inline-item\">\r\n    <a href=\"index.php?route=contact\">Kontakt</a>\r\n  </li>\r\n  <li class=\"list-inline-item\">⋅</li>\r\n  <li class=\"list-inline-item\">\r\n    <a href=\"index.php?route=page&id=4\">Regulamin</a>\r\n   </li>\r\n   <li class=\"list-inline-item\">⋅</li>\r\n   <li class=\"list-inline-item\">\r\n     <a href=\"index.php?route=page&id=5\">Polityka prywatności</a>\r\n   </li>\r\n  <li class=\"list-inline-item\">⋅</li>\r\n  <li class=\"list-inline-item\">\r\n    <a href=\"index.php?route=admin\">Admin Panel</a>\r\n  </li>\r\n</ul>\r\n', 'treść w stopce strony', 2, 1, :save_time),
				(9, 'page_template_index', 'index', 'szablon strony głównej (nazwa templatki i stylu)', 1, 1, :save_time),
				(10, 'page_template_default', 'default', 'domyślny (nawigacja i treść) szablon strony (nazwa templatki i stylu)', 1, 1, :save_time),
				(11, 'page_template_extended', 'extended', 'rozszerzony (nawigacja, kategorie i treść) szablon strony (nazwa templatki i stylu)', 1, 1, :save_time),
				(12, 'page_template_admin', 'admin', 'administracyjny (tylko treść) szablon strony (nazwa templatki i stylu)', 1, 1, :save_time),
				(13, 'social_links', '{\r\n \"links\":\r\n [\r\n  {\r\n   \"name\": \"facebook\",\r\n   \"icon\": \"fab fa-facebook\",\r\n   \"link\": \"https://www.facebook.com/zukowski.andrzej\"\r\n  },\r\n  {\r\n   \"name\": \"twitter\",\r\n   \"icon\": \"fab fa-twitter-square\",\r\n   \"link\": \"https://twitter.com/andy_zukowski\"\r\n  },\r\n  {\r\n   \"name\": \"instagram\",\r\n   \"icon\": \"fab fa-instagram\",\r\n   \"link\": \"https://www.instagram.com/andrzej.zukowski/\"\r\n  },\r\n  {\r\n   \"name\": \"linkedin\",\r\n   \"icon\": \"fab fa-linkedin\",\r\n   \"link\": \"https://www.linkedin.com/in/andrzejzukowski/\"\r\n  },\r\n  {\r\n   \"name\": \"github\",\r\n   \"icon\": \"fab fa-github\",\r\n   \"link\": \"https://github.com/PrivateAccount/NotesCMS\"\r\n  },\r\n  {\r\n   \"name\": \"blogger\",\r\n   \"icon\": \"fab fa-blogger\",\r\n   \"link\": \"https://andrzuk.blogspot.com/\"\r\n  }\r\n ]\r\n}', 'ikony z linkami do serwisów społecznościowych', 2, 1, :save_time),
				(14, 'social_links_visible', 'true', 'ikony społecznościowe widoczne', 3, 1, :save_time),
				(15, 'social_buttons', '<span class=\"distance\"></span><span class=\"st_twitter\" displayText=\"&nbsp;\" st_url=\"{{_url_}}\" st_title=\"{{_title_}}\" title=\"Udostępnij na Twitterze\"></span><span class=\"st_googleplus\" displayText=\"&nbsp;\" st_url=\"{{_url_}}\" st_title=\"{{_title_}}\" title=\"Udostępnij w Google+\"></span><span class=\"st_facebook\" displayText=\"&nbsp;\" st_url=\"{{_url_}}\" st_title=\"{{_title_}}\" title=\"Udostępnij na Facebooku\"></span><span class=\"st_linkedin\" displayText=\"&nbsp;\" st_url=\"{{_url_}}\" st_title=\"{{_title_}}\" title=\"Udostępnij w LinkedIn\"></span>', 'przyciski społecznościowe w paskach tytułu artykułów', 2, 1, :save_time),
				(16, 'social_buttons_visible', 'false', 'przyciski społecznościowe widoczne', 3, 1, :save_time),
				(17, 'skip_bar_visible', 'false', 'pasek nawigacji między artykułami widoczny', 3, 1, :save_time),
				(18, 'links_panel_visible', 'true', 'panel górny z linkami widoczny', 3, 1, :save_time),
				(19, 'search_panel_visible', 'true', 'panel wyszukiwania na stronie widoczny', 3, 1, :save_time),
				(20, 'navbar_panel_visible', 'true', 'górny panel nawigacji widoczny', 3, 1, :save_time),
				(21, 'categories_panel_visible', 'false', 'boczny panel nawigacji widoczny', 3, 1, :save_time),
				(22, 'path_panel_visible', 'false', 'panel ze scieżką strony widoczny', 3, 1, :save_time),
				(23, 'logged_panel_visible', 'false', 'panel z nazwiskiem zalogowanego usera widoczny', 3, 1, :save_time),
				(24, 'options_panel_visible', 'true', 'panel menu kontekstowego widoczny', 3, 1, :save_time),
				(25, 'options_panel_border', 'false', 'menu kontekstowe w dedykowanym panelu', 3, 1, :save_time),
				(26, 'articles_pagination_enabled', 'false', 'paginacja artykułów wyświetlanej kategorii włączona', 3, 1, :save_time),
				(27, 'articles_per_page', '4', 'liczba artykułów wyświetlanej kategorii na stronę w paginacji', 1, 1, :save_time),
				(28, 'comments_panel_visible', 'false', 'panel z komentarzami do artykułu widoczny', 3, 1, :save_time),
				(29, 'moderate_comments', 'false', 'wymagane moderowanie komentarzy - widoczne po akceptacji', 3, 1, :save_time),
				(30, 'display_list_rows', '10', 'liczba wierszy listy na jednej stronie', 1, 1, :save_time),
				(31, 'description_length', '50', 'maksymalna długość opisu pozycji na liście znalezionych', 1, 1, :save_time),
				(32, 'page_pointer_band', '4', 'liczebność (połowa) paska ze wskaźnikami stron w pasku nawigacji', 1, 1, :save_time),
				(33, 'send_new_message_report', 'true', 'wysyłanie e-mailem raportów do admina o pojawieniu się nowej wiadomości', 3, 1, :save_time),
				(34, 'black_list_visitors', 'null', 'czarna lista blokowanych adresów IP', 2, 1, :save_time),
				(35, 'email_sender_name', 'Mail Manager', 'nazwa konta e-mailowego serwisu', 1, 1, :save_time),
				(36, 'email_host', 'mail.mvc.net.pl', 'host wysyłania maili', 1, 1, :save_time),
				(37, 'email_port', '587', 'port smtp', 1, 1, :save_time),
				(38, 'email_password', '', 'hasło konta mailingowego', 1, 1, :save_time),
				(39, 'email_sender_address', :email_sender_address, 'adres konta e-mailowego serwisu', 1, 1, :save_time),
				(40, 'email_admin_address', :email_admin_address, 'adres e-mail administratora serwisu', 1, 1, :save_time),
				(41, 'email_report_address', :email_report_address, 'adres e-mail odbiorcy raportów', 1, 1, :save_time),
				(42, 'email_report_subject', 'Raport serwisu', 'temat maila raportującego zdarzenie', 1, 1, :save_time),
				(43, 'email_report_body_1', 'Raport o zdarzeniu w serwisie', 'treść maila rapotującego - część przed zmiennymi', 2, 1, :save_time),
				(44, 'email_report_body_2', '(brak)', 'treść maila rapotującego - część za zmiennymi', 2, 1, :save_time),
				(45, 'email_register_subject', 'Rejestracja w serwisie', 'temat generowanego maila przy rejestracji konta', 1, 1, :save_time),
				(46, 'email_register_body_1', 'Informujemy, że Twoje konto w serwisie zostało poprawnie zarejestrowane. Zostałeś zarejestrowany jako:', 'treść generowanego maila po rejestracji - przed parametrami', 2, 1, :save_time),
				(47, 'email_register_body_2', 'Jako zarejestrowany użytkownik możesz pisać komentarze do artykułów i nimi zarządzać.', 'treść generowanego maila po rejestracji - za parametrami', 2, 1, :save_time),
				(48, 'email_remindpwd_subject', 'Nowe hasło do konta', 'temat generowanego maila z nowym hasłem', 1, 1, :save_time),
				(49, 'email_remindpwd_body_1', 'Na Twoją prośbę przesyłamy Ci nowe hasło logowania.', 'treść generowanego maila z nowym hasłem - przed hasłem', 2, 1, :save_time),
				(50, 'email_remindpwd_body_2', 'Zaloguj się, a następnie zmień hasło na swoje własne.', 'treść generowanego maila z nowym hasłem - za hasłem', 2, 1, :save_time);
			",
			"
				INSERT INTO `users` (`id`, `user_login`, `user_password`, `user_name`, `user_surname`, `email`, `status`, `registered`, `logged_in`, `modified`, `logged_out`, `active`) VALUES
				(1, :admin_login, :admin_password, :first_name, :last_name, :email_admin_address, 1, :save_time, :save_time, :save_time, :save_time, 1);
			",
			"
				INSERT INTO `user_roles` (`id`, `user_id`, `function_id`, `access`) VALUES
				(1, 1, 1, 1),
				(2, 1, 2, 1),
				(3, 1, 3, 1),
				(4, 1, 4, 1),
				(5, 1, 5, 1),
				(6, 1, 6, 1),
				(7, 1, 7, 1),
				(8, 1, 8, 1),
				(9, 1, 9, 1),
				(10, 1, 10, 1),
				(11, 1, 11, 1),
				(12, 1, 12, 1),
				(13, 1, 13, 1),
				(14, 1, 14, 1),
				(15, 1, 15, 1),
				(16, 1, 16, 1),
				(17, 1, 17, 1),
				(18, 1, 18, 1);
			",
			"
				INSERT INTO `pages` (`id`, `main_page`, `system_page`, `category_id`, `title`, `contents`, `description`, `author_id`, `visible`, `modified`, `previews`) VALUES
				(1, 1, 0, 0, 'Strona główna', '  <header class=\"masthead text-white text-center\" style=\"padding: 5rem 0;\">\r\n    <div class=\"overlay\"></div>\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        <div class=\"col-xl-9 mx-auto\">\r\n          <h1 class=\"mb-5\">Witaj w systemie FineCMS!</h1>\r\n        </div>\r\n        <div class=\"col-md-10 col-lg-8 col-xl-7 mx-auto\">\r\n          <h2 class=\"mb-1\">System ten wyróżnia się wyjątkową prostotą i szybkością działania. Obsługa jest łatwa, intuicyjna i przyjemna.</h2>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </header>\r\n\r\n  <section class=\"features-icons bg-light text-center\">\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        <div class=\"col-lg-4\">\r\n          <div class=\"features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3\">\r\n            <div class=\"features-icons-icon d-flex\">\r\n              <i class=\"icon-screen-desktop m-auto text-primary\"></i>\r\n            </div>\r\n            <h3>Strona w pełni responsywna</h3>\r\n            <p class=\"lead mb-0\">Ten szablon będzie wyglądał świetnie na każdym urządzeniu, bez względu na wielkość ekranu!</p>\r\n          </div>\r\n        </div>\r\n        <div class=\"col-lg-4\">\r\n          <div class=\"features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3\">\r\n            <div class=\"features-icons-icon d-flex\">\r\n              <i class=\"icon-layers m-auto text-primary\"></i>\r\n            </div>\r\n            <h3>Oparty na frameworku Bootstrap 4</h3>\r\n            <p class=\"lead mb-0\">Wykorzystuje wszystkie cechy i możliwości najnowszego frameworka Bootstrap 4!</p>\r\n          </div>\r\n        </div>\r\n        <div class=\"col-lg-4\">\r\n          <div class=\"features-icons-item mx-auto mb-0 mb-lg-3\">\r\n            <div class=\"features-icons-icon d-flex\">\r\n              <i class=\"icon-check m-auto text-primary\"></i>\r\n            </div>\r\n            <h3>Intuicyjny i łatwy w obsłudze</h3>\r\n            <p class=\"lead mb-0\">Doskonale nadaje się do prezentacji twoich treści, a jednocześnie ułatwia dostosowanie szablonu!</p>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>\r\n\r\n  <section class=\"call-to-action text-white text-center\" style=\"padding: 0;\">\r\n    <div class=\"overlay\"></div>\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        <div class=\"col-lg-4\">\r\n          <div class=\"testimonial-item mx-auto mb-1 mb-lg-1\" style=\"padding: 5em;\">\r\n            <img class=\"img-fluid rounded-circle mb-1\" src=\"img/template/testimonials-1.jpg\" alt=\"\">\r\n            <h5>Małgorzata</h5>\r\n            <p class=\"font-weight-light mb-0\">\"To jest wspaniała strona! Ogromne dzięki za wsparcie!\"</p>\r\n          </div>\r\n        </div>\r\n        <div class=\"col-lg-4\">\r\n          <div class=\"testimonial-item mx-auto mb-1 mb-lg-1\" style=\"padding: 5em;\">\r\n            <img class=\"img-fluid rounded-circle mb-1\" src=\"img/template/testimonials-2.jpg\" alt=\"\">\r\n            <h5>Tomasz</h5>\r\n            <p class=\"font-weight-light mb-0\">\"Ta platforma jest niesamowita. Używałem jej, aby stworzyć wiele ładnych stron domowych i firmowych.\"</p>\r\n          </div>\r\n        </div>\r\n        <div class=\"col-lg-4\">\r\n          <div class=\"testimonial-item mx-auto mb-1 mb-lg-1\" style=\"padding: 5em;\">\r\n            <img class=\"img-fluid rounded-circle mb-1\" src=\"img/template/testimonials-3.jpg\" alt=\"\">\r\n            <h5>Sabina</h5>\r\n            <p class=\"font-weight-light mb-0\">\"Ogromne dzięki za udostępnienie nam szablonu, dzięki któremu stworzyliśmy nasze strony!\"</p>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </section>\r\n', 'Strona główna serwisu', 1, 1, :save_time, 0),
				(2, 0, 1, 0, 'Kontakt', '<style>\r\ndiv.page-content { padding-top: 10px; }\r\ndiv.page-content > h4 { margin-bottom: 20px; padding-bottom: 30px; }\r\ndiv.msg { padding: 0; margin: 0 0 20px 0; font-size: 1.25em; color: #777; }\r\ndiv.adr { font-size: 0.9em; margin: 10px 0px; }\r\ndiv.map { padding-top: 20px; }\r\ndiv.note { font-size: 0.75em; color: #999; }\r\ndiv.contact-form { padding-top: 10px; }\r\nimg.social-icon { width: 32px; padding: 0 10px 0 0; }\r\na.social-link { position: relative; bottom: 1px; }\r\ndiv#yt-subscribe { position: absolute; right: 15px; border: 1px solid #ccc; padding: 5px 5px 0 5px; }\r\n</style>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-md-6\">\r\n<div class=\"msg\">Gdzie można mnie znaleźć:</div>\r\n<div id=\"yt-subscribe\">\r\n<script src=\"https://apis.google.com/js/platform.js\"></script>\r\n<div class=\"g-ytsubscribe\" data-channel=\"MrAndrzuk\" data-layout=\"full\" data-count=\"default\"></div>\r\n</div>\r\n<div class=\"adr\"><img src=\"img/social/email.png\" class=\"social-icon\" /><a href=\"mailto:andrzuk@tlen.pl\" class=\"social-link\">andrzuk@tlen.pl</a></div>\r\n<div class=\"adr\"><img src=\"img/social/twitter.png\" class=\"social-icon\" /><a href=\"https://twitter.com/andy_zukowski\" class=\"social-link\" target=\"_blank\">@andy_zukowski</a></div>\r\n<div class=\"adr\"><img src=\"img/social/facebook.png\" class=\"social-icon\" /><a href=\"https://www.facebook.com/zukowski.andrzej\" class=\"social-link\" target=\"_blank\">/zukowski.andrzej</a></div>\r\n<div class=\"map\">\r\n<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4868.189906184837!2d16.90535455942152!3d52.40495529413141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9eeed0bd55c0f364!2sMi%C4%99dzynarodowe+Targi+Pozna%C5%84skie!5e0!3m2!1spl!2spl!4v1494942598996\" width=\"100%\" height=\"375\" frameborder=\"0\" style=\"border: #aaa 1px solid;\"></iframe>\r\n</div>\r\n<div class=\"note\">*) Obiekt zaznaczony na mapie stanowi tylko przykład lokalizacji. Nie należy się nią sugerować.</div>\r\n</div>\r\n<div class=\"col-md-6 contact-form\">', 'Kontakt z serwisem', 1, 1, :save_time, 0),
				(3, 0, 0, 0, 'O systemie', '<h3>Co to takiego?</h3>\r\n<p>Jest to system przeznaczony do zarządzania stroną internetową z poziomu przeglądarki internetowej.</p>\r\n\r\n<h3>Skąd nazwa FineCMS?</h3>\r\n<p>Ponieważ jest to prosty, szybki, przyjazny dla użytkownika, a więc \"fajny\" CMS, oparty na autorskim frameworku w architekturze MVC (Model - View - Controller), w której zadania operacji na danych (model), przygotowania i prezentacji stron (widok) oraz sterowanie przepływem i logika aplikacji (kontroler) są od siebie odseparowane. Dzięki takiej budowie ułatwione jest utrzymanie i rozwój aplikacji. Dołączanie kolejnych funkcjonalności jest dziecinnie proste i polega na dodaniu trzech klas - po jednej na każdą warstwę - oraz oczywiście wypełnieniu ich właściwym do zaplanowanych zadań kodem.</p>\r\n\r\n<h3>Czym się wyróżnia?</h3>\r\n<p>System, który Państwo oglądają, służy do szybkiego stawiania stron www, ich łatwej rozbudowy i aktualizacji. Nasz CMS wyróżnia się wyjątkową prostotą i szybkością działania. Obsługa jest łatwa, intuicyjna i przyjemna. Podobnie jak w przypadku innych produktów tej klasy, możliwości naszego systemu obejmują takie funkcje, jak tworzenie dowolnej ilości podstron, dynamiczne zarządzanie nawigacją strony (główne linki strony), budowanie własnej galerii zdjęć, system zarządzania kontami użytkowników oraz ich prawami dostępu do zasobów serwisu, czy wreszcie formularz kontaktowy wraz z systemem zarządzania nadesłanymi wiadomościami, wyszukiwarka artykułów, a nawet system raportowania różnych aspektów działania strony, np. śledzenie odwiedzin.</p>\r\n\r\n<h3>Dlaczego warto zdecydować się na FineCMS?</h3>\r\n<p>Wybór systemu FineCMS jako platformy dla swojej strony internetowej jest doskonałym posunięciem. Użytkownicy, którzy stale rozbudowują lub aktualizują własne strony, z pewnością już od pierwszego momentu odczują satysfakcję i komfort pracy z systemem. Jego prostota i minimalizm interfejsu stanowią ogromną zaletę, ponieważ nie ma tu niepotrzebnych, nigdy nie używanych funkcji, zaś nauka obsługi trwa praktycznie parę minut.</p>', 'System FineCMS jest to system przeznaczony do zarządzania stroną internetową z poziomu przeglądarki internetowej.', 1, 1, :save_time, 0),
				(4, 0, 0, 0, 'Regulamin', 'Regulamin serwisu', 'Regulamin', 1, 1, :save_time, 0),
				(5, 0, 0, 0, 'Polityka prywatności', 'Polityka prywatności', 'Polityka prywatności', 1, 1, :save_time, 0);
			",
		),
	),
	array(
		'create_constraints' => array(
			'
				ALTER TABLE `images`
				  ADD CONSTRAINT `fk_images_users` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
			'
				ALTER TABLE `categories`
				  ADD CONSTRAINT `fk_categories_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
			'
				ALTER TABLE `pages`
				  ADD CONSTRAINT `fk_pages_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
			'
				ALTER TABLE `notes`
				  ADD CONSTRAINT `fk_notes_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
			'
				ALTER TABLE `user_roles`
				  ADD CONSTRAINT `fk_roles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `fk_roles_functions` FOREIGN KEY (`function_id`) REFERENCES `admin_functions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
			'
				ALTER TABLE `archives`
				  ADD CONSTRAINT `fk_archives_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `fk_archives_pages` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
			'
				ALTER TABLE `comments`
				  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				  ADD CONSTRAINT `fk_comments_pages` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			',
		),
	),
);

?>
