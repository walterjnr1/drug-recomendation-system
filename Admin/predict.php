<?php
require '../vendor/autoload.php';
include('../inc/email.php'); 
include('../inc/config.php'); 
use Phpml\ModelManager;

if (empty($_SESSION['user_id'])) {
    header("Location: ../Auth/user_login");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_recommendation'])) {

    $patient_id = $_SESSION['last_patient_id'] ?? null;
    $symptoms = $_SESSION['last_symptoms'] ?? null;
    $recommended_drug = $_SESSION['last_recommended_drug'] ?? null;
    if ($patient_id && $symptoms && $recommended_drug) {
        $stmt = $conn->prepare("UPDATE recommendations SET outcome = 'not effective' WHERE patient_id = ? AND symptoms = ? AND recommended_drug = ? ORDER BY date_recommended DESC LIMIT 1");
        $stmt->bind_param("iss", $patient_id, $symptoms, $recommended_drug);
        $stmt->execute();
        $stmt->close();
        echo '<p style="color:#f44336;"><strong>Recommendation marked as not effective.</strong></p>';
    } else {
        echo '<p style="color:#f44336;"><strong>Unable to mark as not effective. Missing data.</strong></p>';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $symptom1 = strtolower(trim($_POST['symptom1'] ?? ''));
        $symptom2 = strtolower(trim($_POST['symptom2'] ?? ''));
        $symptom3 = strtolower(trim($_POST['symptom3'] ?? ''));
        $patient_id = strtolower(trim($_POST['cmdpatient_id'] ?? ''));


        if (!$symptom1 || !$symptom2 || !$symptom3 || !$patient_id) {
                die("Please provide all three symptoms and Patient Name.");
        }

        $modelFile = '../models/drug_recommender.model';
        if (!file_exists($modelFile)) {
                die("Model file not found. Please train the model first.");
        }

        $modelManager = new ModelManager();
        /** @var \Phpml\Classification\NaiveBayes $classifier */
        $classifier = $modelManager->restoreFromFile($modelFile);

        $sample = [$symptom1, $symptom2, $symptom3];
        $prediction = $classifier->predict($sample);

        // fetch email from the patients table using mysqli
        $result = $conn->query("SELECT email FROM patients WHERE id = " . (int)$patient_id);
        if ($result && $row = $result->fetch_assoc()) {
            $email = $row['email'];
        }
        
        $symptoms = "$symptom1, $symptom2, $symptom3";
        $recommended_drug = $prediction;

         // Store for later use in reject
        $_SESSION['last_patient_id'] = $patient_id;
        $_SESSION['last_symptoms'] = $symptoms;
        $_SESSION['last_recommended_drug'] = $recommended_drug;


        $stmt = $conn->prepare("INSERT INTO recommendations (patient_id, symptoms, recommended_drug, date_recommended) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $patient_id, $symptoms, $recommended_drug);
        $stmt->execute();
        $stmt->close();

        // Send new Drug Recommendation Notification via email
        $message = "
        <html>
        <head>
        <title>Drug Recommendation Notification | $app_name</title>
        </head>
        <body>
        <p><strong>Hello,</strong></p>
        <p>Based on your reported symptoms: <strong>$symptoms</strong>, our system recommends the following drug:</p>
        <p style='font-size:1.2em; color:#1976d2;'><strong>$recommended_drug</strong></p>
        <p>Please consult your healthcare provider before taking any medication.</p>
        <p>Regards,<br>$app_name Team</p>
        </body>
        </html>
        ";

        $subject = "Drug Recommendation Notification | $app_name";
        sendEmail($email, $subject, $message);

       
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Drug Recommendation Result</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title><?php echo $app_name; ?> | Drug Recommendation</title>
                <?php include('partials/head.php'); ?>
        <style>
            body {
                background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
                font-family: 'Segoe UI', Arial, sans-serif;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
                padding: 40px 32px;
                max-width: 400px;
                width: 100%;
                text-align: center;
            }
            h1 {
                color: #2193b0;
                margin-bottom: 24px;
                font-size: 2rem;
            }
            p {
                color: #333;
                font-size: 1.1rem;
                margin: 16px 0;
            }
            strong {
                color: #1565c0;
            }
            .drug {
                display: inline-block;
                background: #e3f2fd;
                color: #1976d2;
                font-weight: bold;
                padding: 10px 24px;
                border-radius: 24px;
                margin: 16px 0;
                font-size: 1.2rem;
                letter-spacing: 1px;
                box-shadow: 0 2px 8px rgba(33, 147, 176, 0.08);
            }
        a {
            display: inline-block;
            margin-top: 24px;
            padding: 10px 24px;
            background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 24px;
            font-weight: 500;
            transition: background 0.2s;
        }
    .style1 {color: #0033CC}
        </style>
    <!-- The reject logic is now handled at the top of the file, so this block is no longer needed. -->
</head>
<body>
    <div class="container">
        <h6><a href="index" class="style1">&lt;&lt; Return</a></h6>
        <h6>Drug Recommendation Result</h6>

    <p><strong>Symptoms:</strong> <span class="drug"><?= htmlspecialchars($symptoms) ?></span></p>

        <div class="drug"><?= htmlspecialchars($prediction) ?></div>

<form method="post" onSubmit="return confirmReject();">
    <input type="hidden" name="reject_recommendation" value="1">
    <button type="submit" style="padding:10px 24px; background:#f44336; color:#fff; border:none; border-radius:24px; font-weight:500; cursor:pointer;">
        Reject Recommendation
    </button>
</form>
<script>
function confirmReject() {
    return confirm('Are you sure you want to reject this recommendation?');
}
</script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_recommendation'])) {
    // Update the latest recommendation for this patient and symptoms
    $stmt = $conn->prepare("UPDATE recommendations SET outcome = 'not effective' WHERE patient_id = ? AND symptoms = ? AND recommended_drug = ? ORDER BY date_recommended DESC LIMIT 1");
    $stmt->bind_param("iss", $patient_id, $symptoms, $recommended_drug);
    $stmt->execute();
    $stmt->close();
    echo '<p style="color:#f44336;"><strong>Recommendation marked as not effective.</strong></p>';
}
?>
            <p>We have sent the recommendation to the patient's email: <strong><?= htmlspecialchars($email) ?></strong></p>
            <br>
            <a href="recommend">Try another</a>   
</div>
    </body>
    </html>
    
