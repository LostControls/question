<?php

require_once __DIR__ .'/vendor/autoload.php';

use LostControls\Question\Question;

$key = 'e14b1b323c76320e6c2a06bd0d7b61ee';

$w = new Question($key);

$response = $w->getQuestion(1, 'c1', 'rand');

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);