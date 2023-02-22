<?php


include 'top.php';

//if(isset($_POST['txtEmail'])) $email = $_POST['txtEmail'];

$email = $_SESSION["userEmail"];

// select user info from tblUserInfo
$sql = 'SELECT pmkEmail, fldFirstName, fldLastName ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'WHERE pmkEmail = ? ';

$data = array($email);

$users = $thisDatabaseReader->select($sql, $data);
?>

<main class="grid-layout">
    <?php
    if (is_array($users)) {
        foreach ($users as $user) {
            
            print '<h3>Welcome Back ' . $user['fldFirstName'] .  '!</h3>';

            print '<section class="accountInfo">';
            print '<h4>Account Information</h4>';
            print '<p><strong>Name:</strong> ' . $user['fldFirstName'] . ' ' . $user['fldLastName'] . '</p>';
            print '<p><strong>Email Address:</strong> ' . $user['pmkEmail'] . '</p>';
            print '</section>';

            print '<section class="viewEarnings">';
            print '<h4>Manage Earnings</h4>';
            print '<a href=log.php>Insert Earnings</a>';
            print '<p> </p>';
            print '<a href=display.php>View Earnings</a>';
            print '</section>';



        }
    }


    ?>

</main>

<?php

include 'footer.php';

?>
