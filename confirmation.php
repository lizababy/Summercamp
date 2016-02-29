
<?php
include_once('helpers.php');
echo '
    <table>
        <tr>
            <td>Child First Name:</td>
            <td>', $params[13], '</td>
        </tr>
        <tr>
            <td>Child Last Name:</td>
            <td>', $params[14], '</td>
        </tr>
        
        <tr>
            <td>Primary Phone Number:</td>
            <td>' ,$params[9] ,'</td>
        </tr>
        <tr>
            <td>email:</td>
            <td>' , $params[11], '</td>
        </tr>           
    </table> <h1>',$params[0] ," ", $params[1], ', thank you for registering your child!</h1>';

   
write_footer();
?>

