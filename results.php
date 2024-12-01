<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 50px auto;
            padding: 20px;
            width: 90%;
            max-width: 600px;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            font-size: 1.2em;
            margin: 10px 0;
        }
        .result {
            font-size: 1.5em;
            font-weight: bold;
            margin: 20px 0;
        }
        .grade {
            font-size: 1.5em;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1em;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quiz Results</h1>
        <p class="result">Your Score: <?php echo $_SESSION['score']; ?> / 10</p>
        <?php
        $totalQuestions = 10; 
        $passingScore = 5; 
        $score = $_SESSION['score'];
        $percentage = ($score / $totalQuestions) * 100;
        ?>
        <p class="result">Your score is <?php echo number_format($percentage, 2); ?>%</p>
        <p class="message">
            <?php
            if ($score >= $passingScore) { 
                echo "You passed!";
            } else {
                echo "You did not pass. Better luck next time!";
            }
            ?>
        </p>
        <a class="btn" href="index.php">Restart Quiz</a>
    </div>
</body>
</html>
