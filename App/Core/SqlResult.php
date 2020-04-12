<?php

namespace App\Core;

class SqlResult
{
    var ?\mysqli_result $result;

    function __construct(\mysqli_result $result)
    {
        $this->result = $result;
    }

    function fetchArray()
    {
        return @mysqli_fetch_array($this->result, MYSQLI_ASSOC);
    }

    public function fetchObject()
    {
        return $this->result
            ? @mysqli_fetch_object($this->result)
            : false;
    }

    function fetch_row()
    {
        return @mysqli_fetch_row($this->result);
    }

    function free_result()
    {
        @mysqli_free_result ($this->result);
        return true;
    }

    function RowsCount()
    {
        return @mysqli_num_rows($this->result);
    }

    function num_fields()
    {
        return @mysqli_num_fields($this->result);
    }

    function data_seek($i)
    {
        return @mysqli_data_seek($this->result, $i);
    }
}
