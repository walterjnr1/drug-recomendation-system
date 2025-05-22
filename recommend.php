<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Drug Recommender</title>
</head>
<body>
    <h1>Drug Recommender System</h1>
    <form action="predict.php" method="POST">
        <label>Symptom 1:
            <input type="text" name="symptom1" required />
        </label><br /><br />
        <label>Symptom 2:
            <input type="text" name="symptom2" required />
        </label><br /><br />
        <label>Symptom 3:
            <input type="text" name="symptom3" required />
        </label><br /><br />
        <button type="submit">Recommend Drug</button>
    </form>
</body>
</html>
