<?php

class Excludes_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowList($columns, $data)
	{
		$title = 'Wykluczenia adresów';
		$image = 'fas fa-user-slash';

		$attribs = array(
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '30%', 'align' => 'left',   'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '0'),
			array('width' => '40%', 'align' => 'left',   'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
		);
	
		$actions = array(
			array('action' => 'activate', 'icon' => 'fas fa-check-circle', 'title' => 'Aktywuj'),
			array('action' => 'delete',   'icon' => 'fas fa-trash-alt',    'title' => 'Usuń'),
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
				if ($key == 'visitor_ip') $main_ip = $value;
			}
		}
		else // nowa pozycja
		{
			$main_id = NULL;
			$main_ip = NULL;
		}

		include GENER_DIR . 'form.php';

		$form_object = new FormBuilder();

		$form_title = $data ? 'Edycja adresu wykluczenia' : 'Nowy adres wykluczenia';
		$form_image = 'far fa-edit';
		$form_width = '500px';
		
		$form_object->init($form_title, $form_image, $form_width);

		$action = $data ? 'edit&id=' . $main_id : 'add';

		$form_action = 'index.php?route=' . MODULE_NAME . '&action=' . $action;

		$form_object->set_action($form_action);

		$form_inputs = array(
			array(
				'caption' => 'Adres IP', 
				'data' => array(
					'type' => 'text', 'id' => 'visitor_ip', 'name' => 'visitor_ip', 'value' => $main_ip, 'required' => 'required', 'class' => 'focused',
				),
			),
		);

		$form_object->set_inputs($form_inputs);
		
		$form_hiddens = array();
			
		$form_object->set_hiddens($form_hiddens);

		$form_buttons = array(
			array(
				'type' => 'submit', 'id' => 'save_button', 'name' => 'save_button', 'value' => 'Zapisz',
			),
			array(
				'type' => 'cancel', 'id' => 'cancel_button', 'name' => 'cancel_button', 'value' => 'Anuluj',
			),
		);
		
		$form_object->set_buttons($form_buttons);

		$result = $form_object->build_form();

		return $result;
	}
}

?>
