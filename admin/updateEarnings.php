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

// check for pmkDataId to see if insert or update
$dataId = (isset($_GET['w'])) ? (int) htmlspecialchars($_GET['w']) : 0;

// select information for an update
$sql = 'SELECT pmkDataId, CONCAT(fldFirstName, " ", fldLastName) AS fldFullName, fldUserEarnings, fldEmail ';
$sql .= 'FROM tblDataTracked ';
$sql .= 'JOIN tblUserInfo on fldEmail = pmkEmail ';
$sql .= 'WHERE pmkDataId = ? ';

$data = array($dataId);

$userData = $thisDatabaseReader->select($sql, $data);

// initialize variables
$fullName = '';
$email = '';
$netEarned = 0;
$saveData = true;

// form submission
if(isset($_POST['btnSubmit'])) {
    if (DEBUG) {
        print '<p>Post Array:</p><pre>';
        print_r($_POST);
        print '</pre>';
    }

    $email = getData('lstUsers');
    $netEarned = (float) getData('txtNetEarned');

    // validate data
    if ($dataId == 0) {
        if ($email == "") {
            print '<p>Please enter an email address.</p>';
            $saveData = false;
        }

        if (!is_numeric($netEarned)) {
            print '<p>Please enter numeric characters only.</p>';
            $saveData = false;
        }
    }
    elseif ($dataId >= 0) {
        if (!is_numeric($netEarned)) {
            print '<p>Please enter numeric characters only.</p>';
            $saveData = false;
        }
    }

    // insert data sql
    if ($saveData AND $dataId == 0) {
        // insert into table
        $sql3 = 'INSERT INTO tblDataTracked SET ';
        $sql3 .= 'fldEmail = ?, ';
        $sql3 .= 'fldUserEarnings = ? ';

        $data3 = array();
        $data3[] = $email;
        $data3[] = $netEarned;

        $insert = $thisDatabaseWriter->insert($sql3,$data3);

        if(!$insert){
            print '<p>Insert could not be completed.</p>';
        }
        else {
            print '<p>Insert completed.</p>';
        }

        if (DEBUG) {
            print $thisDatabaseWriter->displayQuery($sql3,$data3);
        }

    }
    // update data sql
    elseif($saveData AND $dataId > 0) {
        // update table
        $sql2 = 'UPDATE tblDataTracked SET ';
        $sql2 .= 'fldUserEarnings = ? ';
        $sql2 .= 'WHERE pmkDataId = ? ';

        $data2 = array();
        $data2[] = $netEarned;
        $data2[] = $dataId;

        $updated = $thisDatabaseWriter->update($sql2, $data2);
        if(!$updated) {
            print '<p>Update could not be completed.</p>';
        }
        else {
            print '<p>Update was complete!</p>';
            print '<p>Your update for ' . $netEarned . ' was entered.</p>';
        }

        if (DEBUG) {
            $thisDatabaseReader->displayQuery($sql2,$data2);
        }
    }

}
?>

<main class="grid-layout">
    <?php
        if ($dataId == 0) {
            print '<h3>Insert New Earnings</h3>';
        }
        else {
            if (is_array($userData)) {
                foreach ($userData as $user) {
                    $fullName = $user['fldFullName'];
                    $netEarned = $user['fldUserEarnings'];
                }
            }
            print '<h3>Update ' . $fullName .' \'s $' . $netEarned . ' Entry</h3>';
        }
        ?>
    <section class="updateForm">
    <form action="#" id="frmInsertUpdate" method="post">
        <fieldset>
            <?php
            if ($dataId == 0) {
                print '<p><label for="lstUsers">Choose User Email: ';
                print '<input list="lstEmails" name="lstUsers" id="lstUsers">';
                print '<datalist id="lstEmails">';
                if (is_array($userData)) {
                    foreach ($userData as $user) {
                        print '<option ';
                        if ($email == $user['fldEmail']) {
                            print ' selected ';
                        }
                        print 'value="' . $user['fldEmail'] . '">';
                    }
                }
                print '</datalist>';
                print '</label></p></fieldset>';

                print '<fieldset>';
                print '<p><label for="txtNetEarned">Net Earnings: </label>';
                print '<input type="text" id="txtNetEarned" name="txtNetEarned" value="' . $netEarned . '" required></p>';
                print '</fieldset>';
            }
        elseif ($dataId > 0) {
            print '<p><label for="txtNetEarned">Net Earnings: </label>';
            print '<input type="text" id="txtNetEarned" name="txtNetEarned" value="' . $netEarned . '" required></p>';
            print '</fieldset>';
            }
        ?>


        <fieldset>
            <p><input class="button" type="submit" name="btnSubmit" id="btnSubmit" value="<?php if($dataId == 0) { print 'Insert'; } else { print 'Update'; } ?>"></p>
        </fieldset>

    </form>
</section>
</main>

<?php

include '../loggedIn/footer.php';
?>




