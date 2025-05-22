<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Drug Recommendation System</title>
  <link rel="stylesheet" href="css/styles.css"/>
   <link rel="icon" type="image/x-icon" href="uploadImage/Logo/logo.png">

</head>
<body>
  <header class="navbar">
    <h1>Drug Recommender</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="recommendation.php">Get Recommendation</a>
      <a href="patient.php">Register Patient</a>
    </nav>
  </header>

  <section class="slider">
    <div class="slides" id="slides">
      <img src="uploadImage/slider/slide_1.webp" alt="Pharmacy 1">
      <img src="uploadImage/slider/slide_2.webp" alt="Pharmacy 2">
      <img src="uploadImage/slider/slide_3.jpg" alt="Pharmacy 4">
    </div>
  </section>

  <section class="content">
    <h2>Welcome to the AI-Driven Drug Recommender</h2>
    <p>This platform helps healthcare professionals recommend the right drugs based on patient history using machine learning.</p>
    <a href="recommendation.php" class="btn">Start Recommendation</a>
  </section>

  <footer>
<?php include('Admin/partials/footer.php') ?>  
  </footer>

  <script src="js/script.js"></script>
</body>
</html>
