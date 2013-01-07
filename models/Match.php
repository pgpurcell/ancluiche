<?php

require_once('classes/Database/DB.php');

class Match
{
    var $db;
	var $id;
	var $season;
	var $datetime;
	var $code;
	var $grade;
	var $type;
	var $competition;
	var $stage;
	var $team1;
	var $score1;
	var $team2;
	var $score2;
	var $venue;
	var $address;
	var $referee_firstname;
	var $referee_lastname;
	var $referee_county;
	var $referee_club;
	var $table_name = 'matches';
	var $field_defs = array(
		'id',
		'season',
		'datetime',
		'code',
		'grade',
		'type',
		'competition',
		'stage',
		'team1',
		'score1',
		'team2',
		'score2',
		'venue',
		'address',
		'referee_firstname',
		'referee_lastname',
		'referee_county',
		'referee_club',
	);

	function __construct()
    {
		$this->db = new PP_DB(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
    }

	public function populate($data)
	{
		// TODO: convert score into score_goals etc.
		foreach ($this->field_defs as $key => $val)
		{
			if (isset($data[$val]))
			{
				$this->$val = $data[$val];
			}
		}
		echo ":".print_r($this,1).":";
	}

	public function retrieve($id)
	{
		$query = "SELECT $this->table_name.* FROM $this->table_name ";

		// TODO: Add a function to ez_sql.php that safe quotes db values
		$query .= " WHERE $this->table_name.id = ".$this->db->quoted($id);

		// TODO: Write a limit query
		$result = $this->db->limitQuery($query,0,1,true, "Retrieving record by id $this->table_name:$id found ");
		if(empty($result))
		{
			return null;
		}

		// TODO: Something like this to ez_sql
		////$row = $this->db->fetchByAssoc($result, $encode);
		if(empty($row))
		{
			return null;
		}

		foreach ($row as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}

		// TODO: Populate if neccessary related fields
		// we're going to do this by specifying a model_name field for each related model_id field and use inner joins
		// on the main query to populate them.
		// This will only work on 1 to 1 relationships which is all we need for now
	}

	public function save()
	{
		$isUpdate = true;
		if(empty($this->id))
		{
			$isUpdate = false;
		}

		// TODO: Question: add date_modified to the model?
		if ($isUpdate) {
			$this->update();
			//$this->db->update($this);
		} else {
			$this->insert();
			//$this->db->insert($this);
		}
	}

	public function insert()
	{
		$values = array();
		foreach ($this->field_defs as $key => $val)
		{
			if ($val != 'id')
			{
				$values[$val] = "'".$this->db->quote($this->$val)."'";
			}
		}

		$query = "INSERT INTO ".$this->table_name." (".implode(",", array_keys($values)).")
					VALUES (".implode(",", $values).")";echo ":".$query.":";
		$this->db->query($query);
	}

	// TODO: Make the below function work inside the insert part
	// TODO: add a field def array to the model possibly from a vardefs.php file
	/**
	 * Insert data into table by parameter definition
	 * @param string $table Table name
	 * @param array $field_defs Definitions in vardef-like format
	 * @param array $data Key/value to insert
	 * @param array $field_map Fields map from SugarBean
	 * @param bool $execute Execute or return query?
	 * @return bool query result
	 */
	public function insertParams($table, $field_defs, $data, $field_map = null, $execute = true)
	{
		$values = array();
		foreach ($field_defs as $field => $fieldDef)
		{
			if (isset($fieldDef['source']) && $fieldDef['source'] != 'db')  continue;
			//custom fields handle there save seperatley
			if(!empty($field_map) && !empty($field_map[$field]['custom_type'])) continue;

			if(isset($data[$field])) {
				// clean the incoming value..
				$val = from_html($data[$field]);
			} else {
				if(isset($fieldDef['default']) && strlen($fieldDef['default']) > 0) {
					$val = $fieldDef['default'];
				} else {
					$val = null;
				}
			}

			//handle auto increment values here - we may have to do something like nextval for oracle
			if (!empty($fieldDef['auto_increment'])) {
				$auto = $this->getAutoIncrementSQL($table, $fieldDef['name']);
				if(!empty($auto)) {
					$values[$field] = $auto;
				}
			} elseif ($fieldDef['name'] == 'deleted') {
				$values['deleted'] = (int)$val;
			} else {
				// need to do some thing about types of values
				if(!is_null($val) || !empty($fieldDef['required'])) {
					$values[$field] = $this->massageValue($val, $fieldDef);
				}
			}
		}

		if (empty($values))
			return $execute?true:''; // no columns set

		// get the entire sql
		$query = "INSERT INTO $table (".implode(",", array_keys($values)).")
					VALUES (".implode(",", $values).")";
		return $execute?$this->query($query):$query;
	}

	// TODO: Make the below function work inside the insert part
	// TODO: add a field def array to the model possibly from a vardefs.php file
	/**
	 * Generates SQL for update statement.
	 *
	 * @param  SugarBean $bean SugarBean instance
	 * @param  array  $where Optional, where conditions in an array
	 * @return string SQL Create Table statement
	 */
	public function updateSQL(SugarBean $bean, array $where = array())
	{
		$primaryField = $bean->getPrimaryFieldDefinition();
		$columns = array();
		$fields = $bean->getFieldDefinitions();
		// get column names and values
		foreach ($fields as $field => $fieldDef) {
			if (isset($fieldDef['source']) && $fieldDef['source'] != 'db')  continue;
			// Do not write out the id field on the update statement.
			// We are not allowed to change ids.
			if ($fieldDef['name'] == $primaryField['name']) continue;

			// If the field is an auto_increment field, then we shouldn't be setting it.  This was added
			// specially for Bugs and Cases which have a number associated with them.
			if (!empty($bean->field_name_map[$field]['auto_increment'])) continue;

			//custom fields handle their save separately
			if(isset($bean->field_name_map) && !empty($bean->field_name_map[$field]['custom_type']))  continue;

			// no need to clear deleted since we only update not deleted records anyway
			if($fieldDef['name'] == 'deleted' && empty($bean->deleted)) continue;

			if(isset($bean->$field)) {
				$val = from_html($bean->$field);
			} else {
				continue;
			}

			if(!empty($fieldDef['type']) && $fieldDef['type'] == 'bool'){
				$val = $bean->getFieldValue($field);
			}

			if(strlen($val) == 0) {
				if(isset($fieldDef['default']) && strlen($fieldDef['default']) > 0) {
					$val = $fieldDef['default'];
				} else {
					$val = null;
				}
			}

			if(!empty($val) && !empty($fieldDef['len']) && strlen($val) > $fieldDef['len']) {
				$val = $this->truncate($val, $fieldDef['len']);
			}

			if(!is_null($val) || !empty($fieldDef['required'])) {
				$columns[] = "{$fieldDef['name']}=".$this->massageValue($val, $fieldDef);
			} elseif($this->isNullable($fieldDef)) {
				$columns[] = "{$fieldDef['name']}=NULL";
			} else {
				$columns[] = "{$fieldDef['name']}=".$this->emptyValue($fieldDef['type']);
			}
		}

		if ( sizeof($columns) == 0 )
			return ""; // no columns set

		// build where clause
		$where = $this->getWhereClause($bean, $this->updateWhereArray($bean, $where));
		if(isset($fields['deleted'])) {
			$where .= " AND deleted=0";
		}

		return "UPDATE ".$bean->getTableName()."
					SET ".implode(",", $columns)."
					$where";
	}












	function oldsave(){
	    $query = "INSERT INTO matches (id,name) VALUES (1,'Amy')";
		////$db->query($query);
    }

	function getMatches(){

        return self::makeData();//Db::all("select * from items");
    
    }

    function makeData(){
        $names = array('marie', 'cecile', 'cathy', 'nico', 'paul', 'tom', 'charlie', 'sam' );
        $return = array();
        for($i=0; $i<155;$i++)
            $return[] = array('nom'=>$names[$i%8], 'age'=>rand(20, 40));
        return $return;
    }
    
}
