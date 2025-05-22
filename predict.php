<?php
require 'vendor/autoload.php';

use Phpml\ModelManager;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symptom1 = strtolower(trim($_POST['symptom1'] ?? ''));
    $symptom2 = strtolower(trim($_POST['symptom2'] ?? ''));
    $symptom3 = strtolower(trim($_POST['symptom3'] ?? ''));

    if (!$symptom1 || !$symptom2 || !$symptom3) {
        die("Please provide all three symptoms.");
    }

    $modelFile = 'models/drug_recommender.model';
    if (!file_exists($modelFile)) {
        die("Model file not found. Please train the model first.");
    }

    $modelManager = new ModelManager();
    /** @var \Phpml\Classification\NaiveBayes $classifier */
    $classifier = $modelManager->restoreFromFile($modelFile);

    $sample = [$symptom1, $symptom2, $symptom3];
    $prediction = $classifier->predict($sample);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Drug Recommendation Result</title>
    </head>
    <body>
        <h1>Recommended Drug</h1>
        <p><strong>Based on symptoms:</strong> <?= htmlspecialchars("$symptom1, $symptom2, $symptom3") ?></p>
        <p><strong>Recommended drug:</strong> <?= htmlspecialchars($prediction) ?></p>
        <a href="recommend.php">Try another</a>
    </body>
    </html>
    <?php
} else {
    header('Location: index.php');
    exit;
}
