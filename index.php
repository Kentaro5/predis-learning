<?php
require('./vendor/autoload.php');
use Predis\Client;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function provideClient()
{
    $parameters = [
        'host'     => $_ENV['REDIS_URL'],
        'port'     => $_ENV['REDIS_PORT'],
        'database' => 0,
    ];

    return new Client($parameters);
}

$client = provideClient();
// キー 'hoge' で値 'moge' を保存
 try {
     $client->set('hoge', 'moge');
      //キー 'hoge' の値を取得
     $hoge = $client->get('hoge');
 } catch (\Exception $e) {
     echo $e->getMessage();
 }


echo '<pre>';
echo '******************';
var_dump($hoge);
echo '******************';
var_dump('test');
echo '******************';
echo '</pre>';
die('FFFFFFF');