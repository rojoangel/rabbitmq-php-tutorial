<?php

require_once __DIR__ . './../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false, false, false);
list($queue_name, ,) = $channel->queue_declare('', false, false, true, false);

$severities = array_slice($argv, 1);
if(empty($severities)){
    file_put_contents('php://stderr', 'Usage: $argv[0] [info] [warning] [error]\n');
}

foreach($severities as $severity) {
    $channel->queue_bind($queue_name, 'direct_logs', $severity);
}

echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

/** @var AMQPMessage $msg */
$callback = function($msg) {
    echo "[x] ", $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();