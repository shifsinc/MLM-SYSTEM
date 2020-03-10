<?php
define('host', 'mysql:host=localhost:3306;dbname=mrvegec1_mrvege');
define('username', 'mrvegec1_mrvege');
define('pass', 'PG.4lU5VP0Jl');

try {
    $dbh = new PDO(host, username, pass); // initialize pdo
    
    // reset pdo
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}

$conn = new PDO(host, username, pass);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
