<?php
header('Content-Type: application/json');

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    echo json_encode(['error' => 'slug manquant']);
    exit;
}

$slug = urlencode($_GET['slug']);
$url = "https://datav2.judomanager.com/api/Contest/MediaTokenForVideofield?slug={$slug}&idPartner=7";

// On récupère le JSON de l’API distante
$response = file_get_contents($url);

if ($response === false) {
    echo json_encode(['error' => 'Erreur API distante']);
} else {
    echo $response; // renvoie tel quel au navigateur
}
