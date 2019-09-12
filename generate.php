<?php
session_start();
require 'base.php';
$url = $_POST['url'];

do {
    $shortcut = generateRandomString();
    $unique = $db->prepare("
        SELECT * FROM shorty WHERE shortcut = :shortcut
         ");
    $unique->execute([
        'shortcut' => $shortcut]);
    $result = $unique->fetch();
} while ($result == true);

$GLOBALS['vartex'] = 'vartex';

if (empty($_POST['url'])) {
    header('Location: /prazan');
    exit();
} elseif (filter_var($url, FILTER_VALIDATE_URL) === false) {
    header('Location: /nijevalidan');
    exit();
} else {

    $insertPage = $db->prepare("
		INSERT INTO shorty (shortcut, url, created)
		VALUES (:shortcut, :url, NOW())
		");

    $insertPage->execute([
        'shortcut' => $shortcut,
        'url' => $_POST['url'],
    ]);
    $_SESSION['shortcut'] = $shortcut;

    header('Location: /');

}
