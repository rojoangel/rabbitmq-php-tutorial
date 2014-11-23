<?php
require_once __DIR__ . './../vendor/autoload.php';
use \PhpAmqpLib\Connection\AMQPConnection;
use \PhpAmqpLib\Message\AMQPMessage;

$data = implode('', array_slice($argv, 1));

if(empty($data))
{
    $data = "Hello World!";
}

/** @var AMQPConnection $connection */
$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);
$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => 2) # make message persistent
);
$channel->basic_publish($msg, '', 'task_queue');

echo " [x] Sent ", $data, "\n";
