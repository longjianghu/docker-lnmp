<?php
$redis = new Redis;
$redis->connect('172.17.0.1', 6379); 
$redis->auth('redis');
$redis->set('rand',mt_rand());
echo $redis->get('rand');