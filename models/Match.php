<?php

class Match{

    var $db;
	var $season;
	var $datetime;
	var $code;
	var $grade;
	var $type;
	var $competition;
	var $team1;
	var $score1;
	var $team2;
	var $score2;
	var $venue;
	var $address;
	var $referee;
	var $county;
	var $club;

	function __construct()
    {
		$this->db = new ez_sql();
    }

	function save(){
	    $query = "INSERT INTO matches (id,name) VALUES (1,'Amy')";
		$db->query($query);
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
