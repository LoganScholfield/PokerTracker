<?php
include 'top.php';

$email = $_SESSION["userEmail"];

// select user info from tblUserInfo
$sql = 'SELECT fldFirstName ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'WHERE pmkEmail = ? ';

$data = array($email);

$users = $thisDatabaseReader->select($sql, $data);

?>

<main class="grid-layout">
    <?php
    if (is_array($users)) {
        foreach ($users as $user) { 
            print '<h3>' . $user['fldFirstName'] .  ', below are your records</h3>';

        }
    }

    $sql2 = 'SELECT fldDateLogged, fldUserEarnings ';
    $sql2 .= 'FROM tblDataTracked ';
    $sql2 .= 'WHERE fldEmail = ? ';


    $data2 = array($email);
    $userEarnings = $thisDatabaseReader->select($sql2, $data2);


    $sql3 = 'SELECT FORMAT(SUM(fldUserEarnings),2) ';
    $sql3 .= 'FROM tblDataTracked ';
    $sql3 .= 'WHERE fldEmail = ? ';

    $data3 = array($email);
    $userTotalEarnings = $thisDatabaseReader->select($sql3,$data3);

    ?> 
    <section class="display">
        <h4>Your Data</h4>
        
        <table>
            <tr>
                <th>Date</th>
                <th>Entry</th>
            </tr>
            <?php
                if(is_array($userEarnings)) {
                    foreach($userEarnings as $value) {
                        print '<tr>';
                        print '<td>' . $value['fldDateLogged'] . '</td>';
                        print '<td>' . $value['fldUserEarnings'] . '</td>';
                        print '</tr>';
                    }
                }
            ?>
        </table>
    </section>

    <section>
    <?php
                if(is_array($userTotalEarnings)) {
                    foreach($userTotalEarnings as $Total) {
                        print '<p>' . $value['FORMAT(SUM(fldUserEarnings),2)'] . '</p>';
                    }
                }
            ?>
    </section>


    

</main>



<?php
include 'footer.php';
?>