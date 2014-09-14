<?php

echo '<h1>Welcome</h1>';
echo 'id : ' . $_SESSION['id'];
echo '<br/>Name : ' . $_SESSION['username'];
echo '<br/>Email : ' . $_SESSION['email'];
echo '<br/>You are login with : ' . $_SESSION['oauth_provider'];
echo '<br/>Logout from <a href="logout.php?logout">' . $_SESSION['oauth_provider'] . '</a>';
?>


