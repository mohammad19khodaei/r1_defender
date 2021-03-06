<?php

use App\Cache\Cache;
use App\Queue\Queue;

require_once __DIR__.'/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $code = strtolower($code);

    $isCompaingUnderway = Cache::get('campaign:'.$code) > 0;

    if (!$isCompaingUnderway) {
        return;
    }

    (new Queue())
        ->publish([
            'phone'=> $_POST['phone'],
            'code' => $code,
            'timestamp' => round(microtime(true) * 1000),
        ]);
}
