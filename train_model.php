<?php
require 'vendor/autoload.php';
use Phpml\Classification\NaiveBayes;
use Phpml\ModelManager;

// Load dataset
$datasetFile = 'dataset.csv';

if (!file_exists($datasetFile)) {
    die("Dataset file not found!");
}

// Parse CSV
$rows = array_map('str_getcsv', file($datasetFile));
$header = array_shift($rows);

$samples = [];
$labels = [];

foreach ($rows as $row) {
    // Each row: symptom1, symptom2, symptom3, drug
    if (count($row) < 4) {
        // Skip incomplete rows
        continue;
    }
    $samples[] = [$row[0], $row[1], $row[2]];
    $labels[] = $row[3];
}

// Train Naive Bayes classifier
$classifier = new NaiveBayes();
$classifier->train($samples, $labels);

// Save model
$modelFile = 'models/drug_recommender.model';
$modelManager = new ModelManager();
$modelManager->saveToFile($classifier, $modelFile);

echo "Model trained and saved to '$modelFile' successfully.\n";
