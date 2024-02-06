<?php

/*
 * Klasa odpowiedzialna za generowanie paginacji list
 */

class List_Paginator
{
	private $pointer_band;
	private $current_pointer;
	private $pointer_count;
	private $base_link;
	private $route;
	private $action;
	private $page_rows;
	
	function __construct()
	{
		$this->page_rows = Array(NULL, 5, 10, 15, 20, 50, 100);
	}
	
	public function init($link, $current, $count, $band)
	{
		$this->base_link = $link;
		$this->current_pointer = $current;
		$this->pointer_count = $count;
		$this->pointer_band = $band;

		$route_segment = array();
		$action_segment = array();

		if (strpos($this->base_link, 'route=') !== FALSE)
			$route_segment = explode('route=', $this->base_link);

		if (strpos($this->base_link, 'action=') !== FALSE)
			$action_segment = explode('action=', $this->base_link);

		$this->route = sizeof($route_segment) > 1 ? $route_segment[1] : NULL;
		$this->action = sizeof($action_segment) > 1 ? $action_segment[1] : NULL;

		if (strpos($this->route, '&') !== FALSE)
			$this->route = substr($this->route, 0, strpos($this->route, '&'));

		if (strpos($this->action, '&') !== FALSE)
			$this->action = substr($this->action, 0, strpos($this->action, '&'));
	}
	
	public function show()
	{
		$output = NULL;
		
		$output .= '<div class="container">';
		$output .= '<div class="row">';
		$output .= '<div class="counters col-lg-3">';
		$output .= 'Pozycji: <b>' . number_format($_SESSION['result_capacity'], 0, ',', '.') . '</b>';
		$output .= '&nbsp; ▪ &nbsp;';
		$output .= 'Stron: <b>' . number_format($_SESSION['page_counter'], 0, ',', '.') . '</b>';
		$output .= '</div>';
		$output .= '<div class="pages col-lg-6">';
		
		$output .= '<nav aria-label="Nawigacja">';
		$output .= '<ul class="pagination" style="">';
		
		if ($this->current_pointer == 0)
		{
			$output .= '<li class="page-item disabled"><a class="page-link PagePointerDisabled"><span>&#171;</span></a></li>';
			$output .= '<li class="page-item disabled"><a class="page-link PagePointerDisabled"><span>&#8249;</span></a></li>';
		}
		else
		{
			$output .= '<a href="'.$this->base_link.'&skip=first" class="page-link PagePointer"><li class="page-item"><span>&#171;</span></li></a>';
			$output .= '<a href="'.$this->base_link.'&skip=prev" class="page-link PagePointer"><li class="page-item"><span>&#8249;</span></li></a>';
		}

		$shown = 1;
		$min_p = intval($this->current_pointer) + 1;
		$max_p = $min_p;
		
		for ($i = 1; $i <= intval($this->pointer_count); $i++)
		{
			$cur_p = $min_p - 1;
			if ($cur_p < $min_p && $cur_p > 0) { $min_p = $cur_p; $shown++; }
			$cur_p = $max_p + 1;
			if ($cur_p > $max_p && $cur_p <= intval($this->pointer_count)) { $max_p = $cur_p; $shown++; }
			if ($shown >= 2 * $this->pointer_band + 1) break;
		}
		for ($i = $min_p; $i <= $max_p; $i++)
		{
			if ($i == $this->current_pointer + 1)
				$output .= '<li class="page-item active"><a class="page-link PagePointerCurrent">'.$i.'</a></li>';
			else
				$output .= '<a href="'.$this->base_link.'&page='.$i.'" class="page-link PagePointer"><li class="page-item">'.$i.'</li></a>';
		}

		if (intval($this->current_pointer) == intval($this->pointer_count - 1) || $this->pointer_count == 0)
		{
			$output .= '<li class="page-item disabled"><a class="page-link PagePointerDisabled"><span>&#8250;</span></a></li>';
			$output .= '<li class="page-item disabled"><a class="page-link PagePointerDisabled"><span>&#187;</span></a></li>';
		}
		else
		{
			$output .= '<a href="'.$this->base_link.'&skip=next" class="page-link PagePointer"><li class="page-item"><span>&#8250;</span></li></a>';
			$output .= '<a href="'.$this->base_link.'&skip=last" class="page-link PagePointer"><li class="page-item"><span>&#187;</span></li></a>';
		}
		
		$output .= '</ul>';
		$output .= '</nav>';
		$output .= '</div>';
		$output .= '<div class="band col-lg-1">';
		$output .= '<form action="'.$this->base_link.'" method="get" class="navbar-form" style="display: flex;">';
		if ($this->route)
			$output .= '<input type="hidden" name="route" value="'.$this->route.'" />';
		if ($this->action)
			$output .= '<input type="hidden" name="action" value="'.$this->action.'" />';
		$output .= '<select name="page_rows" id="page_rows" class="form-control" onchange="submit()">';
		foreach ($this->page_rows as $key => $value) 
		{
			$selected = NULL;
			if (isset($_SESSION['page_list_rows']))
			{
				if ($value == $_SESSION['page_list_rows'])
					$selected = 'selected="selected"';
				if ($key == 0) continue;
			}
			$output .= '<option '.$selected.'>';
			$output .= $value;
			$output .= '</option>';
		}
		$output .= '</select>';
		$output .= '</form>';	
		$output .= '</div>';
		$output .= '<div class="skip col-lg-2">';
		$output .= '<form action="'.$this->base_link.'" method="get" class="navbar-form" style="display: flex;">';
		if ($this->route)
			$output .= '<input type="hidden" name="route" value="'.$this->route.'" />';
		if ($this->action)
			$output .= '<input type="hidden" name="action" value="'.$this->action.'" />';
		$output .= '<input type="text" name="page" id="page-number" class="form-control" style="width: 40px; margin: 0 5px;">';
		$output .= '<button class="btn btn-primary" name="navi" type="submit" value="go" style="margin: 2px;">idź</button>';
		$output .= '</form>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

?>