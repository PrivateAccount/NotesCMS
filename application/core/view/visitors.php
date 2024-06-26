<?php

class Visitors_View extends View
{
	public function __construct($page)
	{
		parent::__construct($page);
	}

	public function ShowList($columns, $data)
	{
		$title = 'Odwiedziny serwisu';
		$image = 'fas fa-globe-americas';

		$attribs = array(
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
			array('width' => '20%', 'align' => 'left',   'visible' => '1', 'array' => '1'),
			array('width' => '20%', 'align' => 'left',   'visible' => '1'),
			array('width' => '30%', 'align' => 'left',   'visible' => '1'),
			array('width' => '10%',  'align' => 'center', 'visible' => '1'),
			array('width' => '10%', 'align' => 'center', 'visible' => '1'),
		);
		
		$actions = array(
			array('action' => 'view',    'icon' => 'fas fa-info-circle',  'title' => 'Podgląd'),
			array('action' => 'exclude', 'icon' => 'fas fa-times-circle', 'title' => 'Wyklucz'),
		);
	
		include GENER_DIR . 'list.php';

		$list_object = new ListBuilder();

		$list_object->init($title, $image, $columns, $data, $this->get_list_params(), $attribs, $actions);

		$list_object->show_dates(TRUE);

		$result = $list_object->build_list();

		return $result;
	}

	public function ShowDetails($data)
	{
		include GENER_DIR . 'view.php';

		$view_object = new ViewBuilder();

		$view_title = 'Szczegóły odwiedzin';
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
