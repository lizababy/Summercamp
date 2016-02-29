<?php

function get_db_handle() {
    $server = 'opatija.sdsu.edu:3306';
    $user = 'jadrn007';
    $password = 'floor';
    $database = 'jadrn007';
    
    if(!($db = mysqli_connect($server, $user, $password, $database))) {
        write_error_page("Cannot Connect!");
        }
    return $db;
    }
    
    $db = get_db_handle();
    $parent_id = 0;
    $parent_phone=$_POST['h_area_phone'].$_POST['h_prefix_phone'].$_POST['h_phone'];
    $parent_email = $_POST['email'];
    $sql = "SELECT id from parent where email='$parent_email' or primary_phone='$parent_phone';";
    $result = mysqli_query($db,$sql);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $parent_id = $row[0];
     
        }
        
    $child_id = 0;
    $cfname=$_POST['cfname'];
    $clname = $_POST['clname'];
    $sql = "SELECT id from child where parent_id=$parent_id and
    first_name='$cfname' and last_name='$clname';";
    
    $result = mysqli_query($db,$sql);
    if(mysqli_num_rows($result) >0) {
        $row = mysqli_fetch_array($result);
        $child_id = $row[0];
        }

    $enrollment = 0;
    $program=$_POST['cbox'];
    for($i = 0; $i < count($program); $i++) {
        $sql = "SELECT * from enrollment where program_id=$program[$i] and
        child_id=$child_id;";
       
        $result = mysqli_query($db,$sql);
        if(mysqli_num_rows($result) >0) {
            $row = mysqli_fetch_array($result);
            $enrollment = 1;
        }
    }
                
        
    if($parent_id && $child_id && $enrollment)
        echo "DUP";
    else{
        echo "OK";
    }
             
    mysqli_close($db);
    
?>    
