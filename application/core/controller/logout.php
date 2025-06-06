<?php

class Logout_Controller extends Controller
{
	public function __construct($app)
	{
		parent::__construct($app);
	}
	
	public function Index_Action()
	{
		if ($this->app->get_user()->get_value('user_status')) // zalogowany
		{
			$id = $this->app->get_user()->get_value('user_id');
			$this->app->get_model_object()->SaveLogout($id);
			
			$_SESSION = array(); // Clear all session data
			
			// Delete session cookie
			if (isset($_COOKIE[session_name()])) 
			{
				setcookie(session_name(), '', time() - 3600, '/');
			}
			
			// Destroy session
			session_destroy();

			$this->app->get_page()->set_message(MSG_INFORMATION, 'Zostałeś pomyślnie wylogowany z serwisu.');

			header('Location: index.php');
			exit;
		}
		else // nie zalogowany
		{
			header('Location: index.php?route=login');
			exit;
		}
	}
}


?>
