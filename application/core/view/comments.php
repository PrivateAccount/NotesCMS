<?php

class Comments_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowList($columns, $data)
	{
		$title = 'Komentarze użytkowników';
		$image = 'fas fa-comments';

		$attribs = array(
			array('width' => '5%',  'align' => 'center', 'visible' => '1'),
			array('width' => '10%', 'align' => 'left',   'visible' => '1'),
			array('width' => '15%', 'align' => 'left',   'visible' => '1'),
			array('width' => '15%', 'align' => 'left',   'visible' => '1'),
			array('width' => '30%', 'align' => 'left',   'visible' => '1'),
			array('width' => '5%',  'align' => 'center', 'visible' => '0'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
		);
		
		$actions = array(
			array('action' => 'view',    'icon' => 'fas fa-info-circle',  'title' => 'Podgląd'),
			array('action' => 'edit',    'icon' => 'fas fa-edit',         'title' => 'Edytuj'),
			array('action' => 'confirm', 'icon' => 'fas fa-check-circle', 'title' => 'Zatwierdź'),
			array('action' => 'disable', 'icon' => 'fas fa-times-circle', 'title' => 'Zablokuj'),
			array('action' => 'delete',  'icon' => 'fas fa-trash-alt',    'title' => 'Usuń'),
		);
	
		include GENER_DIR . 'list.php';

		$list_object = new ListBuilder();

		$list_object->init($title, $image, $columns, $data, $this->get_list_params(), $attribs, $actions);

		$result = $list_object->build_list();

		return $result;
	}

	public function ShowForm($data)
	{
		if ($data) // edycja
		{
			foreach ($data as $key => $value) 
			{
				if ($key == 'id') $main_id = $value;
				if ($key == 'comment_content') $main_contents = $value;
			}
		}
		else // nowa pozycja
		{
			$main_id = NULL;
			$main_contents = NULL;
		}

		include GENER_DIR . 'form.php';

		$form_object = new FormBuilder();

		$form_title = $data ? 'Edycja komentarza' : 'Nowy komentarz';
		$form_image = 'far fa-edit';
		$form_width = '500px';
		
		$form_object->init($form_title, $form_image, $form_width);

		$action = $data ? 'edit&id=' . $main_id : 'add';

		$form_action = 'index.php?route=' . MODULE_NAME . '&action=' . $action;

		$form_object->set_action($form_action);

		$form_inputs = array(
			array(
				'caption' => 'Id', 
				'data' => array(
					'type' => 'label', 'id' => 'id', 'name' => 'id', 'caption' => 'Id', 'value' => $main_id,
				),
			),
			array(
				'caption' => 'Treść', 
				'data' => array(
					'type' => 'textarea', 'id' => 'comment_content', 'name' => 'comment_content', 'rows' => 15, 'value' => $main_contents, 'required' => 'required', 'class' => 'focused',
				),
			),
		);

		$form_object->set_inputs($form_inputs);
		
		$form_hiddens = array();
			
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

		$view_title = 'Szczegóły komentarza';
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
				if (in_array($key, array('user_id', 'page_id'))) continue;
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
}

?>
