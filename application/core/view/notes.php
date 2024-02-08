<?php

class Notes_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowList($columns, $data)
	{
		$title = 'Notatki użytkownika';
		$image = 'fas fa-file-alt';

		$attribs = array(
			array('width' => '5%',  'align' => 'center', 'visible' => '1'),
			array('width' => '20%', 'align' => 'left',   'visible' => '1'),
			array('width' => '45%', 'align' => 'left',   'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '5%',  'align' => 'center', 'visible' => '1'),
			array('width' => '15%', 'align' => 'center', 'visible' => '1'),
		);
		
		$actions = array(
			array('action' => 'view',   'icon' => 'fas fa-info-circle', 'title' => 'Podgląd'),
			array('action' => 'edit',   'icon' => 'fas fa-edit',        'title' => 'Edytuj'),
			array('action' => 'delete', 'icon' => 'fas fa-trash-alt',   'title' => 'Usuń'),
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
				if ($key == 'title') $main_title = $value;
				if ($key == 'contents') $main_contents = $value;
				if ($key == 'modified') $main_modified = $value;
			}
		}
		else // nowa pozycja
		{
			$main_id = NULL;
			$main_title = NULL;
			$main_contents = NULL;
			$main_modified = NULL;
		}

		include GENER_DIR . 'form.php';

		$form_object = new FormBuilder();

		$form_title = $data ? 'Edycja notatki' : 'Nowa notatka';
		$form_image = 'far fa-edit';
		$form_width = '500px';
		
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
				'caption' => 'Treść', 
				'data' => array(
					'type' => 'textarea', 'id' => 'contents', 'name' => 'contents', 'rows' => 20, 'value' => $main_contents, 'required' => 'required',
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

		$view_title = 'Szczegóły notatki';
		$view_image = 'fas fa-info-circle';
		$view_width = '500px';
		
		$view_object->init($view_title, $view_image, $view_width);

		$view_id = 'details-form';

		$view_object->set_id($view_id);

		$view_action = 'index.php?route=' . MODULE_NAME;

		$view_object->set_action($view_action);

		$view_inputs = array();

		if (is_array($data))
		{
			foreach ($data as $key => $value) 
			{
				if (in_array($key, array('author_id'))) continue;
				if ($key == 'contents') $value = str_replace(chr(13).chr(10), '<br>', strip_tags($value));
				$view_inputs[] = array('caption' => $key, 'value' => $value);
			}
		}

		$view_object->set_inputs($view_inputs);
		
		$view_buttons = array(
			array(
				'type' => 'skip', 'id' => 'prev_button', 'name' => 'prev_button', 'value' => '<i class=\'fas fa-backward\'></i>', 'onclick' => '$(\'form#'.$view_id.'\').attr(\'action\', \''.$view_action.'&action=view&direction=prev&id='.$data['id'].'\');',
			),
			array(
				'type' => 'cancel', 'id' => 'cancel_button', 'name' => 'cancel_button', 'value' => 'Zamknij',
			),
			array(
				'type' => 'skip', 'id' => 'next_button', 'name' => 'next_button', 'value' => '<i class=\'fas fa-forward\'></i>', 'onclick' => '$(\'form#'.$view_id.'\').attr(\'action\', \''.$view_action.'&action=view&direction=next&id='.$data['id'].'\');',
			),
		);
		
		$view_object->set_buttons($view_buttons);

		$result = $view_object->build_view();

		return $result;
	}
}

?>
