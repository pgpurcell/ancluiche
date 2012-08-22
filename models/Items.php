<?php

class Items{

    function getItems(){

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
