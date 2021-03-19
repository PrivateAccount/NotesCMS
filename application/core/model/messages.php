<?php

class Messages_Model extends Model
{
	private $table_name;

	public function __construct($db)
	{
		parent::__construct($db);
		
		$this->table_name = 'user_messages';
	}

	public function GetAll()
	{
		$this->rows_list = array();

		$condition = isset($_SESSION['messages_list_mode']) ? ' AND requested = ' . $_SESSION['messages_list_mode'] : NULL;

		$fields_list = array('client_ip', 'client_name', 'client_email', 'message_content');

		$filter = empty($_SESSION['list_filter']) ? NULL : $this->make_filter($fields_list);

		try
		{
			$query = 	'SELECT * FROM ' . $this->table_name . ' WHERE 1' . $condition . $filter .
						' ORDER BY ' . $this->list_params['sort_field'] . ' ' . $this->list_params['sort_order'] . 
						' LIMIT ' . $this->list_params['start_from'] . ', ' . $this->list_params['show_rows'];

			$statement = $this->db->prepare($query);

			$statement->execute();
			
			$this->rows_list = $statement->fetchAll(PDO::FETCH_ASSOC);

			$this->GetCount($query);
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $this->rows_list;
	}

	public function GetOne($id)
	{
		$this->row_item = array();

		try
		{
			$query =	'SELECT * FROM ' . $this->table_name .
						' WHERE id = :id';

			$statement = $this->db->prepare($query);
			
			$statement->bindValue(':id', $id, PDO::PARAM_INT); 

			$statement->execute();
			
			$this->row_item = $statement->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $this->row_item;
	}

	public function Save($id, $record)
	{
		$affected_rows = 0;

		try
		{
			$query =	'UPDATE ' . $this->table_name .
						' SET requested = :requested, close_date = :close_date' .
						' WHERE id = :id';

			$statement = $this->db->prepare($query);

			$statement->bindValue(':id', $id, PDO::PARAM_INT); 
			$statement->bindValue(':requested', $record['requested'], PDO::PARAM_INT); 
			$statement->bindValue(':close_date', $record['close_date'], PDO::PARAM_STR); 
			
			$statement->execute();
		
			$affected_rows = $statement->rowCount();
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $affected_rows;
	}

	public function Delete($id)
	{
		$affected_rows = 0;

		try
		{
			$query =	'DELETE FROM ' . $this->table_name .
						' WHERE id = :id';

			$statement = $this->db->prepare($query);

			$statement->bindValue(':id', $id, PDO::PARAM_INT); 
			
			$statement->execute();
			
			$affected_rows = $statement->rowCount();
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $affected_rows;
	}

	public function Clear()
	{
		$affected_rows = 0;
		$requested = 1;

		try
		{
			$query =	'DELETE FROM ' . $this->table_name .
						' WHERE requested = :requested';

			$statement = $this->db->prepare($query);

			$statement->bindValue(':requested', $requested, PDO::PARAM_INT); 
			
			$statement->execute();
			
			$affected_rows = $statement->rowCount();
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $affected_rows;
	}

	public function Exclude($record)
	{
		$affected_rows = 0;
		$key_name = 'black_list_visitors';
		$modified = date("Y-m-d H:i:s");

		try
		{
			$query =  "UPDATE configuration" .
			          " SET key_value = CONCAT(key_value, ', \'". $record['client_ip'] ."\'')," .
			          " modified = :modified" .
			          " WHERE key_name = :key_name";

			$statement = $this->db->prepare($query);

			$statement->bindValue(':modified', $modified, PDO::PARAM_STR); 
			$statement->bindValue(':key_name', $key_name, PDO::PARAM_STR); 
			
			$statement->execute();
			
			$affected_rows = $statement->rowCount();
		}
		catch (PDOException $e)
		{
			die ($e->getMessage());
		}

		return $affected_rows;
	}
}

?>
