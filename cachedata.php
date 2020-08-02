<?php
require('./vendor/autoload.php');

use Predis\Client;
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

$client = new Client($parameters);

//既にセットされていれば、Data already existsを出力。
if ($client->get('allRowsDataArray') === NULL) {
    try {
        $pdo = new PDO($dsn, $username, $password);
        $stmt = $pdo->prepare('SELECT * FROM country');
        $stmt->execute();

        $pref_data = [];
        $counter = 0;
        while ($row = $stmt->fetch()) {
            $pref_data[$counter]['id'] = $row['id'];
            $pref_data[$counter]['code'] = $row['code'];
            $pref_data[$counter]['name'] = $row['name'];
            $counter++;
        }
        //Redisにデータをセット。
        $client->set('allRowsDataArray', json_encode($pref_data));
        //期限を設定
        $client->expireat("allRowsDataArray", strtotime("+1 min"));
        //データ取得
        $hoge = $client->get('allRowsDataArray');

    } catch (\Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "Data already exists";
}


echo '<pre>';
echo '******************';
var_dump($hoge);
echo '******************';
var_dump('test');
echo '******************';
echo '</pre>';


