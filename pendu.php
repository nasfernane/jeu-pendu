<?php

// déclaration des variables
$dictionnary = file("data.txt");
$wordToGuess = $dictionnary[rand(0, count($dictionnary))];
$guessingProgress = preg_replace('#[a-zA-Z]#', '_', str_split($wordToGuess));
$previousGuess = [];
$tryLeft = 5;

// tant que l'utilisateur n'a pas trouvé le mot complet
while (implode($guessingProgress) !== $wordToGuess) {
    $previousStr = implode(', ', $previousGuess);

    // Si le compteur d'essais restants est à 0, exit le jeu avec un message
    if ($tryLeft == 0) {
        exit("💥 Perdu... Il fallait trouver le mot $wordToGuess ! Tu n'es vraiment pas doué à ce jeu. 💥");
    }

    // affiche la progression et les précédentes recherches
    print implode(" ", $guessingProgress);
    echo "\n";
    if ($previousStr) echo "Vos précédentes recherches : [$previousStr] \n";
    echo "\n\nChoisissez une lettre : \n";

    // récupération de la saisie utilisateur
    $playerGuess = str_split(stream_get_line(STDIN, 8, PHP_EOL))[0];

    // si la lettre saisie est inclue dans le mot à trouver
    if (in_array($playerGuess, str_split($wordToGuess))) {
        // récupère tous les index correspondant à cette lettre...
        $letterPositions = array_keys(str_split($wordToGuess), $playerGuess);
        
        // ... et les inclue dans la progression
        foreach ($letterPositions as $letter) {
            $guessingProgress[$letter] = $playerGuess;
        }
    
    // sinon,
    } else {
        // ajoute la lettre aux essais manqués
        $previousGuess[] = $playerGuess;
        // décrémente les essais restants
        $tryLeft--;
        echo "$tryLeft essais restants. \n";
    }
}
// exit et message de réussite
if (implode($guessingProgress) === $wordToGuess) exit("✌ Victoire ! Tu es en forme aujourd'hui... ✌")

?>
