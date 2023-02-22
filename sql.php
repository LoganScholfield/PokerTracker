<?php
include 'top.php'
?>
<main>
    <p>Create tblUserInfo</p>
    <pre>
        CREATE TABLE tblUserInfo (
          pmkEmail varchar(65) NOT NULL,
          fldFirstName varchar(50) NOT NULL,
          fldLastName varchar(50) NOT NULL,
          fldDateJoined timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          fldConfirmed tinyint(1) NOT NULL DEFAULT '0',
          fldPassword varchar(50) NOT NULL
        )
    </pre>

    <p>Insert to tblUserInfo</p>
    <pre>
        INSERT INTO tblUserInfo SET
        pmkEmail = ?,
        fldFirstName = ?,
        fldLastName = ?,
        fldPassword = ? '
    </pre>

    <p>Create tblDataTracked</p>
    <pre>
        CREATE TABLE tblDataTracked (
          pmkDataId int(11) NOT NULL,
          fldEmail varchar(65) NOT NULL,
          fldDateLogged timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          fldUserEarnings int(11) NOT NULL
        )
    </pre>

    <p>Insert to tblDataTracked</p>
    <pre>
       INSERT INTO tblDataTracked SET
        fldEmail = ? ,
        fldUserEarnings = ? '
    </pre>

    <p>Create tblFriends</p>
    <pre>
        CREATE TABLE tblFriends (
          fpkPersonEmail varchar(65) NOT NULL,
          fpkFriendEmail varchar(65) NOT NULL,
          fldDateSent timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          fldAccepted tinyint(1) DEFAULT NULL
        )
    </pre>


</main>
<?php
include 'footer.php';?>

