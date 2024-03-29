<?php

class Pages_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowList($columns, $data)
	{
		$title = 'Strony serwisu';
		$image = 'far fa-file-word';

		$attribs = array(
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '5%',  'align' => 'center', 'visible' => '0'),
			array('width' => '5%',  'align' => 'center', 'visible' => '0'),
			array('width' => '10%', 'align' => 'left',   'visible' => '1'),
			array('width' => '15%', 'align' => 'left',   'visible' => '1'),
			array('width' => '25%', 'align' => 'left',   'visible' => '0'),
			array('width' => '25%', 'align' => 'left',   'visible' => '1'),
			array('width' => '5%',  'align' => 'right',  'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '0'),
			array('width' => '5%',  'align' => 'center', 'visible' => '1'),
			array('width' => '15%', 'align' => 'center', 'visible' => '1'),
		);
		
		$actions = array(
			array('action' => 'view',    'icon' => 'fas fa-info-circle',    'title' => 'Podgląd'),
			array('action' => 'edit',    'icon' => 'fas fa-edit',           'title' => 'Edytuj'),
			array('action' => 'archive', 'icon' => 'fas fa-file-archive',   'title' => 'Archiwizuj'),
			array('action' => 'restore', 'icon' => 'fas fa-window-restore', 'title' => 'Przywróć'),
			array('action' => 'delete',  'icon' => 'fas fa-trash-alt',      'title' => 'Usuń'),
		);
	
		include GENER_DIR . 'list.php';

		$list_object = new ListBuilder();

		$list_object->init($title, $image, $columns, $data, $this->get_list_params(), $attribs, $actions);

		$result = $list_object->build_list();

		return $result;
	}

	public function ShowForm($data, $import, $image)
	{
		if ($data) // edycja
		{
			foreach ($data as $key => $value) 
			{
				if ($key == 'id') $main_id = $value;
				if ($key == 'main_page') $main_main_page = $value;
				if ($key == 'system_page') $main_system_page = $value;
				if ($key == 'category_id') $main_category_id = $value;
				if ($key == 'title') $main_title = $value;
				if ($key == 'contents') $main_contents = $value;
				if ($key == 'description') $main_description = $value;
				if ($key == 'visible') $main_visible = $value;
				if ($key == 'modified') $main_modified = $value;
			}
		}
		else // nowa pozycja
		{
			$main_id = NULL;
			$main_main_page = NULL;
			$main_system_page = NULL;
			$main_category_id = NULL;
			$main_title = NULL;
			$main_contents = NULL;
			$main_description = NULL;
			$main_visible = 1;
			$main_modified = NULL;
		}

		$chk = array(NULL, NULL);
		$chk[$main_visible] = 'checked';

		$sel = array();
		$categories = array();

		foreach ($import as $k => $v) 
		{
			foreach ($v as $key => $value)
			{
				if ($key == 'id') $category_id = $value;
				if ($key == 'caption') $caption = $value;
			}
			$sel[$category_id] = $category_id == $main_category_id ? 'selected' : NULL;
			$categories[] = array(
				'value' => $category_id, 'caption' => $caption, $sel[$category_id] => $sel[$category_id],
			);
		}

		$main_contents = $image ? $main_contents . '<img src="'. GALLERY_DIR . IMG_DIR . $image .'" class="Image" />' : $main_contents;

		include GENER_DIR . 'form.php';

		$form_object = new FormBuilder();

		$form_title = $data ? 'Edycja strony' : 'Nowa strona';
		$form_image = 'far fa-edit';
		$form_width = '700px';
		
		$form_object->init($form_title, $form_image, $form_width);

		$action = $data ? 'edit&id=' . $main_id : 'add';

		$form_action = 'index.php?route=' . MODULE_NAME . '&action=' . $action;

		$form_object->set_action($form_action);

		$form_inputs = array(
			array(
				'caption' => 'Tytuł', 
				'data' => array(
					'type' => 'text', 'id' => 'title', 'name' => 'title', 'value' => $main_title, 'required' => 'required', 'class' => 'focused',
				),
			),
			array(
				'caption' => 'Kategoria', 
				'data' => array(
					'type' => 'select', 'id' => 'category_id', 'name' => 'category_id', 
					'option' => $categories, 
				),
			),
			array(
				'caption' => 'Opis', 
				'data' => array(
					'type' => 'textarea', 'id' => 'description', 'name' => 'description', 'rows' => 2, 'value' => $main_description, 'required' => 'required',
				),
			),
			array(
				'caption' => 'Treść', 
				'data' => array(
					'type' => 'textarea', 'id' => 'contents', 'name' => 'contents', 'rows' => 20, 'value' => $main_contents, 'required' => 'required',
				),
			),
			array(
				'caption' => NULL, 
				'data' => array(
					'type' => 'radio', 'name' => 'visible', 
					'items' => array(
						array(
							'id' => 'active_yes', 'label' => 'Aktywna', $chk[1] => $chk[1], 'value' => 1,
						),
						array(
							'id' => 'active_no', 'label' => 'Nieaktywna', $chk[0] => $chk[0], 'value' => 0,
						),
					),
				),
			),
		);

		$form_object->set_inputs($form_inputs);
		
		$form_hiddens = array(
			array(
				'type' => 'hidden', 'id' => 'main_page', 'name' => 'main_page', 'value' => $main_main_page,
			),
			array(
				'type' => 'hidden', 'id' => 'system_page', 'name' => 'system_page', 'value' => $main_system_page,
			),
		);
			
		$form_object->set_hiddens($form_hiddens);

		$form_buttons = array(
			array(
				'type' => 'save', 'id' => 'save_button', 'name' => 'save_button', 'value' => 'Zapisz',
			),
			array(
				'type' => 'close', 'id' => 'update_button', 'name' => 'update_button', 'value' => 'Zamknij',
			),
			array(
				'type' => 'cancel', 'id' => 'cancel_button', 'name' => 'cancel_button', 'value' => 'Anuluj',
			),
		);
		
		$form_object->set_buttons($form_buttons);

		$result = $form_object->build_form();

		return $result;
	}

	public function ShowDetails($data)
	{
		include GENER_DIR . 'view.php';

		$view_object = new ViewBuilder();

		$view_title = 'Szczegóły strony';
		$view_image = 'fas fa-info-circle';
		$view_width = '500px';
		
		$view_object->init($view_title, $view_image, $view_width);

		$view_action = 'index.php?route=' . MODULE_NAME;

		$view_object->set_action($view_action);

		$view_inputs = array();

		if (is_array($data))
		{
			foreach ($data as $key => $value) 
			{
				if (in_array($key, array('main_page', 'system_page', 'category_id', 'author_id', 'previews'))) continue;
				if ($key == 'contents') $value = str_replace(chr(13).chr(10), '<br>', strip_tags($value));
				if ($key == 'visible') $value = $value ? '<span style="color: green;">Tak</span>' : '<span style="color: red;">Nie</span>';
				$view_inputs[] = array('caption' => $key, 'value' => $value);
			}
		}

		$view_object->set_inputs($view_inputs);
		
		$view_buttons = array(
			array(
				'type' => 'cancel', 'id' => 'cancel_button', 'name' => 'cancel_button', 'value' => 'Zamknij',
			),
		);
		
		$view_object->set_buttons($view_buttons);

		$result = $view_object->build_view();

		return $result;
	}

	public function ShowArchives($id, $title, $data)
	{
		include GENER_DIR . 'form.php';

		$form_object = new FormBuilder();

		$form_title = 'Archiwa strony';
		$form_image = 'far fa-folder-open';
		$form_width = '500px';
		
		$form_object->init($form_title, $form_image, $form_width);

		$form_action = 'index.php?route=' . MODULE_NAME . '&action=restore&id='.$id;

		$form_object->set_action($form_action);

		$form_items = array();

		if (is_array($data))
		{
			foreach ($data as $k => $v) 
			{
				foreach ($v as $key => $value) 
				{
					if ($key == 'id') $id = $value;
					if ($key == 'modified') $modified = $value;
				}
				$form_items[] = array('id' => $id, 'label' => $modified, 'value' => $id, 'button' => ' &nbsp; <a href="index.php?route=pages&action=preview&id='.$id.'" class="btn btn-success btn-xs">Podgląd</a>');
			}
		}

		$form_inputs = array(
			array(
				'caption' => 'Strona', 
				'data' => array(
					'type' => 'label', 'value' => $title,
				),
			),
			array(
				'caption' => 'Wersje', 
				'data' => array(
					'type' => 'label', 'value' => NULL,
				),
			),
			array(
				'caption' => NULL, 
				'data' => array(
					'type' => 'radio', 'name' => 'archives', 
					'items' => $form_items,
				),
			),
		);

		$form_object->set_inputs($form_inputs);
		
		$form_hiddens = array(
			array(
				'type' => 'hidden', 'id' => 'master_page_id', 'name' => 'master_page_id', 'value' => NULL,
			),
		);
			
		$form_object->set_hiddens($form_hiddens);

		$form_buttons = array(
			array(
				'type' => 'submit', 'id' => 'restore_button', 'name' => 'restore_button', 'value' => 'Przywróć',
			),
			array(
				'type' => 'cancel', 'id' => 'cancel_button', 'name' => 'cancel_button', 'value' => 'Anuluj',
			),
		);
		
		$form_object->set_buttons($form_buttons);

		$result = $form_object->build_form();

		return $result;
	}
	
	public function ShowPage($data)
	{
		$result = NULL;

		if (is_array($data))
		{
			foreach ($data as $key => $value)
			{
				if ($key == 'title') $title = $value;
				if ($key == 'contents') $contents = $value;
				if ($key == 'user_login') $user_login = $value;
				if ($key == 'modified') $modified = $value;
				if ($key == 'previews') $previews = $value;
				if ($key == 'skip_bar') $skip_bar = $value;
				if ($key == 'skip_bar_visible') $skip_bar_visible = $value;
				if ($key == 'social_buttons') $social_buttons = $value;
				if ($key == 'social_buttons_visible') $social_buttons_visible = $value;
			}

			$social_buttons = str_replace(array('{{_url_}}', '{{_title_}}'), array($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], $title), $social_buttons);

			$result .= '<div class="article">';
			$result .= '<div class="article-title">';
			$result .= '<h3>' . $title . '</h3>';
			$result .= '</div>';
			$result .= '<div class="article-timestamp">';
			$result .= '<img src="img/16x16/user.png" />' . $user_login;
			$result .= '<img src="img/16x16/date.png" />' . $modified;
			$result .= '<img src="img/16x16/web.png" />' . $previews;
			if ($social_buttons_visible)
				$result .= $social_buttons;
			$result .= '</div>';
			$result .= '<div class="article-content">';
			if (is_array($contents))
			{
				$result .= '<ul>';
				foreach ($contents as $element)
				{
					foreach ($element as $key => $value)
					{
						if ($key == 'caption') $caption = $value;
						if ($key == 'link') $link = $value;
					}
					$result .= '<li>'.'<a href="'.$link.'">'.$caption.'</a>'.'</li>';
				}
				$result .= '</ul>';
			}
			else
			{
				$result .= $contents;
			}
			$result .= '</div>';
			$result .= '</div>';
		}

		return $result;
	}
}

?>
