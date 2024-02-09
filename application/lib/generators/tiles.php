<?php

/*
 * Klasa odpowiedzialna za tworzenie kafelków - Generator Kafelków
 */

include GENER_DIR . 'builder.php';

class TilesBuilder extends Builder
{
	private $title;
	private $image;
	
	private $data;
	private $params;
	private $url;

	public function __construct()
	{
		parent::__construct();
	}

	public function init($title, $image, $data, $params, $url)
	{
		$this->image = $image;
		$this->title = $title;
		$this->data = $data;
		$this->params = $params;
		$this->url = $url;
	}

	public function build_tiles()
	{
		$main_text = NULL;

		include CLASS_DIR . 'paginator.php';
		
		$paginator = new List_Paginator();

		$base_link = 'index.php?route=' . MODULE_NAME . '&action=gallery';
						
		$paginator->init($base_link, $this->params['show_page'], $this->params['page_counter'], $this->params['page_band']);

		$main_text .= '<h3 class="card-title">';
		$main_text .= '<i class="'.$this->image.'"></i>';
		$main_text .= '&nbsp; '.$this->title;
		$main_text .= '</h3>';

		$main_text .= '<table class="table table-bordered">';

		$main_text .= '<tr>';
		$main_text .= '<td class="TableControlBar" style="text-align: right; border-top: none; border-bottom: 1px solid #ddd;">';
		$main_text .= '<form style="display: inline-flex; margin: 0 2em 2em 0;" action="index.php?route=' . MODULE_NAME . '&action=gallery" class="navbar-form" role="search" method="post">';
		$main_text .= '<input type="text" id="ListSearchText" name="ListSearchText" value="" class="form-control" />&nbsp;';
		$main_text .= '<button type="submit" name="ListSearchButton" id="ListSearchButton" class="btn btn-success">Szukaj</button>';
		$main_text .= '</form>';
		$main_text .= '</td>';
		$main_text .= '</tr>';
		
		// jeśli wprowadzono filtr:
		
		if (!empty($_SESSION['list_filter']))
		{
			$main_text .= '<tr>';
			$main_text .= '<td class="FormSearchBar" style="border-bottom: 1px solid #ddd;">';
			$main_text .= '<form id="form_search_close" action="index.php?route=' . MODULE_NAME . '&action=gallery" method="post">';
			$main_text .= '<span class="FormSearchCaption">Wyszukiwanie:</span>&nbsp;';
			$main_text .= '<span class="FormSearchValue">" <b>' . $_SESSION['list_filter'] . '</b> "</span>';
			$main_text .= '<span class="FormSearchClose">';
			$main_text .= '<input type="hidden" name="ListSearchClose" value="Close" />';
			$main_text .= '<i class="fas fa-times-circle" onclick="document.getElementById(\'form_search_close\').submit();" title="Usuń filtr"></i>';
			$main_text .= '</span>'; 
			$main_text .= '</form>';
			$main_text .= '</td>';
			$main_text .= '</tr>';
		}

		if (count($this->data)) // są dane
		{
			$main_text .= '<tr>';
			$main_text .= '<td style="text-align: center; border-top: none;">';

			foreach ($this->data as $k => $row)
			{
				foreach ($row as $key => $value)
				{
					if ($key == 'id') $picture_id = $value;
					if ($key == 'preview') $preview = $value;
					if ($key == 'file_name') $file_name = $value;
					if ($key == 'file_size') $file_size = $value;
					if ($key == 'picture_width') $picture_width = $value;
					if ($key == 'picture_height') $picture_height = $value;
					if ($key == 'modified') $modified = $value;
				}

				$img_link = isset($_SESSION['last_url']) ? $this->url.'&image='.$picture_id : $preview;

				$main_text .= '<span class="gallery_item">';
				$main_text .= '<a href="'.$img_link.'">';
				$main_text .= '<img src="'. GALLERY_DIR . IMG_DIR . $picture_id .'" title="Nazwa: '.$file_name.'&#13;&#10;Rozmiar: '.$file_size.'&#13;&#10;Wymiary: '.$picture_width.' x '.$picture_height.' px &#13;&#10;Modyfikacja: '.$modified.'" onclick="select('.$picture_id.')">';
				$main_text .= '</a>';
				$main_text .= '</span>';
			}

			$main_text .= '</td>';
			$main_text .= '</tr>';
		}
		else // brak danych
		{
			$main_text .= '<tr>';
			$main_text .= '<td class="DataCellMsg">';
			$main_text .= '<div><img src="img/32x32/warning.png" alt="empty result" /></div>';
			$main_text .= '<div>(brak wyników)</div>';
			$main_text .= '</td>';
			$main_text .= '</tr>';
		}

		$main_text .= '<tr>';
		$main_text .= '<td class="PaginatorCell">';
		$main_text .= $paginator->show();
		$main_text .= '</td>';
		$main_text .= '</tr>';
		$main_text .= '</table>';

		return $main_text;
	}
}

?>
