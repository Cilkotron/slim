<?php 
require_once __DIR__ . '/db.php';

use function DI\create;


return [
    'db' => create(DB::class)
];
