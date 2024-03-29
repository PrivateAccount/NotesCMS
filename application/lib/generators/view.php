<?php

/*
 * Klasa odpowiedzialna za tworzenie widoków - Generator Widoków
 */

include GENER_DIR . 'builder.php';

class ViewBuilder extends Builder
{
	private $id;
	private $image;
	private $title;
	private $width;
	private $action;
	private $inputs = Array();	
	private $buttons = Array();
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function init($form_title, $form_image, $form_width)
	{
		$this->image = $form_image;
		$this->title = $form_title;
		$this->width = $form_width;
	}
	
	public function set_id($form_id)
	{
		$this->id = $form_id;
	}

	public function set_action($form_address)
	{
		$this->action = $form_address;
	}

	public function set_inputs($form_rows)
	{
		$this->inputs = Array();
		
		foreach ($form_rows as $k => $v)
		{
			$this->inputs[] = $v;
		}
	}
	
	public function set_buttons($form_submits)
	{
		$this->buttons = Array();

		foreach ($form_submits as $k => $v) $this->buttons[] = $v;
	}
	
	public function build_view()
	{
		$main_text = NULL;
		
		$main_text .= '<form id="'. $this->id .'" action="'. $this->action .'" method="post" role="form">';

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
			foreach ($v as $key => $val)
			{
				if ($key == 'caption') $caption = $val;
				if ($key == 'value') $value = $val;
			}
			$main_text .= '<div class="form-group">';
			$main_text .= '<table width="100%">';
			$main_text .= '<tr>';
			$main_text .= '<td class="ViewKey">';
			$main_text .= $caption.':';
			$main_text .= '</td>';
			$main_text .= '<td class="ViewData">';
			if (is_array($value))
			{
				if (array_key_exists('original', $value) && array_key_exists('converted', $value)) // linki referer i uri
				{
					foreach ($value as $i => $j) 
					{
						if ($i == 'original') $original = $j;
						if ($i == 'converted') $converted = $j;
					}
					$main_text .= '<div>';
					$main_text .= '<a href="' . $original . '" target="_blank">' . $converted . '</a>';
					$main_text .= '</div>';
				}
				else // zwykłe dane
				{
					foreach ($value as $i => $j) 
					{
						$main_text .= '<div>' . $j . '</div>';
					}
				}
			}
			else // normalne dane
			{
				$main_text .= $value;
			}
			$main_text .= '</td>';
			$main_text .= '</tr>';
			$main_text .= '</table>';
			$main_text .= '</div>';
		}

		$main_text .= '</div>';

		$main_text .= '<div class="card-footer" style="text-align: right;">';

		foreach ($this->buttons as $k => $v)
		{
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
				$main_text .= '<button type="'.$type.'" id="'.$id.'" name="'.$name.'" class="btn btn-primary" value="'.$value.'">'.$value.'</button>';
			}
			else if ($type == 'skip')
			{
				$main_text .= '<button type="'.$type.'" id="'.$id.'" name="'.$name.'" class="btn btn-info" value="'.$value.'" onclick="'.$onclick.'">'.$value.'</button>';
			}
			else // anuluj
			{
				$main_text .= '<button type="button" id="'.$id.'" name="'.$name.'" class="btn btn-warning" value="'.$value.'" onclick="submit()">'.$value.'</button>';
			}
		}

		$main_text .= '</div>';

		$main_text .= '</div>';

		$main_text .= '</form>';
		
		$main_text .= '
			<script>
				document.addEventListener("keydown", function(event) {
					var keyCode = event.keyCode;
					if (keyCode == 37) $("button#prev_button").click();
					if (keyCode == 39) $("button#next_button").click();
				});
			</script>
		';
		
		return $main_text;
	}
}

?>
