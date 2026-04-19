<?php
$target = __DIR__ . '/../storage/app/public';
$link   = __DIR__ . '/storage';

if (file_exists($link)) {
    echo "Link already exists.";
} else {
    symlink($target, $link);
    echo "Done! Delete this file now.";
}