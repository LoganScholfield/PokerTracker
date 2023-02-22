<?php
/* the purpose of this page is to accept the hashed date joined and primary key  
 * as passed into this page in the GET format.
 * 
 * I retreive the date joined from the table for this person and verify that 
 * they are the same. After which i update the confirmed field and acknowledge 
 * to the user they were successful. Then i send an email to the system admin 
 * to approve their membership 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 */

include "top.php";

print '<article id="main">';

print '<h3>Final Poker Registration Confirmation</h3>';

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
if (DEBUG)
    print "<p>DEBUG MODE IS ON</p>";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
$dateSubmitted = '';
$email = '';
$keyDate = '';
$keyId = '';
$results = '';
$AdminMessage = '';
$UserMessage = '';
$failedMessage = "<p>I am sorry but this account cannot be confirmed at this time. Please email lscholfi@uvm.edu for help resolving this matter.</p>";
//##############################################################
//
// SECTION: 2 
// 
// process request
$keyDate = (isset($_GET["q"])) ? htmlspecialchars($_GET['q']) : 0;
    $keyDate = $_GET["q"];  // I did not sanitize in case of special characters were in the hased value
    $keyId = (string) htmlentities($_GET["w"], ENT_QUOTES, "UTF-8");
    //$keyId = (isset($_GET['w'])) ? (string) htmlspecialchars($_GET['w']) : 0;
   

//##############################################################
// get the membership record 

    $query = "SELECT fldDateJoined, pmkEmail FROM tblUserInfo WHERE pmkEmail = ? ";
    $data = array($keyId);

    $results = $thisDatabaseReader->select($query, $data);
    

    if ($results) {
        $dateSubmitted = $results[0]["fldDateJoined"];
        $email = $results[0]["pmkEmail"];
    }
//##############################################################
// update confirmed
    if (password_verify($dateSubmitted, $keyDate)) {
        $query = "UPDATE tblUserInfo SET fldConfirmed = 1 WHERE pmkEmail = ? ";

        $results = $thisDatabaseWriter->update($query, $data);

//##############################################################
// notify user
        if ($results) {
            $to = $email;
            $cc = "";
            $bcc = "";
            $from = "Final Poker <customerservice@finalpoker.com>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <customerservice@finalpoker.com>' . "\r\n";

            $subject = "Final Poker Registration Confirmed";
            $UserMessage = '<p>Congratulations! You have confirmed your Final Poker account and have successfully finished the registration process!</p>';
            $UserMessage .= '<p>Check out your account page to get started using Final Poker today.</p>';
            $UserMessage .= '<p><a href="https://lscholfi.w3.uvm.edu/cs148/dev-final/logIn.php">Log In</a></p>';

            $mailed = mail($to, $subject, $UserMessage, $headers);
        }
        else {
// update failed
            $UserMessage = $failedMessage;
        }
    }

    else {
        $UserMessage = $failedMessage;
    } // keys equal

//##############################################################
//
// SECTION: 3 
// 
// inform user

print $UserMessage;
print '</article>';

include "footer.php";
?>