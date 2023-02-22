<?php

include 'top.php';

$sql = 'SELECT CONCAT(fldFirstName, " ", fldLastName) AS fldFullName, ';
$sql .= 'SUM(fldUserEarnings) AS fldTotalEarnings ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'JOIN tblDataTracked on fldEmail = pmkEmail ';
$sql .= 'GROUP BY fldFullName ';
$sql .= 'ORDER BY fldTotalEarnings DESC ';

$data = '';
$userEarnings = $thisDatabaseReader->select($sql, $data);

?>

<main class="grid-layout">
    <section class="earnings">
        <table>
            <tr>
                <th>Full Name</th>
                <th>Total Earnings</th>
            </tr>
            <?php
            if (is_array($userEarnings)) {
                foreach($userEarnings as $user) {
                    print '<tr>';
                    print '<td>' . $user['fldFullName'] .'</td>';
                    print '<td>$' . $user['fldTotalEarnings'] .'</td>';
                    print '</tr>';
                }
            }
            ?>
        </table>
    </section>
</main>

<?php
include '../loggedIn/footer.php';
?>
