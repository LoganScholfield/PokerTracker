<?php
include 'top.php';
//sesion_unset();
?>

<main class="grid-layout">

        <h3>Welcome to Final Poker!</h3>

        <section class="frmSignUp">
            <form method="post" action="signUp.php" id="frmSignUp">
                <fieldset>
                    <legend>First time? Make an account here.</legend>
                    <button type="submit">Sign up</button>
                </fieldset>
            </form>
        </section>

        <section class="frmLogIn">
            <form method="post" action="logIn.php" id="frmLogIn">
                <fieldset>
                    <legend>Already a user? Log in here.</legend>
                    <button type="submit">Log In</button>
                </fieldset>
            </form>
        </section>

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
                    <th>Aspects</th>
                    <th>Explanation</th>
                </tr>
                <tr>
                    <td>Your Account</td>
                    <td>Once you have made an account with Final Poker, you can use the account
                        link to access all of your personal account information.</td>
                </tr>
                <tr>
                    <td>Friends</td>
                    <td>As a user, you are able to search for and add your
                        friends' accounts using the Friends page!</td>
                </tr>
                <tr>
                    <td>Track Earnings</td>
                    <td>This is where users are able to log all of their poker earning data.
                        Once entered into the form, the data is submitted and can be viewed by the user
                        or the user's friends anytime.</td>
                </tr>
                <tr>
                    <td>View Earnings</td>
                    <td>You can view all of your entered earnings on your account page!
                        In addition, once a friend has accepted your request, you will be able to view your friends' earnings too.</td>
                </tr>
            </table>
        </section>
</main>

<?php
include 'footer.php';
?>