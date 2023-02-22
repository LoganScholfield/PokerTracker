<?php

include 'top.php';

?>

<main class="grid-layout">
    <h3>Welcome to Final Poker!</h3>


    <section class="about">
    <h4>About the Site</h4>
    <p>Final Poker is a designed to make tracking your poker earnings easier than ever!
        Using Final Poker, users are able to keep track of their winnings all in one place.
        Not only can users have access to view their earning records, but once you add a
        friend's account, you can view their winnings as well!</p>
</section>

<section class="table">
    <h4>Explore the other features of our site here:</h4>
    <table>
        <tr>
            <th>Link</th>
            <th>Explanation</th>
        </tr>
        <tr>
            <td><a href="account.php">Your Account</a></td>
            <td>Once you have made an account with Final Poker, you can use the account
                link to access all of your personal account information.</td>
        </tr>
        <tr>
            <td><a href="friends.php">Friends</a></td>
            <td>As a user, you are able to search for and add your
                friends' accounts using the Friends page!</td>
        </tr>
        <tr>
            <td><a href="log.php">Track Earnings</a></td>
            <td>This is where users are able to log all of their poker earning data.
                Once entered into the form, the data is submitted and can be viewed by the user
                or the user's friends anytime.</td>
        </tr>
        <tr>
            <td><a href="display.php">View Earnings</a></td>
            <td>You can find the View Earnings page link on your Account page
                as well as on the Friends page. Once your friend has accepted your request, you are
                given access to view your friend's tracked earnings. </td>
        </tr>
    </table>
</section>
</main>

<?php

include 'footer.php';

?>
