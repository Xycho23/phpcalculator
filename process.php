<?php
session_start();

if (isset($_POST['update_settings'])) {
    // Update settings
    $_SESSION['level'] = $_POST['level'];
    $_SESSION['operator'] = $_POST['operator'];
    $_SESSION['questions'] = [];
    $_SESSION['score'] = 0;
    $_SESSION['current_question'] = 0;
    header('Location: index.php');
    exit;
}

if (isset($_POST['answer'])) {
    // Check answer and update score or move to next question
    $currentQuestion = $_SESSION['questions'][$_SESSION['current_question']];
    if ((int)$_POST['answer'] === $currentQuestion['correctAnswer']) {
        $_SESSION['score']++;
    }

    
    $_SESSION['current_question']++;
    header('Location: index.php');
    exit;
}