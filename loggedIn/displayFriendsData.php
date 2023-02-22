<?php
include 'top.php';
$email = (isset($_GET['ml'])) ? (string) htmlspecialchars($_GET['ml']) : 'noEmail';

// select user info from tblUserInfo
$sql = 'SELECT fldFirstName, fldDateLogged, fldUserEarnings ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'JOIN tblDataTracked on pmkEmail = fldEmail ';
$sql .= 'WHERE pmkEmail = ? ';

$data = array($email);

$users = $thisDatabaseReader->select($sql, $data);

?>

<main class="grid-layout">
    <?php
    if (is_array($users)) {
        foreach ($users as $user) { 
            print '<h3>Here are ' . $user['fldFirstName'] . ' \'s Earning Records</h3>';

        }
    }
    ?> 
    <section class="display">
        
        <table>
            <tr>
                <th>Date</th>
                <th>Entry</th>
            </tr>
            <?php
                if(is_array($users)) {
                    foreach($users as $user) {
                        print '<tr>';
                        print '<td>' . $user['fldDateLogged'] . '</td>';
                        print '<td>' . $user['fldUserEarnings'] . '</td>';
                        print '</tr>';
                    }
                }
            ?>
        </table>
    </section>


    

</main>



<?php
include 'footer.php';
?>