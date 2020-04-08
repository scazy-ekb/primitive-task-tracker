<?php

namespace App\Core;

include_once 'App/Core/SqlResult.php';

class SqlConnection
{
	private $connection;

	function connect($host, $user, $pass, $dbname)
	{
        if (!$this->connection = mysqli_connect($host, $user, $pass, $dbname)) {
            $this->writeError();
            throw new \Exception('DB connection error!');
		}

	    mysqli_query($this->connection, "SET NAMES utf8;");
   	    mysqli_query($this->connection, "SET CHARACTER SET utf8;");

		mysqli_query($this->connection, "SET collation_connection='utf8_general_ci'");
		mysqli_query($this->connection, "SET collation_server='utf8_general_ci'");
		mysqli_query($this->connection, "SET character_set_client='utf8'");
		mysqli_query($this->connection, "SET character_set_connection='utf8'");
		mysqli_query($this->connection, "SET character_set_results='utf8'");
		mysqli_query($this->connection, "SET character_set_server='utf8'");
	}

	function execute($query)
	{
	    if (empty($this->connection))
            throw new \Exception('DB connection lost!');
/*
		if (!@mysqli_select_db($this->dbname, $this->connection)) {
            $this->WriteError($query);
            return false;
        }
*/

        $result = @mysqli_query($this->connection, $query);

		if (!$result) {
			$this->writeError($query);
			return false;
		}

		return new SqlResult($result);
	}

	public function Disconnect()
	{
		@mysqli_close($this->connection);
	}

	public function escape($str)
    {
        return mysqli_real_escape_string($this->connection, $str);
    }

	private function writeError($query = null)
    {
        $str = "Date: ".date('d-m-Y H:i')."\r\n";

        if ($this->connection)
            $str .= "MySql Error: ".mysqli_error($this->connection)."\r\n";
        else
            $str .= "MySql Error: ".mysqli_connect_error()."\r\n";

        if ($query)
            $str .= "Query: ".$query."\r\n";

        $str .= "URL: ".$_SERVER['REQUEST_URI']."\r\n";
        $str .= "Script: ".$_SERVER['SCRIPT_NAME']."\r\n\r\n";
        $this->writeLog($str);
    }

	private function writeLog($str, $mode = 'a')
	{
		$f = fopen(__DIR__.'/../../Logs/sql.log', $mode);
		flock($f, LOCK_EX);
		fwrite($f, $str);
		fclose($f);
	}
}
