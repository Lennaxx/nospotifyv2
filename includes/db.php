<?php
require 'vendor/autoload.php';  

use MongoDB\Client;

try {
    $client = new Client('mongodb://localhost:27017');
    $db = $client->nosql;
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
