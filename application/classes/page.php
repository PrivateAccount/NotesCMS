<?php

/*
 * Klasa odpowiedzialna za front-end strony
 */

class Page
{
	private $app;

	private $metadata;
	private $path;
	private $options;
	private $content;
	private $navbar;
	private $menu;
	private $categories;
	private $selected;
	private $message;
	private $dialog;

	private $response;

	private $layout;
	private $template;

	public function __construct($obj)
	{
		$this->app = $obj;

		$this->metadata = array(
			'base_domain' => $this->app->get_settings()->get_config_key('base_domain'), 
			'company_name' => $this->app->get_settings()->get_config_key('company_name'), 
			'main_title' => $this->app->get_settings()->get_config_key('main_title'), 
			'main_description' => $this->app->get_settings()->get_config_key('main_description'), 
			'main_keywords' => $this->app->get_settings()->get_config_key('main_keywords'), 
			'main_author' => $this->app->get_settings()->get_config_key('main_author'), 
		);

		include LIB_DIR . 'message.php';
		include LIB_DIR . 'dialog.php';

		$available_layouts = array('index', 'default', 'extended', 'advanced', 'admin', 'simple', 'custom');

		$this->layout = $this->app->get_settings()->get_config_key('page_template_default');

		if (!in_array($this->layout, $available_layouts)) $this->layout = 'default';
	}

	public function get_logo()
	{
		if (isset($_SESSION['install_mode']))
		{
			$logo = '<img src="'. PAGE_LOGO .'">';
		}
		else
		{
			$logo = '<img src="'. $this->app->get_settings()->get_config_key('logo_image') .'">';
		}
		return $logo;
	}

	public function set_metadata($key, $value)
	{
		$this->metadata[$key] = $value;
	}

	public function get_metadata($key)
	{
		if (isset($_SESSION['install_mode']))
		{
			if ($key == 'main_title') $result = 'MyCMS Installation';
			if ($key == 'company_name') $result = 'Install Script';
		}
		else
		{
			$result = array_key_exists($key, $this->metadata) ? $this->metadata[$key] : NULL;
		}
		return $result;
	}

	public function set_template($template)
	{
		$this->template = $template;
	}

	public function get_template()
	{
		return $this->template;
	}

	public function set_layout($layout)
	{
		$this->layout = $layout;
	}

	public function get_layout()
	{
		return $this->layout;
	}

	public function set_options($options)
	{
		$this->options = $options;
	}

	public function get_options()
	{
		$result = NULL;
		$items = NULL;

		if ($this->app->get_settings()->get_config_key('options_panel_visible') != 'true') return NULL;
		
		$show_border = $this->app->get_settings()->get_config_key('options_panel_border') == 'true';

		$result .= '<div class="options">';
		
		if (count($this->options))
		{
			foreach ($this->options as $k => $v)
			{
				foreach ($v as $key => $value)
				{
					if ($key == 'link') $link = $value;
					if ($key == 'caption') $caption = $value;
					if ($key == 'icon') $icon = $value;
				}
				$items .= '<span class="options-item"><a href="'. $link .'"><i class="'. $icon .'"></i>'. $caption .'</a></span>';
			}
			if ($show_border)
			{
				$result .= '<div class="card card-default">';
				$result .= '<div class="card-body">';
				$result .= $items;
				$result .= '</div>';
				$result .= '</div>';
			}
			else
			{
				$result .= '<div class="container">';
				$result .= '<div class="row">';
				$result .= '<div class="col-lg-12">';
				$result .= '<div class="options-links">';
				$result .= $items;
				$result .= '</div>';
				$result .= '</div>';
				$result .= '</div>';
				$result .= '</div>';
			}
		}
		
		$result .= '</div>';

		return $result;
	}

	public function set_content($content)
	{
		$this->content = $content;
	}

	public function get_content()
	{
		return $this->content;
	}

	public function set_message($type, $content)
	{
		$this->message = new Message($type, $content);
	}

	public function get_message()
	{
		return $this->message;
	}

	public function show_message()
	{
		$this->set_message(NULL, NULL);
		
		return $this->message->show_message_box();
	}

	public function set_dialog($type, $title, $content, $buttons)
	{
		$this->dialog = new Dialog($type, $title, $content, $buttons);
	}

	public function get_dialog()
	{
		return $this->dialog;
	}

	public function get_logged()
	{
		$line = NULL;

		if ($this->app->get_settings()->get_config_key('logged_panel_visible') != 'true') return NULL;

		$line .= '<div class="navbar-text navbar-right">';

		if ($this->app->get_user()->get_value('user_status'))
		{
			$status = $this->app->get_user()->get_status();
			
			$line .= 'Witaj, '. $status['user_name'] .' '. $status['user_surname'] .' - (<a href="index.php?route=logout">Wyloguj</a>)';
		}
		else
		{
			$line .= 'Nie jesteś zalogowany';
		}

		$line .= '</div>';

		return $line;
	}

	public function get_search()
	{
		$line = NULL;

		if ($this->app->get_settings()->get_config_key('search_panel_visible') != 'true') return NULL;

		$line .= '<form action="index.php?route=search" id="main-search" class="form" style="display: inline-flex;" role="search" method="post">';
		$line .= '<input type="search" name="text-search" id="search-input" class="form-control" placeholder="Szukaj">';
		$line .= '<button type="submit" name="button-search" id="search-button" class="btn btn-outline-success"><i class="fas fa-search"></i></button>';
		$line .= '</form>';

		return $line;
	}

	public function get_links()
	{
		if ($this->app->get_settings()->get_config_key('links_panel_visible') != 'true') return NULL;

		if ($this->app->get_user()->get_value('user_status')) // zalogowany
		{
			$links = array (
				array (
					'link' => 'index.php?route=admin',
					'caption' => 'Admin-panel',
					'icon' => 'img/top/tools.png'
				),
				array (
					'link' => 'index.php?route=logout',
					'caption' => 'Wyloguj',
					'icon' => 'img/top/logout.png'
				),
				array (
					'link' => 'index.php?route=contact',
					'caption' => 'Kontakt',
					'icon' => 'img/top/contact.png'
				)
			);
		}
		else // nie zalogowany
		{
			$links = array (
				array (
					'link' => 'index.php?route=login',
					'caption' => 'Zaloguj',
					'icon' => 'img/top/user.png'
				),
				array (
					'link' => 'index.php?route=register',
					'caption' => 'Rejestruj',
					'icon' => 'img/top/register.png'
				),
				array (
					'link' => 'index.php?route=contact',
					'caption' => 'Kontakt',
					'icon' => 'img/top/contact.png'
				)
			);
		}

		if (isset($_SESSION['search_text']))
		{
			$links[] = array (
				'link' => 'index.php?route=search',
				'caption' => NULL,
				'icon' => 'img/top/search.png'
			);
		}

		$line = NULL;
		
		$line .= '<div id="navbarCollapse" class="collapse navbar-collapse">';
		
		$line .= '<ul class="nav navbar-nav navbar-right">';

		foreach ($links as $items)
		{
			foreach ($items as $key => $value)
			{
				if ($key == 'link') $link = $value;
				if ($key == 'caption') $caption = $value;
				if ($key == 'icon') $icon = $value;
			}
			$line .= '<li><a href="'. $link .'" class="navbar-link"><img src="'. $icon .'" />'. $caption .'</a></li>';
		}
		
		$line .= '</ul>';
		
		$line .= '</div>';

		return $line;
	}

	public function set_path($path)
	{
		$this->path = $path;
	}

	public function get_path()
	{
		$path = NULL;

		if ($this->app->get_settings()->get_config_key('path_panel_visible') != 'true') return NULL;

		$path .= '<ol class="breadcrumb">';

		if (count($this->path))
		{
			foreach ($this->path as $link => $caption)
			{
				$path .= '<li>'.'<a href="'. $link .'">'. $caption .'</a>'.'</li>';
			}
		}

		$path .= '</ol>';

		return $path;
	}

	public function set_navbar($navbar)
	{
		$this->navbar = $navbar;
	}

	public function get_navbar()
	{
		$result = NULL;

		if ($this->app->get_settings()->get_config_key('navbar_panel_visible') == 'true')
		{
			$result .= '<ul class="nav">';

			$this->navbar = $this->app->get_menu()->GetItems(NAVIGATOR);

			$user_status = $this->app->get_user()->get_value('user_status');

			if (count($this->navbar))
			{
				foreach ($this->navbar as $k => $v)
				{
					foreach ($v as $key => $value)
					{
						if ($key == 'id') $id = $value;
						if ($key == 'caption') $caption = $value;
						if ($key == 'link') $link = $value;
						if ($key == 'target') $target = $value;
						if ($key == 'permission') $permission = $value;
					}

					$class_name = $id == $this->get_selected() ? 'nav-selected' : 'nav-item';

					$option = $target ? 'target="_blank"' : NULL;

					$access = $user_status ? $user_status <= $permission : $permission == FREE;

					if ($access) // pozycja menu dostępna
					{
						$result .= '<li class="'. $class_name .'">'.'<a class="nav-link" href="'. $link .'" '. $option .'>'. $caption .'</a>'.'</li>';
					}
					else // pozycja menu z ochroną dostępu
					{
						$result .= '<li class="'. $class_name .'">'.'<a class="nav-link disabled" href="'. $link .'" '. $option .'>'.'<i>'. $caption .'</i>'.'</a>'.'</li>';
					}
				}
			}

			$result .= '</ul>';
		}
		
		return $result;
	}

	public function get_topbar()
	{
		$result = NULL;

		$user_status = $this->app->get_user()->get_value('user_status');
		
		if (!isset($_SESSION['install_mode']))
		{
			if ($user_status) // admin panel
			{
				$result .= '<a class="btn btn-primary" href="index.php?route=admin"><i class="fas fa-user"></i> &nbsp; Admin Panel</a>';
			}
			else // logowanie
			{
				$result .= '<a class="btn btn-primary" href="index.php?route=login"><i class="fas fa-sign-in-alt"></i> &nbsp; Logowanie</a>';
			}
		}
		
		return $result;
	}
	
	public function set_categories($categories)
	{
		$this->categories = $categories;
	}

	public function get_categories()
	{
		$this->menu = NULL;

		if ($this->app->get_settings()->get_config_key('categories_panel_visible') != 'true') return NULL;

		$this->categories = $this->app->get_menu()->GetItems(CATEGORIES);

		$user_status = $this->app->get_user()->get_value('user_status');
		
		$this->menu .= '<div class="categories-nav">';

		$this->GetChildren(0, $user_status); // wywołanie rekurencyjnego budowania struktury od root-a (node = 0)
		
		$this->menu .= '</div>';

		return $this->menu;
	}

	private function GetChildren($node_id, $user_status)
	{
		$this->menu .= '<ul class="categories">';
		
		if (count($this->categories))
		{
			foreach ($this->categories as $key => $value)
			{
				foreach ($value as $k => $v)
				{
					if ($k == 'id') $id = $v;
					if ($k == 'parent_id') $parent_id = $v;
					if ($k == 'permission') $permission = $v;
					if ($k == 'caption') $caption = $v;
					if ($k == 'link') $link = $v;
				}
				
				if ($parent_id == $node_id)
				{
					$class_name = $id == $this->get_selected() ? 'category-selected' : NULL;

					$access = $user_status ? $user_status <= $permission : $permission == FREE;

					if ($access) // pozycja menu dostępna
					{
						$this->menu .= '<li class="'. $class_name .'">'.'<a href="'. $link .'">'. $caption .'</a>'.'</li>';
					}
					else // pozycja menu z ochroną dostępu
					{
						$this->menu .= '<li class="'. $class_name .'">'.'<a href="'. $link .'">'.'<i>'. $caption .'</i>'.'</a>'.'</li>';
					}
						
					$this->GetChildren($id, $user_status); // rekurencyjne zagłębianie w strukturę
				}
			}
		}
		
		$this->menu .= '</ul>';
	}

	public function set_selected($id)
	{
		$this->selected = $id;
	}

	public function get_selected()
	{
		return $this->selected;
	}

	public function get_footer()
	{
		$result = $this->app->get_settings()->get_config_key('page_footer');

		$result .= '<div class="copyright">&copy; '. $this->get_metadata('company_name') .' {_year_}. Wszystkie prawa zastrzeżone.</div>';
		
		$result = str_replace('{_year_}', date("Y"), $result);

		return $result;
	}

	public function get_socials()
	{
		if ($this->app->get_settings()->get_config_key('social_links_visible') != 'true') return NULL;
		
		$object = json_decode($this->app->get_settings()->get_config_key('social_links'));
		
		$result = NULL;
		
		$result .= '<ul class="list-socials">';
		
		if (is_array($object->{'links'}))
		{
			foreach ($object->{'links'} as $links)
			{
				foreach ($links as $key => $value)
				{
					if ($key == 'name') $name = $value;
					if ($key == 'icon') $icon = $value;
					if ($key == 'link') $link = $value;
				}
				$result .= '<li class="list-socials-item">';
				$result .= '<a href="'.$link.'" target="_blank">';
				$result .= '<i class="'.$icon.' fa-2x fa-fw"></i>';
				$result .= '</a>';
				$result .= '</li>';
			}
		}
		
		$result .= '</ul>';
		
		return $result;
	}

	public function render()
	{
		$layout = TEMPL_DIR . 'pages/' . $this->layout . '.php';

		$template = TEMPL_DIR . 'contents/' . $this->template . '.php';

		if (file_exists($layout))
		{
			if (file_exists($template))
			{
				include $template;

				$this->set_content($main_template_content);

				include $layout;

				$this->response = trim($main_layout_content);
			}
			else
			{
				$this->response = 'Template "'. $template .'" not found.';
			}
		}
		else
		{
			$this->response = 'Layout "'. $layout .'" not found.';
		}

		echo $this->response;
	}
}

?>
