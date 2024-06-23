<?php
session_start();
session_unset();
session_destroy();

// Smažeme session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Smažeme všechny cookies (volitelně)
foreach ($_COOKIE as $cookie_name => $cookie_value) {
    setcookie($cookie_name, '', time() - 42000, '/');
}

header('Location: login.html');
exit();
?>
