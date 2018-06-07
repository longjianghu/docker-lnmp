<?php
$redis = new Redis();
$redis->connect('redis', 6379);
$redis->auth('redis');
$redis->set('time', time());
echo $redis->get('time');