<?php

function reverseWords(&$message)
{
    // first we reverse all the characters in the entire message
    reverseCharacters($message, 0, strlen($message) - 1);
    // this gives us the right word order
    // but with each word backward

    // now we'll make the words forward again
    // by reversing each word's characters

    // we hold the index of the *start* of the current word
    // as we look for the *end* of the current word
    $currentWordStartIndex = 0;
    for ($i = 0; $i <= strlen($message); $i++) {

        // found the end of the current word!
        if ($i === strlen($message) || $message[$i] === ' ') {

            // if we haven't exhausted the string our
            // next word's start is one character ahead
            reverseCharacters($message, $currentWordStartIndex, $i - 1);
            $currentWordStartIndex = $i + 1;
        }
    }
}

function reverseCharacters(&$messageArray, $leftIndex, $rightIndex)
{
    // walk towards the middle, from both sides
    while ($leftIndex < $rightIndex) {

        // swap the left char and right char
        $temp = $messageArray[$leftIndex];
        $messageArray[$leftIndex] = $messageArray[$rightIndex];
        $messageArray[$rightIndex] = $temp;
        $leftIndex++;
        $rightIndex--;
    }
}






// tests

$desc = 'one word';
$actual = 'vault';
$expected = 'vault';
reverseWords($actual);
assertEqual($actual, $expected, $desc);

$desc = 'two words';
$actual = 'thief cake';
$expected = 'cake thief';
reverseWords($actual);
assertEqual($actual, $expected, $desc);

$desc = 'three words';
$actual = 'one another get';
$expected = 'get another one';
reverseWords($actual);
assertEqual($actual, $expected, $desc);

$desc = 'multiple words same length';
$actual = 'rat the ate cat the';
$expected = 'the cat ate the rat';
reverseWords($actual);
assertEqual($actual, $expected, $desc);

$desc = 'multiple words different lengths';
$actual = 'yummy is cake bundt chocolate';
$expected = 'chocolate bundt cake is yummy';
reverseWords($actual);
assertEqual($actual, $expected, $desc);

$desc = 'empty string';
$actual = '';
$expected = '';
reverseWords($actual);
assertEqual($actual, $expected, $desc);

function assertEqual($a, $b, $desc)
{
    if ($a === $b) {
        echo "$desc ... PASS\n";
    } else {
        echo "$desc ... FAIL: $a != $b\n";
    }
}
