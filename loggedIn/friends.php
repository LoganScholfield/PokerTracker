<?php

include 'top.php';

function getData($field){
    if (!isset($_POST[$field])){
        $data = "";
    }
    else{
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data, ENT_QUOTES);
    }
    return $data;
}

// initialize user's email
$email = $_SESSION["userEmail"];

/* SEND FRIEND REQUEST */

// select information from tblUserInfo to display for friend request
$sql = 'SELECT pmkEmail, fldFirstName, fldLastName ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'WHERE fldConfirmed = 1 ';

$data = '';

$users = $thisDatabaseReader->select($sql, $data);


// initialize variables for friend request
$friendEmail = '';
$firstName = '';
$lastName = '';
$saveData = true;

// submit friend request form
if(isset($_POST['btnRequest'])) {
    if (DEBUG) {
        print '<p>POST array:</p><pre>';
        print_r($_POST);
        print '</pre>';
    }

    // sanitize data
    $friendEmail = getData('lstUsers');

    // validate
    if($friendEmail == "") {
        print '<p>Please choose another user to request before submitting the form.</p>';
        $saveData = false;
    }

    if($saveData) {
        $sql2 = 'INSERT INTO tblFriends SET ';
        $sql2 .= 'fpkPersonEmail = ?, ';
        $sql2 .= 'fpkFriendEmail = ? ';

        $data2 = array();
        $data2[] = $email;
        $data2[] = $friendEmail;

        $friendsInsert = $thisDatabaseWriter->insert($sql2, $data2);
        if(!$friendsInsert) {
            print '<p>Friend request could not be sent.</p>';
        }
        else {
            print '<h2>Your friend request has been sent!</h2>';
            print '<p>Once your request is accpeted, your friend will show up under the Friends section of your account page.</p>';
        }

        if(DEBUG){
            print $thisDatabaseReader->displayQuery($sql2, $data2);
            print_r($data2);
            //print_r($dataNew);
        }
    }
} // end of submit friend request form


/* FRIEND REQUESTS/UPDATES */

// select information from friends table to display in requests section
$sql3 = 'SELECT pmkEmail, fldFirstName, fldLastName, fldDateSent ';
$sql3 .= 'FROM tblUserInfo ';
$sql3 .= 'JOIN tblFriends on pmkEmail = fpkPersonEmail ';
$sql3 .= 'WHERE fpkFriendEmail = ? ';
$sql3 .= 'AND fldAccepted IS NULL ';

$data3 = array($email);
$friendRequests = $thisDatabaseReader->select($sql3, $data3);

// select fldNumFriends for person replying to request
$sql5 = 'SELECT fldNumFriends ';
$sql5 .= 'FROM tblUserInfo ';
$sql5 .= 'WHERE pmkEmail = ? ';

$data5 = array($email);

$userNumFriends = $thisDatabaseReader->select($sql5, $data5);

// initialize variable for accept/deny request
// initialize variable for update friend count
$radAccepted = false;
$hidFriendEmail = '';

$friendCount = 0;
$hidFriendCount = 0;

if (is_array($userNumFriends)) {
    foreach ($userNumFriends as $user) {
        $friendCount = $user['fldNumFriends'];
    }
}


//submit accept/deny of friend request
if(isset($_POST['btnAccepted'])) {
    if (DEBUG) {
        print '<p>POST array:</p><pre>';
        print_r($_POST);
        print '</pre>';
    }

    // sanitize friend request information
    $radAccepted = getData('radAccepted');
    $hidFriendEmail = getData('hidFriendEmail');

    // update statement for friend request approval/denial
    $sql4 = 'UPDATE tblFriends SET ';
    $sql4 .= 'fldAccepted = ? ';
    $sql4 .= 'WHERE fpkFriendEmail = ? ';

    $data4 = array();
    $data4[] = $radAccepted;
    $data4[] = $email;

    $requestUpdate = $thisDatabaseWriter->update($sql4, $data4);
    if(!$requestUpdate) {
        print '<p>Friend request could not be updated.</p>';
    }
    else {
        print '<h2>Your friend request ';

        if ($radAccepted == 1) {
            print 'approval ';
            $friendCount++;
        }

        elseif ($radAccepted == 0) {
            print 'denial ';
        }

        print 'was completed!</h2>';
        print $friendEmail;


    }

    if(DEBUG)
    {
        $thisDatabaseReader->displayQuery($sql4, $data4);
    }

    // update for fldNumFriends for person who accepted request
    $sql6 = 'UPDATE tblUserInfo SET ';
    $sql6 .= 'fldNumFriends = ? ';
    $sql6 .= 'WHERE pmkEmail = ? ';

    $data6 = array();
    $data6[] = $friendCount;
    $data6[] = $email;

    $updatePerson = $thisDatabaseWriter->update($sql6, $data6);
    if (!$updatePerson) {
        print '<p>Friend count could not be updated.</p>';
    }
    else {
        print '<p>You now have ';
        if($friendCount == 1) {
            print $friendCount . ' friend! Check them out on your friends page!</p>';
        }
        elseif ($friendCount > 1) {
            print $friendCount . ' friends! Check them out on your friends page!</p>';
        }

    }

    // select fldNumFriends for person who sent request
    $data7 = array($hidFriendEmail);
    $selectFriend = $thisDatabaseReader->select($sql5,$data7);

    if (is_array($selectFriend)) {
        foreach ($selectFriend as $friend) {
            $hidFriendCount = $friend['fldNumFriends'];
        }
    }

    // add one to new friend count
    $hidFriendCount++;

    // update for fldNumFriends for person who sent request
    $data8 = array();
    $data8[] = $hidFriendCount;
    $data8[] = $hidFriendEmail;

    $updateFriend = $thisDatabaseWriter->update($sql6,$data8);


}

?>


<main class="grid-layout">
    <h3>Final Poker Friends</h3>
    <section class="search">
        <h4>Find a Friend</h4>
        <p>Using the drop-list and the request button, you can search through the other users of Final Poker and
            send out a request to be their friend. Once they have accepted your request, you will be able to view and
            compare each other's earnings!</p>





        <script>



        function myChoice() {
        if(document.getElementById("panel").style.display == "none") {
        document.getElementById("panel").style.display = "block";
        //document.getElementById("submitReplace").style.display = "block";
        //document.getElementById("submitFind").style.display = "none";
        } 
        else {
            document.getElementById("panel").style.display = "none";
            //document.getElementById("submitReplace").style.display = "none";
            //document.getElementById("submitFind").style.display = "block";
        }
        }



        </script>

        <form class="requests" action="<?php print PHP_SELF ?>" id="friendRequest" method="post">
            <fieldset class="userList">
                <p>
                    <label for="lstUsers">Friend Email:
                    <input list="lstEmails" name="lstUsers" id="lstUsers">
                    <datalist id="lstEmails">
                    <?php
                        if(is_array($users)) {
                            foreach ($users as $user) {
                                if ($email != $user['pmkEmail']) {
                                    print '<option ';
                                    if ($friendEmail == $user['pmkEmail']) {
                                        print ' selected ';
                                    }
                                    print 'value="' . $user['pmkEmail'] . '">';
                               }
                            }
                        }
                    ?>
                    </datalist>
                    </label>
                </p>
            </fieldset>

            <fieldset>
                <p>
                    <input class="button" type="submit" name="btnRequest" value="Send Friend Request">
                </p>
            </fieldset>
        </form>
    </section>

    <article class="choiceButton">
            <p class="flip"><button onclick="myChoice()"> View Friend Requests</button></p>
            <p id="choice">Find</p>
    

    <section id="panel"class="requests">
        <h4>Your Requests</h4>
        <p>View all the friends requests that have been sent to you and either accept/deny them. This table will be automatically updated when
            new requests are sent and after your response.</p>
        <table>
            <tr>
                <th>From</th>
                <th>Date Sent</th>
                <th>Accept/Deny</th>
            </tr>
            <?php
                if(is_array($friendRequests)) {
                    foreach($friendRequests as $request) {
                        print '<tr>';

                        print '<td>' . $request['fldFirstName'] . ' ' . $request['fldLastName'] . '</td>';

                        print '<td>' . $request['fldDateSent'] . '</td>';

                        print '<td><form action="#" id="frmRequestAccept" method="post">';

                        print '<fieldset class="request">';
                        print '<p><input ';
                        if ($radAccepted == "Accept") print 'checked';
                        print 'type="radio" name="radAccepted" id="radAccept" value="1">';
                        print '<label for="radAccept">Accept Request</label></p>';
                        print '<p><input ';
                        if ($radAccepted == "Deny") print 'checked';
                        print 'type="radio" name="radAccepted" id="radDeny" value="0">';
                        print '<label for="radDeny">Deny Request</label></p></fieldset>';

                        print '<fieldset><p><input type="hidden" name="hidFriendEmail" id="hidFriendEmail" value="'. $request['pmkEmail'] . '"></p></fieldset>';

                        print '<fieldset><p><input class="button" type="submit" name="btnAccepted" value="Submit"></p></fieldset>';

                        print '</form></td>';
                        print '<tr>';
                    }
                }
            ?>
        </table>
    </section>
  
    </article>
    <section class="friends">
        <?php
            $sql = 'SELECT fpkPersonEmail, fpkFriendEmail ';
            $sql .= 'FROM tblFriends ';
            $sql .= 'WHERE fldAccepted = 1 AND fpkPersonEmail = ? OR fpkFriendEmail = ? ';


            $data9 = array();
            $data9[] = $email;
            $data9[] = $email;

            $friendRequests = $thisDatabaseReader->select($sql, $data9);

        ?>

        <h4>Your Friends</h4>
        <p>View all your friends and their stats below.</p>
        <table>
            <tr>
                <th>Friend</th>
                <th>View stats</th>
            </tr>
            <?php
                if(is_array($friendRequests)) {
                    foreach($friendRequests as $friend) {

                        print '<tr>';

                        if($friend['fpkPersonEmail'] != $email){
                            print '<td>';
                            print $friend['fpkPersonEmail'];
                            print '</td>';
                        }
                        elseif($friend['fpkFriendEmail'] != $email){
                            print '<td>';
                            print $friend['fpkFriendEmail'];
                            print '</td>';
                        }

                        if($friend['fpkPersonEmail'] != $email){
                          
                            print '<td><a href="displayFriendsData.php?ml=' . $friend['fpkPersonEmail'] . '">View</a></td>';

                          
                        }
                        elseif($friend['fpkFriendEmail'] != $email){
                           
                            print '<td><a href="displayFriendsData.php?ml=' . $friend['fpkFriendEmail'] . '">View</a></td>' ;

                            
                        }
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
