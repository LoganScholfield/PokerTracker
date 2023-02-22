<?php
include 'top.php';

//prints items from form
print '<p>Post Array:</p><pre>';
print_r($_POST);
print '</pre>';


//setting variables for later use 
$thisURL = DOMAIN . PHP_SELF;
$emailERROR = false;
$firstNameERROR = false;
$lastNameERROR = false;
$passwordERROR = false;
$errorMsg = array();
$mailed = false;

print $thisURL;

//setting variables for later use in custom made messages
$messageA = "";
$messageB = "";
$messageC = "";


// initialize variables
$email = '';
$firstName = '';
$lastName = '';
$password = '';


function verifyAlpha($testString) {
    return (preg_match("/^[\p{L} ]+$/u", $testString));
}

function getData($field){
    if (!isset($_POST[$field])){
        $data = "";
    }
    else{
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data, ENT_QUOTES);
    }
    return $data;
}


if (isset($_POST["btnSubmit"])) {

    //
    // SECTION: 2a Security
    // 
    // if (!securityCheck($thisURL)) {
    //     $msg = "<p>Sorry you cannot access this page. ";
    //     $msg.= "Security breach detected and reported.</p>";
    //     die($msg);
    // }
    
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

    $email = (string) getData('txtEmail');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);


    $firstName = (string) getData('txtFirstName');
    $lastName = (string) getData('txtLastName');
    $password = (string)getData('txtPassword');

    




    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.

    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }

    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name.";
        $firstNameERROR = true;
    } elseif (!verifyAlpha($firstName)) {
        $errorMsg[] = "Your first name appears to have invalid characters.";
        $firstNameERROR = true;
    }

    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name.";
        $lastNameERROR = true;
    } elseif (!verifyAlpha($lastName)) {
        $errorMsg[] = "Your last name appears to have invalid characters.";
        $lastNameERROR = true;
    }


    
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    print_r  ($errorMsg);
    if (empty($errorMsg)) {
        print 'message';
        if (DEBUG)
            print "<p>Form is valid</p>";
            


        //
        // SECTION: 2e Save Data
        //
        $primaryKey = $email;
        $dataEntered = false;
        $data = array();
        $query = 'INSERT INTO tblUserInfo SET pmkEmail = ?, fldFirstName = ?, fldLastName = ?, fldPassword = ? ';
        $data[] = $email;
        $data[] = $firstName;
        $data[] = $lastName;
        $data[] = $password;
        $dataEntered = $thisDatabaseWriter->insert($query, $data);
        print $dataEntered;
        if (DEBUG) {
            print "<p>sql " . $query;
            print"<p><pre>";
            print_r($data);
            print"</pre></p>";
        }

        
        // If the transaction was successful, we need to get date joined
        if ($dataEntered) {
            if (DEBUG)
                print "<p>Data entered now prepare keys ";

            // create a key value for confirmation

            $query = "SELECT fldDateJoined FROM tblUserInfo WHERE pmkEmail = ? ";
            $data2 = array($primaryKey);
           


            $results = $thisDatabaseReader->select($query, $data2);

            $dateSubmitted = $results[0]["fldDateJoined"];
            $key1 = password_hash($dateSubmitted, PASSWORD_DEFAULT);
            $key2 = $primaryKey;

            if (DEBUG) {
                print "<p>Date: " . $dateSubmitted;
                print "<p>key 1: " . $key1;
                print "<p>key 2: " . $key2;
            }
            
            //
            // SECTION: 2f Create message
            //
            // build a message to display on the screen in section 3a and to mail
            // to the person filling out the form (section 2g).
            //
            //Put forms information into a variable to print on the screen
            //
           
            $messageA = '<h2>Thank you for registering for Final Poker!</h2>';
            
            $messageA .= '<p>Please see the instructions below to finish your registration process.</p>';

            $messageB = "<p>Click this link to confirm your registration: ";
            $messageB .= '<a href="http:' . DOMAIN . PATH_PARTS["dirname"] . '/confirmationCode.php?q=' . $key1 . '&amp;w=' . $key2 . '">Confirm account creation</a></p>';
            $messageB .= 'http:' . DOMAIN . PATH_PARTS["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . "</p>";

            $messageC = "<h3>Your Information</h3>";
            $messageC .= "<p><b>Email Address: </b><i>   " . $email . "</i></p>";
            $messageC .= "<p><b>First Name: </b><i>   " . $firstName . "</i></p>";
            $messageC .= "<p><b>Last Name: </b><i>   " . $lastName . "</i></p>";
            $messageC .= "<p><b>Password: </b><i>   " . $password . "</i></p>";

            
        // SECTION: 2g Mail to user
            
        // Process for mailing a message which contains the forms data
            // the message was built in section 2f.

            $to = $email; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = "Final Poker <customerservice@finalpoker.com>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <customerservice@finalpoker.com>' . "\r\n";

            $subject = "Final Poker Registration";
            $message = $messageA . $messageB . $messageC;
            $mailed = mail($to, $subject, $message, $headers);
            print $mailed;
            // remove click to confirm
            $message = $messageA . $messageC;
        } // end data was entered
    } // end form is valid
}


if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit 
    print "<h2>Thank you for providing your information.</h2>";

    print "<p>For your records a copy of this data has ";

    if (!$mailed) {
        print "not ";
    }
    print "been sent to " . $email . "</p>";

    //print $message;
} else {
    print '<h2>Register Today</h2>';
    print '<p class="form-heading">You information will greatly help us with our research.</p>';
}
    //####################################
    //
    // SECTION 3b Error Messages
    //
    // display any error messages before we print out the form

    if ($errorMsg) {
        print '<div id="errors">' . "\n";
        print "<h2>Your form has the following mistakes that need to be fixed.</h2>\n";
        print "<ol>\n";

        foreach ($errorMsg as $err) {
            print "<li>" . $err . "</li>\n";
        }

        print "</ol>\n";
        print "</div>\n";
    }



?>


<main class="grid-layout">

    <form action = "<?php print PHP_SELF; ?>" id="frmSignUp" method = "POST">

    <fieldset>
        <legend>What is your email address?</legend>
        <label for="txtEmail">Email: </label>
        <input type="text" name="txtEmail" id="txtEmail" value="<?php print $email; ?>">
   </fieldset>


   <fieldset>
       <legend>What is your first name?</legend>
       <label for="txtFirstName">First Name: </label>
       <input type="text" name="txtFirstName" id="txtFirstName" value="<?php print $firstName; ?>">
   </fieldset>


   <fieldset>
       <legend>What is your last name?</legend>
       <label for="txtLastName">Last Name: </label>
       <input type="text" name="txtLastName" id="txtLastName" value="<?php print $lastName; ?>">
   </fieldset>

   <fieldset>
       <legend>What would you like your password to be?</legend>
       <label for="txtPassword">Password: </label>
       <input type="password" name="txtPassword" id="txtPassword" value="<?php print $password; ?>">
   </fieldset>

   <fieldset>
       <input class = "button" id="btnSubmit" type="submit" value="Sign Up" tabindex="900" name="btnSubmit">
   </fieldset>

    </form>

</main>

<?php
include 'footer.php';
?>