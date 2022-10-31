<?php

/**
 * This is the Hangman game controller class.
 * The methods are pretty self-explanatory.
 */


 class Hangman {

    protected $word, $guesses, $turns;

    public function __construct() {
        $this->setState(); 
    }

    /**
     * Checks if the word has been guessed.
     *
     * @return boolean
     */
    public function hasGuessed() {
        for($i=0; $i<count($this->guesses); ++$i) {
            if($this->guesses[$i] != $this->word[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets the guesses.
     *
     * @return void
     */
    public function getGuesses() {
        return $this->guesses;
    }

     /**
     * Gets a friendly readable guessess.
     *
     * @return void
     */
    public function getReadableGuesses() {
        $ret = '';
        foreach($this->guesses as $guess) {
            $ret .= $guess === null ? ' _ ' : ' ' . $guess . ' ';
        }

        return $ret;
    }

    /**
     * Gets the state that can be stored to session.
     *
     * @return void
     */
    public function getState() {
        return [
            'word' => $this->word,
            'guesses' => $this->guesses,
            'turns' => $this->turns
        ];
    }

    /**
     * Gets the turns.
     *
     * @return void
     */
    public function getTurns() {
        return $this->turns;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getWord() {
        return $this->word;
    }

    /**
     * Sets the word for the game.
     *
     * @param [type] $word
     * @return void
     */
    public function setWord($word) {
        $this->word = strtolower($word);

        // This also means we have to initialize all guesses.
        $totalLetters = strlen($this->word);
        for ($i=0; $i<$totalLetters; $i++) {
            $this->guesses[]= null;
        }
        
        // Also reset the turns since it's a word set.
        $this->turns = 0;
    }

    /**
     * Tries a guess.
     *
     * @param [type] $letter
     * @return void
     */
    public function tryGuess($letter) {
        $matched = false;
        $letter = strtolower($letter);

        for($i=0; $i<count($this->guesses); ++$i) {
            if($this->guesses[$i] == null && $this->word[$i] == $letter) {
                $this->guesses[$i] = $letter;
                $matched = true;
            }
        }
        if ($matched == false) {
            $this->turns += 1;
        }
    }

    /**
     * Checks if the word is proper.
     *
     * @param [type] $word
     * @return boolean
     */
    private function isFineWord($word) {
        return preg_match('/^\d+$/', $word);
    }


    /**
     * Sets the default values for all variables.
     *
     * @return void
     */
    public function setState($data = []) {
        $this->word = $data['word'] ?? null;
        $this->guesses = $data['guesses'] ?? [];
        $this->turns = $data['turns'] ?? 0;
    }
    

 }

