<?php
 $UPLOAD_DIR = 'img_p3';
 $COMPUTER_DIR = '/home/jadrn007/public_html/proj3/img_p3/';
  
function validate_data($params) {
    $msg = "";
    if(strlen($params[0]) == 0)
        $msg .= "Please enter the primary parents first name<br />";  
    if(strlen($params[1]) == 0)
        $msg .= "Please enter the primary parents last name<br />";  
    if($params[3] == "error")
        $msg .= "Please select the relationship with child<br />";  

    if(strlen($params[4]) == 0)
        $msg .= "Please enter the address<br />"; 
    if(strlen($params[6]) == 0)
        $msg .= "Please enter the city<br />"; 
    if(strlen($params[7]) == 0)
        $msg .= "Please enter the state<br />";   
    elseif(!isValidState($params[7])) {
        $msg .= "Invalid state <br/>";
    }
    if(strlen($params[8]) == 0)
        $msg .= "Please enter the zip code<br />";
    elseif(!is_numeric($params[8])) 
        $msg .= "Zip code may contain only numeric digits<br />";
    elseif (strlen($params[8]) != 5) 
        $msg .= "Zip code may contain exactly 5 digits<br/>";
    
    if(strlen($params[9]) == 0 ){
        $msg .= "Please enter a valid Home Phone number<br/>";
    }elseif (!is_numeric($params[9])) {
        $msg .= "Home Phone nuuber may contain only numeric digits<br/>";
    }elseif (strlen($params[9]) != 10) {
        $msg .= "Home Phone number should match exactly 10 digits<br/>";
    }
    if(strlen($params[10]) > 0 ){
        if (!is_numeric($params[10])) {
            $msg .= "Cell Phone number may contain only numeric digits<br/>";
        }elseif (strlen($params[10]) != 10) {
            $msg .= "Cell Phone number should match exactly 10 digits<br/>";
        }
    }
    
    if(strlen($params[11]) == 0)
        $msg .= "Please enter email<br />";
    elseif(!filter_var($params[11], FILTER_VALIDATE_EMAIL))
        $msg .= "Your email appears to be invalid<br/>";    
    
    if(count($params[12]) == 0 )
        $msg .= "Please select atleast one program<br />";
 
    if(strlen($params[13]) == 0)
        $msg .= "Please enter childs first name<br />";  
    if(strlen($params[14]) == 0)
        $msg .= "Please enter childs last name<br />"; 
    if(strlen($params[15]) == 0)
        $msg .= "Please enter childs birthday<br />";  
    if(strlen($params[16]) == 0 ){
        $msg .= "Please enter a valid emergency Phone number<br/>";
    }elseif (!is_numeric($params[16])) {
        $msg .= "Emergency Phone number may contain only numeric digits<br/>";
    }elseif (strlen($params[16]) != 10) {
        $msg .= "Emergency Phone number should match exactly 10 digits<br/>";
    }
    if(strlen($params[17]) == 0)
        $msg .= "Please enter childs emergency contact name<br />";  
    
    if($params[18] == "error")
        $msg .= "Please select childs gender<br />";
    if(empty($params[23]))
        $msg .= "Please select childs image<br />";
    else{
        global $UPLOAD_DIR;
        if(file_exists("$UPLOAD_DIR/".$params[23]))  {
            $msg .= "The photo $params[23] already exists, Please select another image or rename. <br />";
        }
        elseif($_FILES['image']['error'] > 0) {
            $err = $_FILES['image']['error'];	
            $msg .= "Error Code: $err <br />";
            if($err == 1)
                    $msg .= "The file was too big to upload, the limit is 2MB<br />";
        } 
        elseif(exif_imagetype($_FILES['image']['tmp_name']) != IMAGETYPE_JPEG) {
             $msg .= "ERROR, not a jpg file<br />";   
        }
    }
       
    
    if($msg) {
        write_form_error_page($msg);
        exit;
        }
    }
  
function write_form_error_page($msg) {
    write_header();
    echo "<h2>Sorry, an error occurred<br />",
    $msg,"</h2>";
    write_form();
    write_footer();
    }  
function isValidState($state) {                                
    $stateList = ["AK","AL","AR","AZ","CA","CO","CT","DC",
        "DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA",
        "MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ",
        "NM","NV","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX",
        "UT","VA","VT","WA","WI","WV","WY"];
    for($i=0; $i < count($stateList); $i++) {
        if($stateList[$i] === $state)
            return true;
    }
    return false;
}   

function selected($value){
    if ($_POST['relationship']== $value){
        return 'selected';
    }
}

function radioChecked($name, $value){
    if (isset($_POST[$name])){
        if ($_POST[$name] == $value){
            return 'checked';
        }
    }
}
function checkboxChecked($name,$position, $value){
    if (isset($_POST['cbox'])){
        foreach ($_POST['cbox'] as $checked) {
            if($checked == $value){
                return 'checked';
            }
        }
    }
}

function write_form() {
    
    $selected = 'selected';
    $radioChecked = 'radioChecked';
    $checkboxChecked = 'checkboxChecked';
    
    print <<<ENDBLOCK
        <h1>Registration</h1>
        <form  method ="post" action="process_request.php" enctype="multipart/form-data" id="signUpForm">
            <fieldset>
            <legend>Child Info</legend>
            <table id="table1">
                    <tbody>
                        <tr>
                            <td class="required"><label>First Name:</label></td>
                            <td ><input type="text" name="cfname" value="$_POST[cfname]"size="30"></td>
                            
                            <td class="required"><label>Last Name:</label></td>
                            <td><input type="text" name="clname" value="$_POST[clname]" size="30"></td>
                            
                            <td><label for="mname">Middle Name:</label></td>
                            <td><input type="text" name="cmname" value="$_POST[cmname]" size="30"></td>
                        </tr>
                        
                        <tr>
                            <td class="required"><label for="datepicker">Date of Birth:</label></td>
                            <td><input type="text" name ="bday" id="datepicker" value="$_POST[bday]" placeholder="mm/dd/yyyy" size="10"></td>
                            
                            <td><label>Name goes by:</label></td>
                            <td ><input type="text" name="callname" value="$_POST[callname]" size="30"></td>
                        </tr>
                        <tr>
                            <td class="required"><label>Gender:</label></td>
                            <td class="gender"><input type="radio" name="gender" value="M" {$radioChecked("gender","M")} >Male &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" value="F"  {$radioChecked("gender","F")} >Female</td>
                                                                                 
                            <td class="required"><label> Upload image of child:</label></td>
                            <td class="image"><input type = "file" name= "image" id="image"></td>
                        </tr>
                        <tr>
                            <td><label>Medical conditions:</label></td>
                            <td colspan="3"><textarea name="mcondition" value="$_POST[mcondition]" cols="68" rows="5"></textarea></td>
                        </tr>
                        <tr>
                            <td><label>Special Dietary Requirements:</label></td>
                            <td colspan="3"><textarea name="mdiet" value="$_POST[mdiet]" cols="68" rows="5"></textarea></td>
                        </tr>
                        <tr class="white">
                            <td colspan="3">Secondary Emergency Contact :-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="required"><label>Name:</label></td>
                            <td><input type="text" name="emname" value="$_POST[emname]" size="30"></td>
                            
                            <td class="required"><label>Phone number:</label></td>
                            <td>(<input type="text" name="em_area_phone" value="$_POST[em_area_phone]" size="3" maxlength="3" />)  &nbsp;&nbsp;
                                <input type="text" name="em_prefix_phone"  value="$_POST[em_prefix_phone]" size="3" maxlength="3" /> &nbsp;-&nbsp;
                                <input type="text" name="em_phone" size="4" value="$_POST[em_phone]" maxlength="4" />
                            </td>
                        </tr>
                    </tbody>
                      
                </table>
        </fieldset>
        <fieldset>
            <legend>Programs</legend>
            <table id="table2">
                <tbody>
                    <tr class="white">
                        <td class="required" colspan="2"><label> Select at least one program:</label></td>
                    </tr>
                
                    <tr class="odd program">
                        <td><input type="checkbox" name ="cbox[]" value=1 {$checkboxChecked("cbox",0,1)}>Basketball Camp </td>
                        <td><input type="checkbox" name ="cbox[]" value=2 {$checkboxChecked("cbox",1,2)}>Baseball Camp </td>
                        <td><input type="checkbox" name ="cbox[]" value=3 {$checkboxChecked("cbox",2,3)}>Physical Training </td>
                        <td><input type="checkbox" name ="cbox[]" value=4 {$checkboxChecked("cbox",3,4)}>Band Camp </td>
                        <td><input type="checkbox" name ="cbox[]" value=5 {$checkboxChecked("cbox",4,5)}>Swimming </td>
                        <td><input type="checkbox" name ="cbox[]" value=6 {$checkboxChecked("cbox",5,6)} >Nature Discovery </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <fieldset>
            <legend>Parent Info</legend>
            
            <table id="table3">
                <tbody>
                    <tr class="white">
                        <td colspan="3">Parent or primary guardian :-</td>
                    </tr>
                    <tr>
                        <td class="required"> <label>First Name:</label></td>
                        <td><input type="text" name="pfname" value="$_POST[pfname]" size="30"></td>
                        <td class="required"><label>Last Name:</label></td>
                        <td colspan="2"><input type="text" name="plname" value="$_POST[plname]" size="30"></td>
                        <td><label>Middle Name:</label></td>
                        <td><input type="text" name="pmname" value="$_POST[pmname]" size="30"></td>
                    </tr>
                    <tr>
                        <td class="required"><label>Relationship to child:</label></td>
                        <td><select name="relationship">
                                <option selected value="error">---select relationship---</option>
                                <option {$selected("Father")} value="Father"> Father</option>
                                <option {$selected("Mother")} value="Mother"> Mother</option>
                                <option {$selected("Guardian")} value="Guardian"> Guardian</option>
                            </select></td>
                        
                    </tr>
                    <tr>
                        <td class="required"><label>Address:</label></td>
                        <td colspan="3"><input type="text" name="address" value="$_POST[address]" size="30">
                        <input type="text" name="address2" value="$_POST[address2]" size="15"></td>
                    </tr>
                    <tr>
                        <td class="required"><label>City:</label></td>
                        <td><input type="text" name="city" value="$_POST[city]" size="30"></td>
                        
                        <td class="required"><label>State:</label></td>
                        <td><input type="text" name="state" value="$_POST[state]" placeholder="XX" size="2"></td>
                        
                        <td class="required"><label>Zip code:</label></td>
                        <td><input type="text" name="zipcode" value="$_POST[zipcode]" size="5"></td>
                    </tr>
                    <tr>
                        <td class="required"><label>Home phone:</label></td>
                        <td>(<input type="text" name="h_area_phone" value="$_POST[h_area_phone]"  size="3" maxlength="3" />)&nbsp;
                                <input type="text" name="h_prefix_phone" value="$_POST[h_prefix_phone]" size="3" maxlength="3" />-&nbsp;
                                <input type="text" name="h_phone" value="$_POST[h_phone]" size="4" maxlength="4" />
                        </td>
                        
                        <td><label>Cell phone:</label></td>
                        <td colspan="2">(<input type="text" name="c_area_phone" value="$_POST[c_area_phone]" size="3" maxlength="3" />)&nbsp;
                                <input type="text" name="c_prefix_phone" size="3" value="$_POST[c_prefix_phone]" maxlength="3" />-&nbsp;
                                <input type="text" name="c_phone" value="$_POST[c_phone]" size="4" maxlength="4" />
                        </td>
                    </tr>
                    <tr>
                        <td class="required"><label>Email address:</label></td>
                        <td><input type="text" name="email" value="$_POST[email]" size="30"></td>
                    </tr>
                </tbody>
                
            </table>
        </fieldset>
                
        <div id="button_panel">  
             <p id="errorMessage"></p>    
                <input type="reset" value="Reset" class="button" />
                <input type="button" value="Submit"  id = "send_data" class="button" /> 
                <h2 id="status"></h2>
                   <img id="busy_wait" src="loading.gif" />
        </div> 
    </form>
      
ENDBLOCK;
}                        


function process_parameters() {
    global $bad_chars;
    $params = array();
    /*0*/$params[] = trim(str_replace($bad_chars, "",$_POST['pfname']));
    /*1*/$params[] = trim(str_replace($bad_chars, "",$_POST['plname']));
    
    /*2*/$params[] = trim(str_replace($bad_chars, "",$_POST['pmname']));
    
    /*3*/$params[] = $_POST['relationship'];
    /*4*/$params[] = trim(str_replace($bad_chars, "",$_POST['address']));
    
    /*5*/$params[] = trim(str_replace($bad_chars, "",$_POST['address2']));
    /*6*/$params[] = trim(str_replace($bad_chars, "",$_POST['city']));
    /*7*/$params[] = trim(str_replace($bad_chars, "",$_POST['state']));
    /*8*/$params[] = trim(str_replace($bad_chars, "",$_POST['zipcode']));
    /*9*/$params[] = trim(str_replace($bad_chars, "",$_POST['h_area_phone'] . $_POST['h_prefix_phone'] . $_POST['h_phone']));
    /*10*/$params[] = trim(str_replace($bad_chars, "",$_POST['c_area_phone'] . $_POST['c_prefix_phone'] . $_POST['c_phone']));
    /*11*/$params[] = trim(str_replace($bad_chars, "",$_POST['email']));
    
    /*12*/$params[] = $_POST['cbox'];
   
    /*13*/$params[] = trim(str_replace($bad_chars, "",$_POST['cfname']));
    /*14*/$params[] = trim(str_replace($bad_chars, "",$_POST['clname']));
    /*15*/$params[] = trim(str_replace($bad_chars, "",$_POST['bday']));
    /*16*/$params[] = trim(str_replace($bad_chars, "",$_POST['em_area_phone'] . $_POST['em_prefix_phone'] . $_POST['em_phone']));
    /*17*/$params[] = trim(str_replace($bad_chars, "",$_POST['emname']));
    /*18*/$params[] = isset($_POST['gender'])?  $_POST['gender'] : "error";
     /*19*/$params[] = trim(str_replace($bad_chars, "",$_POST['callname']));
    /*20*/$params[] = trim(str_replace($bad_chars, "",$_POST['cmname']));
    /*21*/$params[] = trim(str_replace($bad_chars, "",$_POST['mdiet']));
    /*22*/$params[] = trim(str_replace($bad_chars, "",$_POST['mcondition']));
    /*23*/$params[] = $_FILES['image']['name'] ;
 
    
    return $params;
}
    
function store_data_in_db($params) {
    
    
    write_header();
    
    $db = get_db_handle();
    /*Parent table*/
    $sql = "select id from parent where ".
    "primary_phone='$params[9]' or ".
    "email='$params[11]';";
    $result = mysqli_query($db, $sql);
    $parent_id = 0;
    if(mysqli_num_rows($result) == 1) { //parent already exists ; so retreive the parent id
        $row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
        $parent_id = $row['id'];
        
    }else if (mysqli_num_rows($result) == 0) {//parent not a dup
        $sql = "insert into parent(first_name,last_name,middle_name,address1,address2,city,state,zip,primary_phone,secondary_phone,email) ".   
            "values('$params[0]','$params[1]','$params[2]','$params[4]','$params[5]','$params[6]','$params[7]','$params[8]','$params[9]','$params[10]','$params[11]');";
        mysqli_query($db,$sql);
        $how_many = mysqli_affected_rows($db);
        if($how_many == 1) {
       
           // success parent inserted 
            $parent_id = mysqli_insert_id($db);
        }else{
            //Can't insert parent due to error
            write_footer();
            exit;
        }
    }else{
        //more than 1 duplicate parent exists
        write_footer();
        exit;
    }
    /*Child table*/
     $sql = "select id from child where ".
            "parent_id= $parent_id and ".
            "first_name='$params[13]' and ".
            "last_name='$params[14]';";
    $result = mysqli_query($db, $sql);
    $child_id = 0;
    if(mysqli_num_rows($result) == 1) { //child already exists ; so retreive the child id
        $row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
        $child_id = $row['id'];
        
    }else if (mysqli_num_rows($result) == 0) {//child not a dup
       $tempDate = explode('/',$params[15]);
       $date = $tempDate[2].'-'.$tempDate[0].'-'.$tempDate[1];
        $sql = "insert into child(parent_id,relation,first_name,middle_name,last_name,nickname,image_filename,gender,birthdate,conditions,diet,emergency_name,emergency_phone) ".   
                    "values($parent_id,'$params[3]','$params[13]','$params[20]','$params[14]','$params[19]','$params[23]','$params[18]','$date','$params[22]','$params[21]','$params[17]','$params[16]');";

        mysqli_query($db,$sql);
        $how_many = mysqli_affected_rows($db);
        if($how_many == 1) {
       
            $child_id = mysqli_insert_id($db);
           //success child inserted 
            
            ## Image file is valid, copy from /tmp to image directory. 
            global $UPLOAD_DIR;
            move_uploaded_file($_FILES['image']['tmp_name'], "$UPLOAD_DIR/".$params[23]);  
            echo "<img src=\"$UPLOAD_DIR/$params[23]\""." width='200px' />\n";

        }else{
           //Can't insert child due to error
            write_footer();
            exit;
        }
    }else{
       // More than 1 duplicate child exists
        write_footer();
        exit;
    }
   /* Enrollment table*/
   foreach ($params[12] as $program_id) {
       
       // get program description
        $sql = "select description from program where ".
                    "id= $program_id;";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
        $description = $row['description'];
        
        //check previous enrollment details   
        $sql = "select * from enrollment where ".
            "child_id = $child_id and ".
            "program_id= $program_id;";
        $result = mysqli_query($db, $sql);
  
        if(mysqli_num_rows($result) == 1) { //Enrollment already exists 
            echo "<h2>Already enrolled for $description</h2>";
        
        }else if (mysqli_num_rows($result) == 0) {//enrollment not a dup
             $sql = "insert into enrollment(child_id,program_id) ".   
                    "values($child_id,$program_id);";
             
            mysqli_query($db,$sql);
            $how_many = mysqli_affected_rows($db);
            if($how_many == 1) {
                echo "<h2>Successfully Enrolled for $description</h2>";
            }else{
                //Can't enroll due to error
                echo mysqli_error($db);
                write_footer();
                exit;
            }
        }else{
            //More than 1 duplicate enrollment exists
            write_footer();
            exit;
        }
   }
             
    mysqli_close($db);
}    
?>   
