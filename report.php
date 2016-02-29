<?php

include_once('helpers.php');

function get_current_age($birth_date) {
    $dob = new DateTime($birth_date);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y;
    }
    
write_header();
$db = get_db_handle();
 // Fetch and print all the records....

        
echo 
'<h1>Report</h1>';
$sql = "SELECT id, description FROM program;";
if(!($result_program = mysqli_query($db, $sql))) {
    die('SQL ERROR: '. mysqli_error($db));
} #end if
$sql = "SELECT COUNT(*) AS total_child_count FROM enrollment;";
 if(!($result_count = mysqli_query($db, $sql))) {
        die('SQL ERROR: '. mysqli_error($db));
    }
    $row_count = mysqli_fetch_array($result_count,MYSQLI_ASSOC);
    echo '<h5>Total enrollment count :', $row_count['total_child_count'],'</h5>';

while($row_program = mysqli_fetch_array($result_program,MYSQLI_ASSOC)) {
    
    echo '<h3>'.$row_program['description'].'</h3>'
    . '<div id ="camp_report">';
    
    $sql = "SELECT child.parent_id, child.id, child.first_name, child.last_name, child.nickname,child.gender,child.birthdate,"
            . "child.image_filename, child.emergency_name, child.emergency_phone FROM child INNER JOIN "
            . "enrollment ON enrollment.child_id = child.id WHERE enrollment.program_id =". $row_program['id'].";";
    if(!($result_child = mysqli_query($db, $sql))) {
        die('SQL ERROR: '. mysqli_error($db));
    }   
    $sql = "SELECT COUNT(child_id) AS child_count FROM enrollment WHERE program_id =". $row_program['id'].";";
    if(!($result_count = mysqli_query($db, $sql))) {
        die('SQL ERROR: '. mysqli_error($db));
    }
    $row_count = mysqli_fetch_array($result_count,MYSQLI_ASSOC);
    echo '<h5>Total enrollment for this camp :', $row_count['child_count'],'</h5>';
    if ($row_count['child_count'] > 0){
        echo '

        <table class = "report_table">
            <thead>
                <tr>
                      <th>ID</th>
                      <th>Child Photo</th>

                      <th>Child Info</th>
                      <th>Parent Info</th>
                      <th>Emergency Contact</th>
                </tr>    
            </thead>

            <tbody>';
    }
while($row_child = mysqli_fetch_array($result_child,MYSQLI_ASSOC)) {
    $sql = "SELECT first_name, last_name, primary_phone, email FROM parent WHERE id =".$row_child['parent_id'].";";
    if(!($result_parent = mysqli_query($db, $sql))) {
        die('SQL ERROR: '. mysqli_error($db));
    }  
    $row_parent = mysqli_fetch_array($result_parent,MYSQLI_ASSOC);
    echo '<tr>
               <td>'.$row_child['id'].'</td>
               <td> <img src="',"img_p3/".$row_child['image_filename'], '" alt="',$row_child['image_filename'],'" width = 150px ></td>

               <td><ul>
                    <li><span>First name</span>: '.$row_child['first_name'].'</li>
                    <li><span>Last name</span>: '.$row_child['last_name'].'</li>
                    <li><span>Preferred name</span>: '.$row_child['nickname'].'</li>
                    <li><span>Gender</span>: '.$row_child['gender'].'</li>
                    <li><span>Age</span>: '.get_current_age($row_child['birthdate']).'</li></ul></td>
               <td><ul>
                    <li><span>First name</span>: '.$row_parent['first_name'].'</li>
                    <li><span>Last name</span>: '.$row_parent['last_name'].'</li>
                    <li><span>Primary phone</span>: '.$row_parent['primary_phone'].'</li>
                    <li><span>Email</span>: '.$row_parent['email'].'</li></ul></td>
               <td><ul>
                    <li><span>Name</span>: '.$row_child['emergency_name'].'</li>
                    <li><span>Phone number</span>: '.$row_child['emergency_phone'].'</li></ul></td>
           </tr>';
    }
    echo'
       </tbody>
    </table>
</div>';
}
 mysqli_close($db);
write_footer();
?>    
