<?php

$path = __DIR__.'/app/Http/Controllers/Admin/UserManagementController.php';
$lines = file($path);
foreach ($lines as $i => $line) {
    printf('%4d: %s', $i + 1, $line);
}
