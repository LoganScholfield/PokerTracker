<?php

include 'top.php';

// select person with most friends
$sql = 'SELECT CONCAT(fldFirstName, " ", fldLastName) AS fldFullName, MAX(fldNumFriends) ';
$sql .= 'FROM tblUserInfo ';

// select all friends
$sql = 'SELECT CONCAT(fldFirstName, " ", fldLastName) AS fldFullName, fldNumFriends ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'ORDER BY fldNumFriends DESC ';

$data = '';

$mostFriends = $thisDatabaseReader->select($sql, $data);

?>

<main class="grid-layout">
    <h3>Friendships</h3>
    <section class="mostFriends">
        <h4>Most Friends</h4>
        <?php
        if (is_array($mostFriends)) {
            foreach ($mostFriends as $friends) {
            }
        }
        ?>
    </section>
    <section class="friendTable">
        <table>
            <caption>Number of Friends</caption>
            <tr>
                <th>User's Name</th>
                <th>Number of Friends</th>
            </tr>
            <?php
            if (is_array($mostFriends)) {
                foreach ($mostFriends as $friends) {
                    print '<tr>';
                    print '<td>' . $friends['fldFullName'] . '</td>';
                    print '<td>' . $friends['fldNumFriends'] . '</td>';
                    print '</tr>';
            }
            }
            ?>
        </table>
    </section>
</main>
