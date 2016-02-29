<?php       

     ########################################################            
    $server = 'opatija.sdsu.edu:3306';
    $user = 'jadrn007';
    $password = 'floor';
    $database = 'jadrn007';   
    ########################################################
    
    $values = array( 
    1 => 'Basketball Camp',
    2 => 'Baseball Camp',
    3 => 'Physical Training',
    4 => 'Band Camp',
    5 => 'Swimming',
    6 => 'Nature Discovery');       
        
    if(!($db = mysqli_connect($server, $user, $password, $database))) {
        die('SQL ERROR: Connection failed: '.mysqli_error($db));
        }     
    

    foreach($values as $k => $v) {    
        $sql = "INSERT INTO program VALUES($k,'$v');\n";
        
#        echo "The sql statement is:\n$sql\n"; 
   
        if(!($result = mysqli_query($db, $sql))) {
            die('SQL ERROR: '. mysqli_error($db));
        } #end if 
   } #end foreach
   
    mysqli_close($db); #don't forget to close the DB!
?> 


