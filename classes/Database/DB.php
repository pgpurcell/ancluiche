<?php
require_once('classes/ez_sql.php');

class PP_DB extends db
{
	public function quote($str)
	{
		return mysql_real_escape_string($str, $this->dbh);
	}
}