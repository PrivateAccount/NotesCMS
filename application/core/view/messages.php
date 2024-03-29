<?php

class Messages_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowList($columns, $data)
	{
		$title = 'Wiadomości użytkowników';
		$image = 'fas fa-comment-dots';

		$attribs = array(
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '15%', 'align' => 'left',   'visible' => '1'),
			array('width' => '15%', 'align' => 'left',   'visible' => '1'),
			array('width' => '20%', 'align' => 'left',   'visible' => '1'),
			array('width' => '0%',  'align' => 'left',   'visible' => '0', 'custom' => TRUE),
			array('width' => '5%',  'align' => 'center', 'visible' => '0'),
			array('width' => '15%', 'align' => 'center', 'visible' => '1'),
			array('width' => '15%', 'align' => 'center', 'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
		);
		
		$actions = array(
			array('action' => 'view',    'icon' => 'fas fa-info-circle',  'title' => 'Podgląd'),
			array('action' => 'confirm', 'icon' => 'fas fa-check-circle', 'title' => 'Zatwierdź'),
			array('action' => 'delete',  'icon' => 'fas fa-trash-alt',    'title' => 'Usuń'),
			array('action' => 'exclude', 'icon' => 'fas fa-times-circle', 'title' => 'Blokuj'),
		);
	
		include GENER_DIR . 'custom.php';

		$list_object = new CustomBuilder();

		$list_object->init($title, $image, $columns, $data, $this->get_list_params(), $attribs, $actions);

		$result = $list_object->build_list();

		return $result;
	}

	public function ShowDetails($data)
	{
		include GENER_DIR . 'view.php';

		$view_object = new ViewBuilder();

		$view_title = 'Szczegóły wiadomości';
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
				if ($key == 'requested') $value = $value == 1 ? '<span style="color: green;">Waiting</span>' : '<span style="color: red;">Closed</span>';
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
