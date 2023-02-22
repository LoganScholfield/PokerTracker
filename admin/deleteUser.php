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

// select user info to display
$sql = 'SELECT pmkEmail, CONCAT(fldFirstName, " ", fldLastName) AS fldFullName, fldDateJoined, fldConfirmed ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'ORDER BY fldFullName ';

$data = '';
$users = $thisDatabaseReader->select($sql, $data);

$radDelete = "";
$delete = false;
$friendEmail1 = "";
$friendEmail2 = "";
$friendCount = 0;

if (isset($_POST['btnDelete'])) {
    if (DEBUG) {
        print '<p>POST array:</p><pre>';
        print_r($_POST);
        print '</pre>';
    }

    // sanitization
    $radDelete = getData('radDelete');

    // validation
    if ($radDelete == "") {
        print '<p>Please choose a user to delete before submitting the form.</p>';
    }
    else {
        $delete = true;
    }

    if ($delete) {
        $sql2 = 'DELETE FROM tblUserInfo ';
        $sql2 .= 'WHERE pmkEmail = ? ';

        $data2 = array($radDelete);
        $deleteUserInfo = $thisDatabaseWriter->delete($sql2, $data2);

        if (!$deleteUserInfo) {
            print '<p>Delete could not be saved.</p>';
        }
        else {
            print '<p>Delete has been completed for tblUserInfo.</p>';
            if (DEBUG) {
                print $thisDatabaseReader->displayQuery($sql2, $data2);
            }
        }

        $sql4 = 'DELETE FROM tblDataTracked ';
        $sql4 .= 'WHERE fldEmail = ? ';

        $deleteData = $thisDatabaseWriter->delete($sql4,$data2);

        if (!$deleteData) {
            print '<p>Delete could not be saved.</p>';
        }
        else {
            print '<p>Delete has been completed for tblDataTracked.</p>';
            if (DEBUG) {
                print $thisDatabaseReader->displayQuery($sql4, $data2);
            }
        }

        // remove 1 from friend count for other people before removing friendship
        $sql5 = 'SELECT fpkFriendEmail, fldNumFriends ';
        $sql5 .= 'FROM tblFriends ';
        $sql5 .= 'JOIN tblUserInfo on fpkPersonEmail = pmkEmail ';
        $sql5 .= 'WHERE fpkPersonEmail = ? ';

        $selectFriends1 = $thisDatabaseReader->select($sql5, $data2);


        $sql3 = 'DELETE FROM tblFriends ';
        $sql3 .= 'WHERE fpkPersonEmail = ? ';
        $sql3 .= 'OR fpkFriendEmail = ? ';

        $data3 = array();
        $data3[] = $radDelete;
        $data3[] = $radDelete;

        $deleteFriend = $thisDatabaseWriter->delete($sql3,$data3);

        if (!$deleteFriend) {
            print '<p>Delete could not be saved.</p>';
        }
        else {
            print '<p>Delete has been completed for tblFriends.</p>';
            if (DEBUG) {
                print $thisDatabaseReader->displayQuery($sql3, $data2);
            }
        }

    }

}

?>

<main class="grid-layout">
    <h3>Delete User Form</h3>
    <section class="deleteTable">
        <table>
            <caption>User Information</caption>
            <tr>
                <th>Email</th>
                <th>Full Name</th>
                <th>Date Joined</th>
                <th>Account Confirmed</th>
            </tr>
            <?php
            if (is_array($users)) {
                foreach($users as $user) {
                    print '<tr>';
                    print '<td>' . $user['pmkEmail'] . '</td>';
                    print '<td>' . $user['fldFullName'] . '</td>';
                    print '<td>' . $user['fldDateJoined'] . '</td>';
                    print '<td>';
                    if ($user['fldConfirmed'] == 1) {
                        print 'Yes';
                    } else {
                        print 'No';
                    }
                    print '</td>' . PHP_EOL;
                }
            }
            ?>
        </table>
    </section>

    <section class="deleteForm">
        <form action="<?php print PHP_SELF; ?>" id="deleteForm" method="post">
            <fieldset>
                <legend>Pick which user you would like to delete: </legend>
                <?php
                if(is_array($users)) {
                    foreach($users as $user) {
                        print '<p><input type="radio" name="radDelete" id="rad' . $user['pmkEmail'] . '" value="'. $user['pmkEmail'] .'">';
                        print '<label for="rad' . $user['pmkEmail'] .'">' . $user['fldFullName'] .'</label></p>';
                    }
                }
                ?>
            </fieldset>

            <fieldset>
                <p><input class="button" type="submit" name="btnDelete" value="Delete"></p>
            </fieldset>


        </form>
    </section>
</main>

<?php
include '../loggedIn/footer.php';

?>
