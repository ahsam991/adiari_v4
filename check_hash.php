<?php
$password = 'admin123';
$hash = '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANh5eDXjnqK';

if (password_verify($password, $hash)) {
    echo "Password verify SUCCESS\n";
} else {
    echo "Password verify FAILURE\n";
}

$new_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
echo "New hash: $new_hash\n";
if (password_verify($password, $new_hash)) {
    echo "New hash verify SUCCESS\n";
}
