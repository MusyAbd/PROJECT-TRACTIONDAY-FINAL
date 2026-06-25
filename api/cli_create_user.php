<?php
// CLI script: PHP/cli_create_user.php
// Usage: php cli_create_user.php <username> <password>
// NOTE: This script runs only from CLI to safely create users with hashed passwords.

if (php_sapi_name() !== 'cli') {
    echo "This script must be run from CLI.\n";
    exit(1);
}

$argv0 = array_shift($argv);
if (count($argv) < 2) {
    echo "Usage: php {$argv0} <username> <password>\n";
    exit(1);
}

$username = trim($argv[0]);
$password = $argv[1];

require_once __DIR__ . '/koneksi.php';

if ($username === '' || $password === '') {
    echo "Username and password cannot be empty.\n";
    exit(1);
}

// Ensure username not exists
$check = pg_query_params($koneksi, 'SELECT id FROM users WHERE username = $1', [$username]);
if ($check && pg_num_rows($check) > 0) {
    echo "User '{$username}' already exists.\n";
    if ($check) pg_free_result($check);
    exit(1);
}
if ($check) pg_free_result($check);

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user. Adjust column list if your users table has different schema.
$res = pg_query_params($koneksi, 'INSERT INTO users (username, password) VALUES ($1, $2) RETURNING id', [$username, $hash]);
if ($res && pg_num_rows($res) === 1) {
    $row = pg_fetch_assoc($res);
    $id = $row['id'];
    pg_free_result($res);
    echo "Created user '{$username}' with id={$id}.\n";
    exit(0);
} else {
    echo "Failed to create user.\n";
    if ($res) pg_free_result($res);
    exit(1);
}
