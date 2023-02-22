<?php

include 'top.php';

// select information from tblDataTracked to display for table
$sql = 'SELECT pmkDataId, CONCAT(fldFirstName, " ", fldLastName) AS fldFullName, fldDateLogged, fldUserEarnings ';
$sql .= 'FROM tblDataTracked ';
$sql .= 'JOIN tblUserInfo on fldEmail = pmkEmail ';
$sql .= 'ORDER BY fldFullName ';

$data = '';
$usersTracked = $thisDatabaseReader->select($sql, $data);

?>

<main class="grid-layout">
    <h3>Update Earnings</h3>
    <section class="update">
        <table>
            <tr>
                <th>User's Name</th>
                <th>Earning Amount Entered</th>
                <th>Date</th>
                <th>Update</th>
            </tr>
            <?php
            if(is_array($usersTracked)) {
                foreach($usersTracked as $user) {
                    print '<tr>';
                    print '<td>' . $user['fldFullName']  . '</td>';
                    print '<td>' . $user['fldUserEarnings'] . '</td>';
                    print '<td>' . $user['fldDateLogged'] . '</td>';
                    print '<td><a href="updateEarnings.php?w=' . $user['pmkDataId'] . '">Update</a></td>';
                    print '</tr>' . PHP_EOL;
                }
            }

            ?>
        </table>
    </section>
</main>

<?php

include '../loggedIn/footer.php';

?>
