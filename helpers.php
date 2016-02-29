<?php

$bad_chars = array('$','%','?','<','>','php');

function check_post_only() {
if(!$_POST) {
    write_error_page("This scripts can only be called from a form.");
    exit;
    }
}

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

function write_error_page($msg) {
    write_header();
    echo "<h2>Sorry, an error occurred<br />",
    $msg,"</h2>";
    write_footer();
    }
    
function write_header() {
print <<<ENDBLOCK
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link rel="stylesheet" href="css/proj3.css">
    <!-- css for date picker; from :http://jqueryui.com/datepicker/-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <script type="text/javascript" src="http://jadran.sdsu.edu/jquery/jquery.js"></script>
    
    <!-- script for date picker; from :http://jqueryui.com/datepicker/-->
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
    
    
    <script type="text/javascript" src="js/p3.js"></script>
    
</head>
<body>
    <div id="navigation">
        <div id ="navigation-left">
            <span class="brand"><b>Happy Days </b></span><br>Summer Camp

        </div>
        <div id ="navigation-right">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="signup.html">Sign Up</a></li>
            </ul>
        </div>
    </div>
    <div id="main_content">   
ENDBLOCK;
}

function write_footer() {
    echo "</div></body></html>";
}
    
?>
