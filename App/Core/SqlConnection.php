<?php

namespace App\Core;

include_once 'App/Core/SqlResult.php';

class SqlConnection
{
	private ?\mysqli $connection;

	public function __construct()
    {
        $this->connection = null;
    }

    function connect(string $host, string $user, string $pass, string $dbname)
	{
        if (!$connection = @mysqli_connect($host, $user, $pass, $dbname)) {
            $this->writeError();
            throw new \Exception('DB connection error!');
		}

        $this->connection = $connection ? $connection : null;

	    mysqli_query($this->connection, "SET NAMES utf8;");
   	    mysqli_query($this->connection, "SET CHARACTER SET utf8;");

		mysqli_query($this->connection, "SET collation_connection='utf8_general_ci'");
		mysqli_query($this->connection, "SET collation_server='utf8_general_ci'");
		mysqli_query($this->connection, "SET character_set_client='utf8'");
		mysqli_query($this->connection, "SET character_set_connection='utf8'");
		mysqli_query($this->connection, "SET character_set_results='utf8'");
		mysqli_query($this->connection, "SET character_set_server='utf8'");
	}

	function isConnected()
    {
        return $this->connection!= null && $this->connection->ping();
    }

	function query($query) : SqlResult
	{
	    if (empty($this->connection))
            throw new \Exception('DB connection lost!');

        $sqlResult = @mysqli_query($this->connection, $query);

		if ($sqlResult === false) {
			$this->writeError($query);
			return false;
		}

		return new SqlResult($sqlResult);
	}

    function execute($query) : bool
    {
        if (empty($this->connection))
            throw new \Exception('DB connection lost!');

        $sqlResult = @mysqli_query($this->connection, $query);

        if ($sqlResult === false) {
            $this->writeError($query);
            return false;
        }

        return $sqlResult;
    }

    public function Disconnect() : void
	{
	    if ($this->connection == null)
	        return;

	    @mysqli_close($this->connection);
	}

	public function escape($str)
    {
        if ($this->connection == null)
            throw new \Exception('$connection');

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
