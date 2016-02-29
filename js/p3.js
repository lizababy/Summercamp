
function isEmpty(fieldValue) {
        return $.trim(fieldValue).length === 0;    
        } 
        
function isValidState(state) {                                
        var stateList = new Array("AK","AL","AR","AZ","CA","CO","CT","DC",
        "DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA",
        "MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ",
        "NM","NV","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX",
        "UT","VA","VT","WA","WI","WV","WY");
        for(var i=0; i < stateList.length; i++) 
            if(stateList[i] === $.trim(state))
                return true;
        return false;
        }  
        
    // copied from stackoverflow.com.        
function isValidEmail(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
        }
    // copied from stackoverflow.com.        
function isValidImage(file_name){
    var image_field_ext = file_name.split('.').pop().toLowerCase();

    return !($.inArray(image_field_ext, ['gif','png','jpg','jpeg']) == -1);
}
function isValidAge(bday){
        
    var min = Date.parse("06/01/2000");
    var max = Date.parse("06/01/2009");
    var bdate = Date.parse(bday);
    
    var bdayArray = bday.split('/');
    
    var month = bdayArray[0];
    var day = bdayArray[1];
    var year = bdayArray[2];
    
    // now turn the three values into a Date object and check them
    var checkDate = new Date(year, month-1, day);    
    var checkDay = checkDate.getDate();
    var checkMonth = checkDate.getMonth()+1;
    var checkYear = checkDate.getFullYear();
    if(day == checkDay && month == checkMonth && year == checkYear)
        return (bdate >=min && bdate <= max);
    else
        alert("Invalid Date");
        return false;       
        
    
    
}

$(function() {
    $( '#datepicker' ).datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: '06/01/2000', 
        maxDate: '06/01/2009' 
});
    $( "#datepicker" ).datepicker();
  });
function handleData(response){
    
    if(response.startsWith("DUP")) 
        $('#status').text("This record appears to be a duplicate.");
        
    else if(response.startsWith("OK")) {
        $('#status').text("Please Wait..."); 
       $('#signUpForm').serialize();
       $('#signUpForm').submit();        
        }
    $('#busy_wait').css('visibility','hidden');
    
    

    }        

$(document).ready(function() {
    
    var errorStatusHandle = $('#message_line');
    var elementHandle = new Array(17);
    elementHandle[0] = $('[name="cfname"]');
    elementHandle[1] = $('[name="clname"]');
    
    elementHandle[2] = $('[name="bday"]');
    elementHandle[3] = $('[name="emname"]');

    elementHandle[4] = $('[name="em_area_phone"]');
    elementHandle[5] = $('[name="em_prefix_phone"]');
    elementHandle[6] = $('[name="em_phone"]');
    
    elementHandle[7] = $('[name="pfname"]');
    elementHandle[8] = $('[name="plname"]');
    elementHandle[9] = $('[name="address"]');
    elementHandle[10] = $('[name="city"]');
    elementHandle[11] = $('[name="state"]');
    elementHandle[12] = $('[name="zipcode"]');
    
    elementHandle[13] = $('[name="h_area_phone"]');
    elementHandle[14] = $('[name="h_prefix_phone"]');
    elementHandle[15] = $('[name="h_phone"]');
    elementHandle[16] = $('[name="email"]');
    var elementRadio = $('[name="gender"]');
    var selectionHandle =$('[name="relationship"]');
    var checkBoxHandle =$('[name="cbox[]"]');
    var imageHandle = $('#image');
    
    var errorMessage = new Array(17);
    errorMessage[0] ="Please enter child's first name";
    errorMessage[1] = "Please enter child's last name";
    errorMessage[2] = "Please enter birthday of child";
    errorMessage[3] = "Please enter emergency contact name";
    
    errorMessage[4] = "Please enter area code for emergency contact number";
    errorMessage[5] = "Please enter prefix code for emergency contact number";
    errorMessage[6] = "Please enter emergency contact number";
    errorMessage[7] = "Please enter guardians first name";
    errorMessage[8] = "Please enter guardians last name";
    errorMessage[9] = "Please enter address";
    errorMessage[10] = "Please enter city";
    errorMessage[11] = "Please enter state";
    errorMessage[12] = "Please enter zipcode";
    
    errorMessage[13] = "Please enter home phone area code";
    errorMessage[14] = "Please enter home phone prefix ";
    errorMessage[15] = "Please enter home phone";
    errorMessage[16] = "Please enter email address";

    $('table#table1 tbody td:odd').addClass('add_border');
    $('table#table2 tbody td').addClass('add_border');
    $('table#table3 tbody td:even').addClass('add_border');
    $('table tbody tr:odd').addClass('odd');
    $('table tbody tr:even').addClass('even');

    /*
     ***********functions************
    */
   
    function isValidPhoneFormat(index){
            if(!$.isNumeric(elementHandle[4+index].val())) {
            elementHandle[4+index].addClass("error");
            errorStatusHandle.text("The area code appears to be invalid, "+
            "numbers only please. ");
            elementHandle[4+index].focus();            
            return false;
            }
        if(elementHandle[4+index].val().length !== 3) {
            elementHandle[4+index].addClass("error");
            errorStatusHandle.text("The area code must have exactly three digits");
            elementHandle[4+index].focus();            
            return false;
            }              
        if(!$.isNumeric(elementHandle[5+index].val())) {
            elementHandle[5+index].addClass("error");
            errorStatusHandle.text("The phone number prefix appears to be invalid, "+
            "numbers only please. ");
            elementHandle[5+index].focus();            
            return false;
            }
        if(elementHandle[5+index].val().length !== 3) {
            elementHandle[5+index].addClass("error");
            errorStatusHandle.text("The phone number prefix must have exactly three digits");
            elementHandle[5+index].focus();            
            return false;
            }          
        if(!$.isNumeric(elementHandle[6+index].val())) {
            elementHandle[6+index].addClass("error");
            errorStatusHandle.text("The phone number appears to be invalid, "+
            "numbers only please. ");
            elementHandle[6+index].focus();            
            return false;
            }
        if(elementHandle[6+index].val().length !== 4) {
            elementHandle[6+index].addClass("error");
            errorStatusHandle.text("The phone number must have exactly four digits");
            elementHandle[6+index].focus();            
            return false;
            }  
        
        return true;
    }
    
    function isValidData() {

        for(var i = 0; i<17; i++){
            if(isEmpty(elementHandle[i].val())) {
                elementHandle[i].addClass("error");
                errorStatusHandle.text(errorMessage[i]);
                elementHandle[i].focus();
                return false;
            } 
        }
        if(!isValidAge(elementHandle[2].val())){
            elementHandle[2].addClass("error");
            errorStatusHandle.text("Children with Age between 7 and 16 is only allowed to register");
            elementHandle[2].focus();
            return false;
        } 
     
        if(isEmpty(imageHandle.val())) {
                $('.image').addClass("error");
                errorStatusHandle.text("Please upload image of child");
                imageHandle.focus();
                return false;
        } 
        
        if(!isValidImage(imageHandle.val())) {
                $('.image').addClass("error");
                errorStatusHandle.text("invalid File format.Please select any of jpg,jpeg,gif,png");
                imageHandle.focus();
                return false;
            }
        if(!isValidPhoneFormat(0)){
           return false; 
        }
        if(!isValidState(elementHandle[11].val())) {
            elementHandle[11].addClass("error");
            errorStatusHandle.text("The state appears to be invalid, "+
            "please use the two letter state abbreviation");
            elementHandle[11].focus();            
            return false;
            }
            if(!$.isNumeric(elementHandle[12].val())) {
            elementHandle[12].addClass("error");
            errorStatusHandle.text("The zip code appears to be invalid, "+
            "numbers only please. ");
            elementHandle[12].focus();            
            return false;
            }
        if(elementHandle[12].val().length !== 5) {
            elementHandle[12].addClass("error");
            errorStatusHandle.text("The zip code must have exactly five digits");
            elementHandle[12].focus();            
            return false;
            }
        if(!isValidPhoneFormat(9)){
           return false; 
        };
        if(!isValidEmail(elementHandle[16].val())) {
            elementHandle[16].addClass("error");
            errorStatusHandle.text("The email address appears to be invalid");
            elementHandle[16].focus();            
            return false;
            }    
        if(!elementRadio.is(":checked")){
            $(".gender").addClass("error");
            errorStatusHandle.text("Please enter child's gender");
            elementRadio.focus();
            return false;
        }
        if(selectionHandle.val() === "error"){
             selectionHandle.addClass("error");
             errorStatusHandle.text("Please select the relationship with the child");
             selectionHandle.focus();
             return false;
         }
         if(! checkBoxHandle.is(":checked")){
             $('table tr.program').addClass("error");
             errorStatusHandle.text("Please select atleast one program");
             checkBoxHandle.focus();
             return false;
         }
        
        return true;

    }
    
   function addBlurHandler(index){
       elementHandle[index].on('blur',function(){
            if(isEmpty(elementHandle[index].val())){
                return;
            }
            elementHandle[index].removeClass("error");
            errorStatusHandle.text("");
        });
   }
    
    elementHandle[0].focus();
    
    /*
     ***********Handlers************
    */
   for(var i=0; i < 17 ; i++){
       addBlurHandler(i);
   }
    elementHandle[11].on('keyup', function() {
        elementHandle[11].val(elementHandle[11].val().toUpperCase());
        });
    elementHandle[2].on('change', function() {
        
        if(isValidAge(elementHandle[2].val())){
           
            elementHandle[2].removeClass("error");
            errorStatusHandle.text("");  
        }else{
            alert("Children with Age between 7 and 16 is only allowed to register");
            elementHandle[2].addClass("error");
            errorStatusHandle.text("Children with Age between 7 and 16 is only allowed to register"); 
        }
    });    
    elementHandle[4].on('keyup', function() {
        if(elementHandle[4].val().length == 3)
            elementHandle[5].focus();
            });
            
    elementHandle[5].on('keyup', function() {
        if(elementHandle[5].val().length == 3)
            elementHandle[6].focus();
            });  
    
    elementHandle[13].on('keyup', function() {
        if(elementHandle[13].val().length == 3)
            elementHandle[14].focus();
            });
            
    elementHandle[14].on('keyup', function() {
        if(elementHandle[14].val().length == 3)
            elementHandle[15].focus();
            });
    imageHandle.on('change', function() {
        if(isValidImage(imageHandle.val())) {
             $('.image').removeClass("error");
            errorStatusHandle.text("");
        }
    });
    selectionHandle.on('click',function(){
       if(selectionHandle.val() !== "error"){
             selectionHandle.removeClass("error");
             errorStatusHandle.text("");
         }
   });
   elementRadio.on('click',function(){
      if(elementRadio.is(":checked")){
            $(".gender").removeClass("error");
            errorStatusHandle.text("");
        }
   });
   checkBoxHandle.on('click',function(){

      if(checkBoxHandle.is(":checked")){
            $('table tr.program').removeClass("error");
            errorStatusHandle.text("");
        }
   });
   
    $('#send_data').on('click',function(){
        
        for(var i = 0; i< 17 ; i++){
            elementHandle[i].removeClass("error");
        }
        
        errorStatusHandle.text("");
        if (isValidData()){
            var data = $('#signUpForm').serialize();
             $.post("check_dup.php", data, handleData);
             $('#busy_wait').css('visibility','visible');
       
        }
    });
    
    $(':reset').on('click',function(){
        for(var i = 0; i< 17 ; i++){
            elementHandle[i].removeClass("error");
        }
         $('.image').removeClass("error");
         $(".gender").removeClass("error");
         $('table tr.program').removeClass("error");
         selectionHandle.removeClass("error");

        errorStatusHandle.text("");
    });
});
