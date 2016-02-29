<?php


    ########################################################
    # DO NOT USE jadrn000, DO NOT MODIFY jadnr000 DATABASE!
    ########################################################            
    $server = 'opatija.sdsu.edu:3306';
    $user = 'jadrn007';
    $password = 'floor';
    $database = 'jadrn007';   
    ########################################################
        
    if(!($db = mysqli_connect($server, $user, $password, $database))) {
        die('SQL ERROR: Connection failed: '.mysqli_error($db));
        }        
   
        $sql = "SELECT id, description FROM program;";

   
        if(!($result = mysqli_query($db, $sql))) {
            die('SQL ERROR: '. mysqli_error($db));
          } #end if 

        while($row = mysqli_fetch_array($result)) {
            echo "The record is: ",$row[0],"\t",$row[1],"\n";
      	    }
	    
	echo "\nNow using the like filter to do a different query\n\n";	    

        $sql = "SELECT id, description FROM program WHERE description LIKE '%ball%';";

   
        if(!($result = mysqli_query($db, $sql))) {
            die('SQL ERROR: '. mysqli_error($db));
          } #end if 

        while($row = mysqli_fetch_array($result)) {
            echo "The record is: ",$row[0],"\t",$row[1],"\n";
      	    }	
            
    mysqli_free_result($result);    # free the result set  
    mysqli_close($db);              #don't forget to close the DB!
?> 
    
