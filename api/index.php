<?php
// Force working directory to /public
chdir(__DIR__ . '/../public');

// Expose the requested path
if (isset($_GET['path'])) {
    $_SERVER['REQUEST_URI'] = '/' . $_GET['path'];
}

require './index.php';