<?php
session_start(); 

include('includes/db.php'); 

$query = $_GET['query'] ?? ''; 

$response = [];

if ($query) {
    $artistes = $db->artistes->find(
        ['artist_mb' => new MongoDB\BSON\Regex($query, 'i')]
    );
} else {
    $artistes = $db->artistes->find();
}

foreach ($artistes as $artiste) {
    $response[] = [
        'artist_mb' => $artiste['artist_mb'],
        'listeners_lastfm' => $artiste['listeners_lastfm'],
        'spotify' => $artiste['spotify'] ?? null
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
