<nav>
    <a class="<?php
    if (PATH_PARTS['filename'] == "admin") {
        print "activePage";
    }
    ?>" href="../register.php">Back Home</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "updateEarnings") {
        print "activePage";
    }
    ?>" href="updateEarnings.php?w=">Insert Earnings</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "deleteUser") {
        print "activePage";
    }
    ?>" href="deleteUser.php">Delete User</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "updateList") {
        print "activePage";
    }
    ?>" href="updateList.php">Update Earnings</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "mostEarned") {
        print "activePage";
    }
    ?>" href="mostEarned.php">Earnings</a>

    <a class="<?php
    if (PATH_PARTS['filename'] == "friendStats") {
        print "activePage";
    }
    ?>" href="friendStats.php">Friendships</a>



</nav>