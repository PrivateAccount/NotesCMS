<?php

class Admin_Controller extends Controller
{
	public function __construct($app)
	{
		parent::__construct($app);
		
		$this->app->get_page()->set_path(array(
			'index.php' => 'Strona główna',
			'index.php?route='.MODULE_NAME => 'Admin Panel',
		));
	}
	
	public function Index_Action()
	{
		if ($this->app->get_acl()->allowed(USER)) // są uprawnienia
		{
			$options = array(
				array(
					'link' => 'index.php?route=logout',
					'caption' => 'Wyloguj',
					'icon' => 'fas fa-sign-out-alt',
				),
				array(
					'link' => 'index.php',
					'caption' => 'Zamknij',
					'icon' => 'fas fa-times-circle',
				),
			);

			$data = array(
				array('group' => 'System', 'elements' => array(
						array(
							'profile' => ADMIN,
							'caption' => 'Konfiguracja ('.$this->app->get_model_object()->GetTableCount('Konfiguracja').')', 
							'link' => 'index.php?route=config', 
							'icon' => '14.png',
						),
						array(
							'profile' => ADMIN,
							'caption' => 'Szablon ('.$this->app->get_model_object()->GetFileLines('Szablon', $this->app->get_page()->get_layout()).')', 
							'link' => 'index.php?route=template', 
							'icon' => '49.png',
						),
						array(
							'profile' => ADMIN,
							'caption' => 'Styl ('.$this->app->get_model_object()->GetFileLines('Styl', $this->app->get_page()->get_layout()).')', 
							'link' => 'index.php?route=style', 
							'icon' => '44.png',
						),
						array(
							'profile' => ADMIN,
							'caption' => 'Skrypt ('.$this->app->get_model_object()->GetFileLines('Skrypt', $this->app->get_page()->get_layout()).')', 
							'link' => 'index.php?route=script', 
							'icon' => '55.png',
						),
						array(
							'profile' => USER,
							'caption' => 'Użytkownicy ('.$this->app->get_model_object()->GetTableCount('Użytkownicy').')', 
							'link' => 'index.php?route=users', 
							'icon' => '07.png',
						),
						array(
							'profile' => ADMIN,
							'caption' => 'Dostęp ('.$this->app->get_model_object()->GetTableCount('Role').')', 
							'link' => 'index.php?route=roles', 
							'icon' => '60.png',
						),
					),
				),
				array('group' => 'Zasoby', 'elements' => array(
						array(
							'profile' => OPERATOR,
							'caption' => 'Kategorie ('.$this->app->get_model_object()->GetTableCount('Kategorie').')', 
							'link' => 'index.php?route=categories', 
							'icon' => '29.png',
						),
						array(
							'profile' => OPERATOR,
							'caption' => 'Strony ('.$this->app->get_model_object()->GetTableCount('Strony').')', 
							'link' => 'index.php?route=pages', 
							'icon' => '61.png',
						),
						array(
							'profile' => OPERATOR,
							'caption' => 'Opisy ('.$this->app->get_model_object()->GetTableCount('Opisy').')', 
							'link' => 'index.php?route=sites', 
							'icon' => '64.png',
						),
						array(
							'profile' => USER,
							'caption' => 'Komentarze ('.$this->app->get_model_object()->GetTableCount('Komentarze').')', 
							'link' => 'index.php?route=comments', 
							'icon' => '63.png',
						),
						array(
							'profile' => USER,
							'caption' => 'Notatki ('.$this->app->get_model_object()->GetTableCount('Notatki').')', 
							'link' => 'index.php?route=notes', 
							'icon' => '01.png',
						),
						array(
							'profile' => OPERATOR,
							'caption' => 'Galeria ('.$this->app->get_model_object()->GetTableCount('Galeria').')', 
							'link' => 'index.php?route=images', 
							'icon' => '22.png',
						),
					),
				),
				array('group' => 'Raporty', 'elements' => array(
						array(
							'profile' => OPERATOR,
							'caption' => 'Wiadomości ('.$this->app->get_model_object()->GetTableCount('Wiadomości').')', 
							'link' => 'index.php?route=messages&mode=1', 
							'icon' => '62.png',
						),
						array(
							'profile' => OPERATOR,
							'caption' => 'Wyszukiwania ('.$this->app->get_model_object()->GetTableCount('Wyszukiwania').')', 
							'link' => 'index.php?route=searches', 
							'icon' => '27.png',
						),
						array(
							'profile' => OPERATOR,
							'caption' => 'Logowania ('.$this->app->get_model_object()->GetTableCount('Logowania').')', 
							'link' => 'index.php?route=logins', 
							'icon' => '26.png',
						),
						array(
							'profile' => ADMIN,
							'caption' => 'Odwiedziny ('.$this->app->get_model_object()->GetTableCount('Odwiedziny').')', 
							'link' => 'index.php?route=visitors', 
							'icon' => '65.png',
						),
					),
				),
			);

			unset($_SESSION['last_url']);
			unset($_SESSION['form_fields']);
			unset($_SESSION['form_failed']);
			unset($_SESSION['sort_field']);
			unset($_SESSION['categories_list_mode']);
			unset($_SESSION['messages_list_mode']);
			unset($_SESSION['logins_list_mode']);
			unset($_SESSION['comments_list_mode']);

			$this->app->get_page()->set_options($options);

			$user = $this->app->get_user();

			$this->app->get_page()->set_content($this->app->get_view_object()->ShowPage($data, $user));

			$layout = $this->app->get_settings()->get_config_key('page_template_admin');

			$this->app->get_page()->set_layout($layout);

			$this->app->get_page()->set_template('admin');
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}
}

?>
