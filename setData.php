<?php
require('./vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$parameters = [
    'host' => $_ENV['REDIS_URL'],
    'port' => $_ENV['REDIS_PORT'],
    'database' => 0,
];


$dsn = $_ENV['DB_DSN'];
$username = $_ENV['DB_USER_NAME'];
$password = $_ENV['DB_PASS'];

$pref_arrs =
    [
        '北海道',
        '青森県',
        '岩手県',
        '宮城県',
        '秋田県',
        '山形県',
        '福島県',
        '茨城県',
        '栃木県',
    ];

$count = 1;
foreach ($pref_arrs as $pref) {
    try {
        $pdo = new PDO($dsn, $username, $password);

        $code = strval('0'.$count);


        $sql = "INSERT INTO country VALUES (?,?,?)";

        $res = $pdo->prepare($sql);
        $res->bindValue(1, $count, PDO::PARAM_INT);
        $res->bindValue(2, $code);
        $res->bindValue(3, $pref);
        $res->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $count++;
}



