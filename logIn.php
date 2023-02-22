<?php
include 'top.php';

// sanitize function from textbook
function getData($field) {
    if (!isset($_POST[$field])) {
        $data = "";
    }
    else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data, ENT_QUOTES);
    }
    return $data;
}

// SELECT emails and passwords from tblUser to compare for validation
$sql = 'SELECT pmkEmail, fldConfirmed, fldPassword ';
$sql .= 'FROM tblUserInfo ';

$cData = '';
$compareData = $thisDatabaseReader->select($sql, $cData);



// initialize form variables
$email = '';
$password = '';
$status = false;

if(isset($_POST['btnSubmit'])) {
    if (DEBUG) {
        print '<p>Post Array:</p><pre>';
        print_r($_POST);
        print '</pre>';
    }

// sanitize data
    $email = getData('txtEmail');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = getData('txtPassword');


// validation
    foreach ($compareData as $cd) {
        if ($email == $cd['pmkEmail']) {
            if ($password == $cd['fldPassword']) {
                $status = true;
            }

        }
    }

    if ($status == false) {
        print '<p>Email and password do not match our records.</p>';
        $email = '';
        $password = '';

    } else{
        $_SESSION["userEmail"] = $email;
        header ("LOCATION:loggedIn/account.php");
    }

}

?>

<main class="grid-layout">
    <h3>Welcome Back! Log In Here</h3>

    <section class="logIn">
        <form action="#" id="frmLogIn" class="logInForm" method="post">
            <fieldset class="email">
                <legend>Email Address</legend>
                <p>
                    <label for="txtEmail">Email: </label>
                    <input type="text" name="txtEmail" id="txtEmail" value="<?php print $email; ?>" tabindex="250" required>
                </p>
            </fieldset>

            <fieldset class="password">
                <legend>Password</legend>
                <p>
                    <label for="txtPassword">Password: </label>
                    <input type="password" name="txtPassword" id="txtPassword" value="<?php print $password; ?>" tabindex="100" required>
                </p>
            </fieldset>

            <fieldset>
                <p><input class="button" type="submit" id="btnSubmit" name="btnSubmit" value="Log In" tabindex="900"></p>
            </fieldset>
        </form>
    </section>
</main>

<?php

include 'footer.php';

?>
