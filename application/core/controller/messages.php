<?php

class Messages_Controller extends Controller
{
	public function __construct($app)
	{
		parent::__construct($app);
		
		$this->app->get_page()->set_path(array(
			'index.php' => 'Strona główna',
			'index.php?route=admin' => 'Admin Panel',
			'index.php?route='.MODULE_NAME => 'Wiadomości',
		));	
		
		$columns = array(
			array('db_name' => 'id',              'column_name' => 'Id',               'sorting' => 1),
			array('db_name' => 'client_ip',       'column_name' => 'Adres IP',         'sorting' => 1),
			array('db_name' => 'client_name',     'column_name' => 'Imię',             'sorting' => 1),
			array('db_name' => 'client_email',    'column_name' => 'Adres e-mail',     'sorting' => 1),
			array('db_name' => 'message_content', 'column_name' => 'Treść wiadomości', 'sorting' => 1),
			array('db_name' => 'requested',       'column_name' => 'Wysłana',          'sorting' => 1),
			array('db_name' => 'send_date',       'column_name' => 'Wysłano',          'sorting' => 1),
			array('db_name' => 'close_date',      'column_name' => 'Przyjęto',         'sorting' => 1),
		);

		parent::init($columns);

		$layout = $this->app->get_settings()->get_config_key('page_template_admin');

		$this->app->get_page()->set_layout($layout);
	}

	public function Index_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Index_Action();

			if (isset($_GET['mode'])) $_SESSION['messages_list_mode'] = $_GET['mode'];

			$options = array(
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&mode=1',
					'caption' => 'Wiadomości nadesłane',
					'icon' => 'fas fa-edit',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&mode=2',
					'caption' => 'Wiadomości zatwierdzone',
					'icon' => 'fas fa-check-circle',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=clear',
					'caption' => 'Wyczyść wiadomości',
					'icon' => 'fas fa-trash-alt',
				),
				array(
					'link' => 'index.php?route=admin',
					'caption' => 'Zamknij',
					'icon' => 'fas fa-times-circle',
				),
			);

			$data = $this->app->get_model_object()->GetAll();

			parent::Update_Paginator();

			$this->app->get_page()->set_options($options);

			$this->app->get_page()->set_content($this->app->get_view_object()->ShowList($this->columns, $data));
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Confirm_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			$record = array(
				'requested' => 2,
				'close_date' => date("Y-m-d H:i:s"),
			);

			$result = $this->app->get_model_object()->Save($id, $record);

			if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Status wiadomości został pomyślnie zapisany.');
			else $this->app->get_page()->set_message(MSG_ERROR, 'Status wiadomości nie został zapisany.');

			header('Location: index.php?route='.MODULE_NAME);
			exit;
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Delete_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Delete_Action();

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			if (isset($_GET['confirm']))
			{
				$result = $this->app->get_model_object()->Delete($id);

				if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Wiadomość została pomyślnie usunięta.');
				else $this->app->get_page()->set_message(MSG_ERROR, 'Wiadomość nie została usunięta.');

				header('Location: index.php?route='.MODULE_NAME);
				exit;
			}
			else
			{
				parent::ConfirmDelete($id);
			}
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Clear_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Clear_Action();

			if (isset($_GET['confirm']))
			{
				$result = $this->app->get_model_object()->Clear();

				if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Wiadomości zostały pomyślnie usunięte.');
				else $this->app->get_page()->set_message(MSG_ERROR, 'Wiadomości nie zostały usunięte.');

				header('Location: index.php?route='.MODULE_NAME);
				exit;
			}
			else
			{
				parent::ConfirmClear();
			}
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function View_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::View_Action();

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			if (isset($_POST['cancel_button']))
			{
				header('Location: index.php?route='.MODULE_NAME);
				exit;
			}
			else // wczytany formularz
			{
				$options = array(
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=confirm&id='.$id,
						'caption' => 'Zatwierdź wiadomość',
						'icon' => 'fas fa-check-circle',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=delete&id='.$id,
						'caption' => 'Usuń wiadomość',
						'icon' => 'fas fa-trash-alt',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME,
						'caption' => 'Zamknij',
						'icon' => 'fas fa-times-circle',
					),
				);

				$data = $this->app->get_model_object()->GetOne($id);

				$this->app->get_page()->set_options($options);

				$this->app->get_page()->set_content($this->app->get_view_object()->ShowDetails($data));
			}
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}
	
	public function Exclude_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Exclude_Action();

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			$data = $this->app->get_model_object()->GetOne($id);
			
			$result = $this->app->get_model_object()->Exclude($data);

			if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Adres został pomyślnie dopisany do czarnej listy.');
			else $this->app->get_page()->set_message(MSG_ERROR, 'Adres nie został dopisany do czarnej listy.');

			header('Location: index.php?route='.MODULE_NAME);
			exit;
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}
}

?>
