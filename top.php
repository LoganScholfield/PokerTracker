<?php
session_start();
?>


<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Katie Goodelman and Logan Scholfield">
        <meta name="description" content="This site is designed to collect and compare user data
                using relational databases for a fake online poker game.">

        <title>FINAL POKER</title>

        <link rel="stylesheet"
              href="css/custom.css?version=<?php print time();?>"
              type="text/css">
        <link rel="stylesheet" media="(max-width:800px)"
              href="css/tablet.css?version=<?php print time(); ?>"
              type="text/css">
        <link rel="stylesheet" media="(max-width:600px)"
              href="css/phone.css?version<?php print time();?>"
              type="text/css">

<!--**** include libraries ****-->
<?php
include 'lib/constants.php';
print '<!-- make Database connections -->';
require_once(LIB_PATH . 'Database.php');

$thisDatabaseReader = new Database('lscholfi_reader', 'r', DATABASE_NAME);
$thisDatabaseWriter = new Database('lscholfi_writer', 'w', DATABASE_NAME);

print '</head>';

print '<body id="' . PATH_PARTS['filename'] . '">';
print '<!-- ***** START OF BODY ***** -->';

print PHP_EOL;

include 'header.php';
print PHP_EOL;


?>
