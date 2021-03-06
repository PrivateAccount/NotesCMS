<?php

/*
 * Klasa odpowiedzialna za obsługę okien dialogowych
 */

class Dialog
{
	private $dlg_type;
	private $dlg_title;
	private $dlg_text;
	private $dlg_buttons;

	function __construct($type, $title, $content, $buttons)
	{
		$this->dlg_type = $type;
		$this->dlg_title = $title;
		$this->dlg_text = $content;
		$this->dlg_buttons = $buttons;
	}
	
	public function show_dialog_box()
	{
		$idx = 0;
		$main_dialog_body = NULL;
		$btn_type = array('default', 'danger', 'warning', 'primary', 'success', 'info');
		
		switch ($this->dlg_type)
		{
			case MSG_ERROR:
				$icon_name = 'msg_error.png';
				$alert_type = 'danger';
				break;
			case MSG_WARNING:
				$icon_name = 'msg_warning.png';
				$alert_type = 'warning';
				break;
			case MSG_INFORMATION:
				$icon_name = 'msg_information.png';
				$alert_type = 'info';
				break;
			case MSG_QUESTION:
				$icon_name = 'msg_question.png';
				$alert_type = 'success';
				break;
			default:
				$icon_name = 'on_off.png';
				$alert_type = 'default';
				break;
		}

		$main_dialog_body .= '<div class="card card-'. $alert_type .' center mt-5" style="width: 400px;">';

		$main_dialog_body .= '<div class="card-heading">';
		$main_dialog_body .= '<h3 class="card-title">';
		$main_dialog_body .= $this->dlg_title;
		$main_dialog_body .= '</h3>';
		$main_dialog_body .= '</div>';

		$main_dialog_body .= '<div class="card-body">';

		$main_dialog_body .= '<div class="form-group">';
		$main_dialog_body .= '<table>';
		$main_dialog_body .= '<tr>';
		$main_dialog_body .= '<td class="MsgIcon">';
		$main_dialog_body .= '<img src="img/msg/'. $icon_name .'" alt="'.$this->dlg_title.'" />';
		$main_dialog_body .= '</td>';
		$main_dialog_body .= '<td class="MsgMessage">';
		$main_dialog_body .= $this->dlg_text;
		$main_dialog_body .= '</td>';
		$main_dialog_body .= '</tr>';
		$main_dialog_body .= '</table>';
		$main_dialog_body .= '</div>';

		$main_dialog_body .= '</div>';

		$main_dialog_body .= '<div class="card-footer">';

		$main_dialog_body .= '<table>';
		$main_dialog_body .= '<tr>';
		$main_dialog_body .= '<td width="100%">&nbsp;</td>';

		foreach ($this->dlg_buttons as $key => $value)
		{
			foreach ($value as $k => $v)
			{
				if ($k == 'link') $link = $v;
				if ($k == 'caption') $caption = $v;
				if ($k == 'onclick') $onclick = $v;
			}
			$link = isset($link) ? $link : NULL;
			$caption = isset($caption) ? $caption : NULL;
			$onclick = isset($onclick) ? $onclick : NULL;
			$idx++;
			$main_dialog_body .= '<td class="MsgButtons">';
			$main_dialog_body .= '<form action="'. $link .'" method="post" role="form">';
			$main_dialog_body .= '<button type="submit" value="'. $caption .'" name="confirm_'. $idx .'" id="dialog_button_'.$idx.'" class="btn btn-'.$btn_type[$idx].'" onClick="'. $onclick .'" style="width: 100px;">' . $caption . '</button>';
			$main_dialog_body .= '</form>';
			$main_dialog_body .= '</td>';
		}

		$main_dialog_body .= '</tr>';
		$main_dialog_body .= '</table>';

		$main_dialog_body .= '</div>';

		$main_dialog_body .= '</div>';

		$main_dialog_body .= '<script>';
		$main_dialog_body .= 'setTimeout(function() { $("#dialog_button_1").focus(); }, 500);';
		$main_dialog_body .= '</script>';

		$main_dialog_body .= '<style>';
		$main_dialog_body .= 'section.content > div.container { padding: 165px 0 220px 0; }';
		$main_dialog_body .= '</style>';
		
		return $main_dialog_body;
	}
}

?>

