<?php

// Let's start the session, our base storage, and get the game controller.
session_start();
require('Hangman.php');

// Game controller.
$hangman = new Hangman();

// If this is a set word.
if(isset($_POST['word'])) {
    $word = $_POST['word'];
    $hangman->setWord($word);
    $_SESSION['hangman'] = $hangman->getState();
}

// If this is retry.
if(isset($_POST['retry'])) {
    $hangman->setState();
    $_SESSION['hangman'] = $hangman->getState();
}

// Sync the state from session.
if(isset($_SESSION['hangman'])) {
    $hangman->setState($_SESSION['hangman']);
}

// If this is turn/guess.
if(isset($_POST['letter'])) {
    $letter = $_POST['letter'];
    $hangman->tryGuess($letter);
    $_SESSION['hangman'] = $hangman->getState();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Hangman Game | Demo</title>
</head>
<body>

    <!-- The header. -->
    <header class="p">
        <h1>
            Hangman Game
        </h1>
        <div>
            Welcome to the Hangman Game!
        </div>
    </header>
    <div class="line"></div>

    <!-- The mini instructions. -->
    <div class='p'>
        <h4>Instructions</h4>
        <div>Follow the simple instructions below to play the game:</div>
        <ol>
            <li>Player one sets a word, while player two looks away.</li>
            <li>After setting the word, player two tries to guess the word, by trying one letter at a time.</li>
            <li>If the player two guesses the word in 6 or less wrong tries he/she wins, or otherwise he/she losses.</li>
        </ol>
    </div>
    <div class="line"></div>
    
    <!-- The game. -->
    <div class="p">
        <h4>Let's play</h4>
        <?php // If no word has been set yet. ?>
        <?php if($hangman->getWord() === null): ?>
            <div>
                <span class='player player-one'>Player 1</span> - Set the word
            </div>
            <br>
            <form method='POST'>
                <input type="text" name='word' required placeholder='Enter the word ...'>
                <button>Set word</button>
            </form>
        <?php // If no word has been set but turns remain. ?>
        <?php elseif($hangman->getTurns() < 6 && !$hangman->hasGuessed()): ?>
            <div>
                <span class='player player-two'>Player 2</span> - Guess a letter (Turn <?php echo $hangman->getTurns() + 1; ?> / 6 )
            </div>
            <br>
            <h5>Guesses so far: <?php echo $hangman->getReadableGuesses(); ?></h5>
            <br>
            <form method='POST'>
                <input type="text" name='letter' maxlength=1
                    required placeholder='Enter a letter to guess ...'>
                <button>Guess</button>
            </form>
        <?php elseif($hangman->getTurns() < 6 && $hangman->hasGuessed()): ?>
            <div>
                <span class='player player-two'>Player 2</span> - Has won in <?php echo $hangman->getTurns(); ?> turns!
            </div>
            <h5>The word is: <?php echo $hangman->getReadableGuesses(); ?></h5>
            <form method='POST'>
                <button name='retry'>Play again</button>
            </form>
        <?php else: ?>
            <div>
                <span class='player player-two'>Player 2</span> - Has failed to guess in 6 tries ...
            </div>
            <h5>The word is: <?php echo $hangman->getWord(); ?></h5>
            <form method='POST'>
                <button name='retry'>Play again</button>
            </form>
        <?php endif; ?>
    </div>    
</body>
</html>
