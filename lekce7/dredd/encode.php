<?php

$data = [
    'email' => 'example@example.com',
    'passwd' => 'anyPassword',
    'checkbox1' => 'on'
];

echo http_build_query($data);