<?php

class Images_Controller extends Controller
{
	public function __construct($app)
	{
		parent::__construct($app);
		
		$this->app->get_page()->set_path(array(
			'index.php' => 'Strona główna',
			'index.php?route=admin' => 'Admin Panel',
			'index.php?route='.MODULE_NAME => 'Galeria',
		));	
		
		$columns = array(
			array('db_name' => 'id',             'column_name' => 'Id',          'sorting' => 1),
			array('db_name' => 'preview',        'column_name' => 'Podgląd',     'sorting' => 0),
			array('db_name' => 'file_format',    'column_name' => 'Format',      'sorting' => 1),
			array('db_name' => 'file_name',      'column_name' => 'Nazwa',       'sorting' => 1),
			array('db_name' => 'file_size',      'column_name' => 'Rozmiar',     'sorting' => 1),
			array('db_name' => 'picture_width',  'column_name' => 'Szerokość',   'sorting' => 1),
			array('db_name' => 'picture_height', 'column_name' => 'Wysokość',    'sorting' => 1),
			array('db_name' => 'user_login',     'column_name' => 'Autor',       'sorting' => 1),
			array('db_name' => 'modified',       'column_name' => 'Modyfikacja', 'sorting' => 1),
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

			$options = array(
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=add',
					'caption' => 'Nowe obrazki',
					'icon' => 'fas fa-plus-circle',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=gallery',
					'caption' => 'Podgląd galerii',
					'icon' => 'fas fa-images',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=load',
					'caption' => 'Przegląd obrazków',
					'icon' => 'fas fa-camera',
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

	public function Add_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Add_Action();

			if (!empty($_POST))
			{
				$file_objects = array();

				foreach ($_FILES as $key => $value)
				{
					foreach ($value as $k => $v)
					{
						foreach ($v as $i => $j)
						{
							$file_objects[$i][$k] = $j;
						}
					}
				}

				$records = array(
					'owner_id' => $this->app->get_user()->get_value('user_id'),
					'modified' => date("Y-m-d H:i:s"),
					'files' => $file_objects,
				);

				if (isset($_POST['upload_button']))
				{
					$id = $this->app->get_model_object()->Add($records);

					if ($id) $this->app->get_page()->set_message(MSG_INFORMATION, 'Obrazki zostały pomyślnie dodane do galerii.');
					else $this->app->get_page()->set_message(MSG_ERROR, 'Obrazki nie zostały dodane do galerii.');

					header('Location: index.php?route='.MODULE_NAME);
					exit;
				}
				else // button Anuluj
				{
					header('Location: index.php?route='.MODULE_NAME);
					exit;
				}
			}
			else // pusty formularz
			{
				$options = array(
					array(
						'link' => 'index.php?route='.MODULE_NAME,
						'caption' => 'Zamknij',
						'icon' => 'fas fa-times-circle',
					),
				);

				$data = NULL;

				$this->app->get_page()->set_options($options);

				$this->app->get_page()->set_content($this->app->get_view_object()->ShowForm($data));
			}			
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Edit_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Edit_Action();

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			if (!empty($_POST))
			{
				$file_object = array();

				foreach ($_FILES as $key => $value)
				{
					foreach ($value as $k => $v)
					{
						foreach ($v as $i => $j)
						{
							$file_object[$i][$k] = $j;
						}
					}
				}

				$file_name = $_POST['file_name'];

				$record = array(
					'new_name' => $file_name,
					'owner_id' => $this->app->get_user()->get_value('user_id'),
					'modified' => date("Y-m-d H:i:s"),
					'files' => $file_object,
				);

				if (isset($_POST['save_button']))
				{
					$result = $this->app->get_model_object()->Save($id, $record);

					if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Zmiany zostały pomyślnie zapisane.');
					else $this->app->get_page()->set_message(MSG_ERROR, 'Zmiany nie zostały zapisane.');

					header('Location: index.php?route='.MODULE_NAME.'&action=edit&id='.$id.'&check=true');
					exit;
				}
				else if (isset($_POST['update_button']))
				{
					$result = $this->app->get_model_object()->Save($id, $record);

					if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Zmiany zostały pomyślnie zapisane.');
					else $this->app->get_page()->set_message(MSG_ERROR, 'Zmiany nie zostały zapisane.');

					header('Location: index.php?route='.MODULE_NAME);
					exit;
				}
				else // button Anuluj
				{
					header('Location: index.php?route='.MODULE_NAME);
					exit;
				}
			}
			else // wczytany formularz
			{
				$options = array(
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=preview&id='.$id,
						'caption' => 'Podgląd obrazka',
						'icon' => 'fas fa-camera',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=view&id='.$id,
						'caption' => 'Szczegóły obrazka',
						'icon' => 'fas fa-info-circle',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=download&id='.$id,
						'caption' => 'Pobierz obrazek',
						'icon' => 'fas fa-cloud-download-alt',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=delete&id='.$id,
						'caption' => 'Usuń obrazek',
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

				$this->app->get_page()->set_content($this->app->get_view_object()->ShowForm($data));
			}
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

				if ($result) $this->app->get_page()->set_message(MSG_INFORMATION, 'Obrazek został pomyślnie usunięty z galerii.');
				else $this->app->get_page()->set_message(MSG_ERROR, 'Obrazek nie został usunięty z galerii.');

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
						'link' => 'index.php?route='.MODULE_NAME.'&action=preview&id='.$id,
						'caption' => 'Podgląd obrazka',
						'icon' => 'fas fa-camera',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=edit&id='.$id,
						'caption' => 'Edytuj obrazek',
						'icon' => 'fas fa-edit',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=download&id='.$id,
						'caption' => 'Pobierz obrazek',
						'icon' => 'fas fa-cloud-download-alt',
					),
					array(
						'link' => 'index.php?route='.MODULE_NAME.'&action=delete&id='.$id,
						'caption' => 'Usuń obrazek',
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

	public function Preview_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			$options = array(
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=view&id='.$id,
					'caption' => 'Szczegóły obrazka',
					'icon' => 'fas fa-info-circle',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=edit&id='.$id,
					'caption' => 'Edytuj obrazek',
					'icon' => 'fas fa-edit',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=download&id='.$id,
					'caption' => 'Pobierz obrazek',
					'icon' => 'fas fa-cloud-download-alt',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=delete&id='.$id,
					'caption' => 'Usuń obrazek',
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

			$this->app->get_page()->set_content($this->app->get_view_object()->ShowPicture($data));
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Load_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			$options = array(
				array(
					'link' => 'index.php?route='.MODULE_NAME,
					'caption' => 'Zarządzanie galerią',
					'icon' => 'fas fa-file-image',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=gallery',
					'caption' => 'Podgląd galerii',
					'icon' => 'fas fa-images',
				),
				array(
					'link' => 'index.php?route=admin',
					'caption' => 'Zamknij',
					'icon' => 'fas fa-times-circle',
				),
			);

			$import = $this->app->get_model_object()->GetImages();

			$this->app->get_page()->set_options($options);

			$this->app->get_page()->set_content($this->app->get_view_object()->ShowLoaded($import));
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Download_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			$result = $this->app->get_model_object()->Download($id);
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function Gallery_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Index_Action();

			$last_url = isset($_SESSION['last_url']) ? $_SESSION['last_url'] : NULL;

			$options = array(
				array(
					'link' => $last_url,
					'caption' => 'Wróć do edycji',
					'icon' => 'fas fa-edit',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME,
					'caption' => 'Zarządzanie galerią',
					'icon' => 'fas fa-file-image',
				),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&action=load',
					'caption' => 'Przegląd obrazków',
					'icon' => 'fas fa-camera',
				),
				array(
					'link' => 'index.php?route=admin',
					'caption' => 'Zamknij',
					'icon' => 'fas fa-times-circle',
				),
			);

			if (!$last_url) unset($options[0]);

			$data = $this->app->get_model_object()->GetAll();

			parent::Update_Paginator();

			$this->app->get_page()->set_options($options);

			$this->app->get_page()->set_content($this->app->get_view_object()->ShowTiles($data, $last_url));
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}
}

?>
