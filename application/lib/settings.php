<?php

/*
 * Klasa odpowiedzialna za obsługę ustawień konfiguracyjnych w bazie
 */

class Settings
{
	private $db;

	public function __construct($obj)
	{
		$this->db = $obj->get_dbc();
	}

	public function get_config_key($key)
	{
		$config_value = NULL;
		$active = 1;

		if (isset($_SESSION['install_mode']))
		{			
			if ($key == 'base_domain') return $_SERVER['HTTP_HOST'];
			else return NULL;
		}

		try
		{
			$query = 'SELECT * FROM configuration WHERE key_name = :key_name AND active = :active';

			$statement = $this->db->prepare($query);

			$statement->bindParam(':key_name', $key, PDO::PARAM_STR);
			$statement->bindParam(':active', $active, PDO::PARAM_INT);
			
			$statement->execute();
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			
			$config_value = $result['key_value'];
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $config_value;
	}
}

?>