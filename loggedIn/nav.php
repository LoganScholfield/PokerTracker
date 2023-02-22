<nav>
    <a class="<?php
    if (PATH_PARTS['filename'] == "homePage") {
        print "activePage";
    }
    ?>" href="homePage.php">Home</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "account") {
        print "activePage";
    }
    ?>" href="account.php">Account</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "friends") {
        print "activePage";
    }
    ?>" href="friends.php">Friends</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "log") {
        print "activePage";
    }
    ?>" href="log.php">Track Earnings</a>

<a class="<?php
    if (PATH_PARTS['filename'] == "register.php") {
        print "activePage";
    }
    ?>" href="../register.php">Log Out</a>


    <div class="dropDownMenu">
        <a class="dropDownBtn <?php
        if (PATH_PARTS['filename'] == "admin") {
            print "activePage";
        }
        ?>" href="../admin/admin.php">Admin</a>
        <div class="dropDownOptions">
            <a href="../admin/updateList.php">Update Earnings</a>
            <a href="../admin/updateEarnings.php?w=">Insert Earnings</a>
            <a href="../admin/deleteUser.php">Delete User</a>
            <a href="../admin/friendStats.php">Friendships</a>
            <a href="../admin/mostEarned.php">Earnings</a>
        </div>
    </div>

</nav>
