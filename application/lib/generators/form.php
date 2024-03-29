<?php

/*
 * Klasa odpowiedzialna za tworzenie formularzy - Generator Formularzy
 */

include GENER_DIR . 'builder.php';

class FormBuilder extends Builder
{
	private $image;
	private $title;
	private $width;
	private $action;
	private $enctype;
	private $inputs = array();
	private $hiddens = array();
	private $buttons = array();
	
	function __construct()
	{
		parent::__construct();

		if (!isset($_GET['check']))
		{
			unset($_SESSION['form_failed']);
			unset($_SESSION['form_fields']);
		}

		$_SESSION['form_failed'] = isset($_SESSION['form_failed']) ? $_SESSION['form_failed'] : array();
		$_SESSION['form_fields'] = isset($_SESSION['form_fields']) ? $_SESSION['form_fields'] : array();
	}
	
	public function init($form_title, $form_image, $form_width)
	{
		$this->image = $form_image;
		$this->title = $form_title;
		$this->width = $form_width;
	}
	
	public function set_action($form_address)
	{
		$this->action = $form_address;
	}

	public function set_enctype($form_enctype)
	{
		if (!empty($form_enctype))
		{
			$this->enctype = 'enctype="'.$form_enctype.'"';
		}
	}

	public function set_inputs($form_rows)
	{
		$this->inputs = Array();
		
		foreach ($form_rows as $k => $v)
		{
			$this->inputs[] = $v;
		}
	}
	
	public function set_hiddens($form_rows)
	{
		$this->hiddens = Array();
		
		foreach ($form_rows as $k => $v)
		{
			$this->hiddens[] = $v;
		}
	}
	
	public function set_buttons($form_submits)
	{
		$this->buttons = Array();

		foreach ($form_submits as $k => $v) $this->buttons[] = $v;
	}
	
	public function build_form()
	{
		$main_text = NULL;

		$main_text .= '<form id="generator-form" action="'. $this->action .'" method="post" '.$this->enctype.' role="form">';

		$main_text .= '<div class="card card-default left" style="width: '. $this->width .';">';

		$main_text .= '<div class="card-heading">';
		$main_text .= '<h3 class="card-title">';
		$main_text .= '<i class="'.$this->image.'"></i>';
		$main_text .= '&nbsp; '.$this->title;
		$main_text .= '</h3>';
		$main_text .= '</div>';
		
		$main_text .= '<div class="card-body">';

		foreach ($this->inputs as $k => $v)
		{
			$caption = NULL;
				
			foreach ($v as $key => $val)
			{
				if ($key == 'caption')
				{
					$caption = $val;
				}
				if ($key == 'data')
				{
					$type = NULL; $id = NULL; $name = NULL; $value = NULL; $label = NULL; $checked = NULL; $onchange = NULL; $rows = NULL; $required = NULL; $multiple = NULL; $width = NULL; $height = NULL; $action = NULL; $style = NULL; $class = NULL;

					foreach ($val as $i => $j)
					{
						if ($i == 'type') $type = $j;
						if ($i == 'id') $id = $j;
						if ($i == 'name') $name = $j;
						if ($i == 'value') $value = $j;
						if ($i == 'label') $label = $j;
						if ($i == 'checked') $checked = $j;
						if ($i == 'onchange') $onchange = $j;
						if ($i == 'rows') $rows = $j;
						if ($i == 'required') $required = $j;
						if ($i == 'multiple') $multiple = $j;
						if ($i == 'width') $width = $j;
						if ($i == 'height') $height = $j;
						if ($i == 'action') $action = $j;
						if ($i == 'style') $style = $j;
						if ($i == 'class') $class = $j;
						if ($i == 'option')
						{
							$select_options = array();

							foreach ($j as $ii => $jj)
							{
								$opt_value = NULL; $opt_caption = NULL; $opt_selected = NULL;

								foreach ($jj as $iii => $jjj)
								{
									if ($iii == 'value') $opt_value = $jjj;
									if ($iii == 'caption') $opt_caption = $jjj;
									if ($iii == 'selected') $opt_selected = $jjj;
								}
								$select_options[] = array(
									'value' => $opt_value,
									'caption' => $opt_caption,
									'selected' => $opt_selected,
								);
							}
						}
						if ($i == 'items')
						{
							$control_items = array();

							foreach ($j as $ii => $jj)
							{
								$item_id = NULL; $item_name = NULL; $item_label = NULL; $item_value = NULL; $item_checked = NULL; $item_action = NULL; $item_style = NULL; $item_button = NULL;

								foreach ($jj as $iii => $jjj)
								{
									if ($iii == 'id') $item_id = $jjj;
									if ($iii == 'name') $item_name = $jjj;
									if ($iii == 'label') $item_label = $jjj;
									if ($iii == 'value') $item_value = $jjj;
									if ($iii == 'checked') $item_checked = $jjj;
									if ($iii == 'action') $item_action = $jjj;
									if ($iii == 'style') $item_style = $jjj;
									if ($iii == 'button') $item_button = $jjj;
								}
								$control_items[] = array(
									'id' => $item_id,
									'name' => $item_name,
									'label' => $item_label,
									'value' => $item_value,
									'checked' => $item_checked,
									'action' => $item_action,
									'style' => $item_style,
									'button' => $item_button,
								);
							}
						}
					}
				}
			}
			if ($type == 'simple')
			{
				$main_text .= '<div id="'.$id.'" name="'.$name.'" class="form-group" style="'.$style.'">';
				$main_text .= $value;
				$main_text .= '</div>';
			}
			if ($type == 'list')
			{
				if ($caption)
				{
					$main_text .= '<div style="'.$style.'">'.$caption.':</div>';
				}

				$main_text .= '<ul id="'.$id.'" name="'.$name.'" style="'.$style.'">';
				
				foreach ($control_items as $i => $j)
				{
					foreach ($j as $ii => $jj)
					{
						if ($ii == 'value') $item_value = $jj;
						if ($ii == 'style') $item_style = $jj;
					}
					$main_text .= '<li style="'.$item_style.'">'.$item_value.'</li>';
				}
				$main_text .= '</ul>';
			}
			if ($type == 'label')
			{
				$main_text .= '<div class="form-group">';
				$main_text .= '<label class="control-label">'.$caption.':</label>';
				$main_text .= '&nbsp; '.$value;
				$main_text .= '</div>';
			}
			if ($type == 'text')
			{
				$style_name = in_array($name, $_SESSION['form_failed']) ? 'form-group has-error' : 'form-group';
				$value = array_key_exists($name, $_SESSION['form_fields']) ? $_SESSION['form_fields'][$name] : $value;
				$main_text .= '<div class="'.$style_name.'">';
				$main_text .= '<label for="'.$name.'" class="control-label">'.$caption.':</label>';
				$main_text .= '<input type="'.$type.'" class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" '.$required.'>';
				$main_text .= '</div>';
			}
			if ($type == 'email')
			{
				$style_name = in_array($name, $_SESSION['form_failed']) ? 'form-group has-error' : 'form-group';
				$value = array_key_exists($name, $_SESSION['form_fields']) ? $_SESSION['form_fields'][$name] : $value;
				$main_text .= '<div class="'.$style_name.'">';
				$main_text .= '<label for="'.$name.'" class="control-label">'.$caption.':</label>';
				$main_text .= '<input type="'.$type.'" class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" '.$required.'>';
				$main_text .= '</div>';
			}
			if ($type == 'password')
			{
				$style_name = in_array($name, $_SESSION['form_failed']) ? 'form-group has-error' : 'form-group';
				$value = array_key_exists($name, $_SESSION['form_fields']) ? $_SESSION['form_fields'][$name] : $value;
				$main_text .= '<div class="'.$style_name.'">';
				$main_text .= '<label for="'.$name.'" class="control-label">'.$caption.':</label>';
				$main_text .= '<input type="'.$type.'" class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" '.$required.'>';
				$main_text .= '</div>';
			}
			if ($type == 'textarea')
			{
				$style_name = in_array($name, $_SESSION['form_failed']) ? 'form-group has-error' : 'form-group';
				$value = array_key_exists($name, $_SESSION['form_fields']) ? $_SESSION['form_fields'][$name] : $value;
				$main_text .= '<div class="'.$style_name.'">';
				$main_text .= '<label for="'.$name.'" class="control-label">'.$caption.':</label>';
				$main_text .= '<textarea class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" rows="'.$rows.'" '.$required.' autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">'.$value.'</textarea>';
				$main_text .= '</div>';
			}
			if ($type == 'select')
			{
				$main_text .= '<div class="form-group">';
				$main_text .= '<label for="'.$name.'">'.$caption.':</label>';
				$main_text .= '<select class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" onchange="'.$onchange.'">';
				foreach ($select_options as $i => $j)
				{
					foreach ($j as $ii => $jj)
					{
						if ($ii == 'value') $opt_value = $jj;
						if ($ii == 'caption') $opt_caption = $jj;
						if ($ii == 'selected') $opt_selected = $jj;
					}
					$main_text .= '<option value="'.$opt_value.'" '.$opt_selected.'>'.$opt_caption.'</option>';
				}
				$main_text .= '</select>';
				$main_text .= '</div>';
			}
			if ($type == 'checkbox')
			{
				$main_text .= '<div class="checkbox">';
				$main_text .= '<label>';
				$main_text .= '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" '.$checked.'>';
				$main_text .= $label;
				$main_text .= '</label>';
				$main_text .= '</div>';
			}
			if ($type == 'radio')
			{
				if ($caption)
				{
					$main_text .= '<label class="control-label">'.$caption.':</label>';
				}

				foreach ($control_items as $i => $j)
				{
					foreach ($j as $ii => $jj)
					{
						if ($ii == 'id') $item_id = $jj;
						if ($ii == 'label') $item_label = $jj;
						if ($ii == 'value') $item_value = $jj;
						if ($ii == 'checked') $item_checked = $jj;
						if ($ii == 'button') $item_button = $jj;
					}
					$main_text .= '<div class="radio">';
					$main_text .= '<label>';
					$main_text .= '<input type="'.$type.'" id="'.$item_id.'" name="'.$name.'" value="'.$item_value.'" '.$item_checked.'>';
					$main_text .= $item_label . $item_button;
					$main_text .= '</label>';
					$main_text .= '</div>';
				}
			}
			if ($type == 'file')
			{
				$main_text .= '<div class="input-group">';
				$main_text .= '<div class="custom-file">';
				$main_text .= '<input type="'.$type.'" class="custom-file-input" id="'.$id.'" name="'.$name.'" '.$required.' '.$multiple.'>';
				$main_text .= '<label class="custom-file-label" for="'.$id.'">'.$caption.':</label>';
				$main_text .= '</div>';
				$main_text .= '</div>';
			}
			if ($type == 'canvas')
			{
				$main_text .= '<div class="container">';
				$main_text .= '<canvas id="'.$id.'" name="'.$name.'" width="'.$width.'" height="'.$height.'">';
				$main_text .= '</canvas>';
				$main_text .= '</div>';
			}
			if ($type == 'button')
			{
				if ($caption)
				{
					$main_text .= '<label class="control-label">'.$caption.':</label>';
				}
				$main_text .= '<div class="form-group action-bar">';
				
				foreach ($control_items as $i => $j)
				{
					foreach ($j as $ii => $jj)
					{
						if ($ii == 'id') $item_id = $jj;
						if ($ii == 'name') $item_name = $jj;
						if ($ii == 'value') $item_value = $jj;
						if ($ii == 'action') $item_action = $jj;
						if ($ii == 'style') $item_style = $jj;
					}
					$main_text .= '<input type="'.$type.'" id="'.$item_id.'" name="'.$item_name.'" value="'.$item_value.'" onclick="'.$item_action.'" style="'.$item_style.'">';
				}
				$main_text .= '</div>';
			}
		}

		$main_text .= '</div>';

		foreach ($this->hiddens as $k => $v)
		{
			foreach ($v as $i => $j)
			{
				if ($i == 'type') $type = $j;
				if ($i == 'id') $id = $j;
				if ($i == 'name') $name = $j;
				if ($i == 'value') $value = $j;
			}
			$main_text .= '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$value.'">';
		}

		if (count($this->buttons))
		{
			$main_text .= '<div class="card-footer" style="text-align: right;">';

			foreach ($this->buttons as $k => $v)
			{
				$onclick = NULL;
				
				foreach ($v as $i => $j)
				{
					if ($i == 'type') $type = $j;
					if ($i == 'id') $id = $j;
					if ($i == 'name') $name = $j;
					if ($i == 'value') $value = $j;
					if ($i == 'onclick') $onclick = $j;
				}
				if ($type == 'submit')
				{
					$main_text .= '<button type="'.$type.'" id="'.$id.'" name="'.$name.'" class="btn btn-primary" value="'.$value.'" onclick="'.$onclick.'">'.$value.'</button>';
				}
				else if ($type == 'save')
				{
					$main_text .= '<button type="'.$type.'" id="'.$id.'" name="'.$name.'" class="btn btn-success" value="'.$value.'" onclick="'.$onclick.'">'.$value.'</button>';
				}
				else if ($type == 'close')
				{
					$main_text .= '<button type="'.$type.'" id="'.$id.'" name="'.$name.'" class="btn btn-primary" value="'.$value.'" onclick="'.$onclick.'">'.$value.'</button>';
				}
				else // anuluj
				{
					$main_text .= '<button type="button" id="'.$id.'" name="'.$name.'" class="btn btn-warning" value="'.$value.'" onclick="submit()">'.$value.'</button>';
				}
			}

			$main_text .= '</div>';
		}

		$main_text .= '</div>';

		$main_text .= '</form>';

		$main_text .= '<script>';
		$main_text .= 'setTimeout(function() { $("form#generator-form").find("input.focused").focus(); $("form#generator-form").find("textarea.focused").focus(); }, 500);';
		$main_text .= '</script>';

		return $main_text;
	}
}

?>
