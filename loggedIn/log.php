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
 
$net = 0;
$saveData = true;
 
$email = $_SESSION["userEmail"];


$sql = 'SELECT pmkEmail, fldFirstName, fldLastName ';
$sql .= 'FROM tblUserInfo ';
$sql .= 'WHERE pmkEmail = ? ';
 
$data = array($email);
 
$users = $thisDatabaseReader->select($sql, $data);

if(isset($_POST['btnSubmit'])){
    if(DEBUG){
        print '<p>POST array:</p><pre>';
        print_r($_POST);
        print '</pre>';
 
    }
 
 
    //sanitize data
    $net = (float) getData('txtNet');
 
 
    //validate input
    if(!is_numeric($net)){
            print '<p class="mistake">Please provide a valid profit value.</p>';
            print ($net);
            print '<p>Is not a valid number</p>';
            $saveData = false;
        }
 

    if ($saveData) {

        $sql2 = 'INSERT INTO tblDataTracked SET ';
        $sql2 .= 'fldEmail = ?, ';
        $sql2 .= 'fldUserEarnings = ? ';

        $dataAdd = array();
        $dataAdd[] = $email;
        $dataAdd[] = $net;

        $dataInserted = $thisDatabaseWriter->insert($sql2, $dataAdd);
        if (!$dataInserted) {
            print '<p>Data could not be inserted.</p>';
        }
        else {
            print '<h2>Thank you for your entry!</h2>';
            print '<p>Your entry of $' . $net . ' has been entered. You can check out this information via your account page!</p>';
        }
        
        
        if(DEBUG){
            print $thisDatabaseReader->displayQuery($sql2, $dataAdd);
        } 
    }
}
 
 
?>
 <main class="grid-layout">
     <?php
        if (is_array($users)) {
            foreach ($users as $user) {
                print '<h3>Ready to track your progress, ' . $user['fldFirstName'] .  '?</h3>';
                print '<section><h4>Net Earnings Form</h4>';
                print '<p>Using the form provided, enter your net earnings as often as you would like. ';
                print 'Your entries will then be visible to you on your account page, this way you can ';
                print 'keep up with how well <em>(or not well)</em> you have been playing!</p>';
                print '</section>';
            }
     }
     ?>

     <form action="#" id="frmLog" method="post">
        <fieldset class="log">
            <p>
                <label for="txtNet">Net Earnings: </label>
                <input type="text" name="txtNet" id="txtNet" value="<?php print $net; ?>" required>
            </p>
        </fieldset>

        <fieldset>
            <p><input class="button" type="submit" id="btnSubmit" name="btnSubmit" value="Log" tabindex="900"></p>
        </fieldset>
    </form>

 </main>
<?php
include 'footer.php';
?>

