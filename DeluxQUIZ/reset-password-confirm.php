<?php
include 'dbconnection.php';

$token = $_GET['token'] ?? '';

$stmt = $dbconn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("Invalid or expired reset link.");
}
?>

<form action="new-password-logic.php" method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <input type="password" name="password" required placeholder="New password">
    <input type="password" name="confirm" required placeholder="Confirm password">

    <button type="submit">Reset password</button>
</form>
