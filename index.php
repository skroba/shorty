<?php
require 'base.php';
if (isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) < 20) {
    $shortcut = ltrim($_SERVER['REQUEST_URI'],'/');
    $page = $db->prepare("
    SELECT URL
    FROM shorty
    WHERE shortcut = :shortcut"
    );
    $page->execute(['shortcut' => $shortcut]);

    $page = $page->fetch(PDO::FETCH_OBJ);
    if (!empty($page->URL)) {

        header('Location: ' . $page->URL);
        exit();
    } else {
        require 'start.php';
    }
} else {
    require 'start.php';
}
