<?php
session_start();


if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = [];
    $_SESSION['score'] = 0;
    $_SESSION['current_question'] = 0;
    $_SESSION['total_questions'] = 10;
    $_SESSION['level'] = '1-10';
    $_SESSION['operator'] = 'add';
}

// Generate current question if the quiz is ongoing
if ($_SESSION['current_question'] < $_SESSION['total_questions']) {
    list($min, $max) = explode('-', $_SESSION['level']);
    $num1 = rand($min, $max);
    $num2 = rand($min, $max);

    // Ensure num2 is not zero to avoid division by zero errors
    while ($num2 == 0) {
        $num2 = rand($min, $max);
    }

    switch ($_SESSION['operator']) {
        case 'add':
            $correctAnswer = $num1 + $num2;
            $operatorSymbol = '+';
            break;
        case 'sub':
            $correctAnswer = $num1 - $num2;
            $operatorSymbol = '-';
            break;
        case 'mul':
            $correctAnswer = $num1 * $num2;
            $operatorSymbol = '×';
            break;
        case 'div':
            $correctAnswer = round($num1 / $num2, 2);
            $operatorSymbol = '÷';
            break;
    }

    // Generate multiple choices
    $choices = [$correctAnswer];
    while (count($choices) < 4) {
        $rand = round(rand($correctAnswer - 10, $correctAnswer + 10), 2);
        if (!in_array($rand, $choices) && $rand >= 0) {
            $choices[] = $rand;
        }
    }
    shuffle($choices);

    $_SESSION['questions'][] = [
        'num1' => $num1,
        'num2' => $num2,
        'operator' => $operatorSymbol,
        'correctAnswer' => $correctAnswer,
        'choices' => $choices,
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Mathematics</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #e6f7ff;
        }
        .calculator {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 320px;
        }
        .calculator h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .display {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2em;
            margin-bottom: 20px;
            background: #f2f2f2;
            padding: 10px;
            border-radius: 8px;
        }
        .choices {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .choices button {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background 0.3s;
        }
        .choices button:hover {
            background: #0056b3;
        }
        .settings {
            margin-top: 20px;
        }
        .settings h2 {
            text-align: center;
            margin-bottom: 15px;
        }
        .settings select, .settings button {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            outline: none;
        }
        .settings button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .settings button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Simple Mathematics Quiz</h1>

        <?php if ($_SESSION['current_question'] < $_SESSION['total_questions']): ?>
            <div class="display">
                <?php
                $currentQuestion = $_SESSION['questions'][$_SESSION['current_question']];
                echo "{$currentQuestion['num1']} {$currentQuestion['operator']} {$currentQuestion['num2']} = ?";
                ?>
            </div>
            <form method="post" action="process.php" class="choices">
                <?php foreach ($currentQuestion['choices'] as $choice): ?>
                    <button type="submit" name="answer" value="<?php echo $choice; ?>"><?php echo $choice; ?></button>
                <?php endforeach; ?>
            </form>
        <?php else: ?>
            <p style="text-align: center; font-size: 1.2em;">Quiz Complete! <a href="results.php" style="color: #007bff;">See Results</a></p>
        <?php endif; ?>

        <div class="settings">
            <h2>Settings</h2>
            <form method="post" action="process.php">
                <label>
                    Level:
                    <select name="level">
                        <option value="1-10" <?php echo $_SESSION['level'] == '1-50' ? 'selected' : ''; ?>>EASY (1-50)</option>
                        <option value="11-100" <?php echo $_SESSION['level'] == '51-100' ? 'selected' : ''; ?>>MEDIUM (51-100)</option>
                        <option value="101-1000" <?php echo $_SESSION['level'] == '101-1000'? 'selected' : '';?>>HARD (101-1000)</option>
                        
                    </select>
                </label>
                <label>
                    Operator:
                    <select name="operator">
                        <option value="add" <?php echo $_SESSION['operator'] == 'add' ? 'selected' : ''; ?>>Addition</option>
                        <option value="sub" <?php echo $_SESSION['operator'] == 'sub' ? 'selected' : ''; ?>>Subtraction</option>
                        <option value="mul" <?php echo $_SESSION['operator'] == 'mul' ? 'selected' : ''; ?>>Multiplication</option>
                        <option value="div" <?php echo $_SESSION['operator'] == 'div' ? 'selected' : ''; ?>>Division</option>
                    </select>
                </label>
                <button type="submit" name="update_settings">Update Settings</button>
            </form>
        </div>
    </div>
</body>
</html>
