<?php

function reverse(&$str)
{
    // reverse input array of characters in place
    // $str = strrev($str);

    $leftIndex = 0;
    $rightIndex = strlen($str) - 1;

    while (
        $leftIndex < $rightIndex
    ) {

        // swap characters
        $temp = $str[$leftIndex];
        $str[$leftIndex] = $str[$rightIndex];
        $str[$rightIndex] = $temp;

        // move towards middle
        $leftIndex++;
        $rightIndex--;
    }
}


// tests

$desc = 'empty string';
$actual = '';
$expected = '';
reverse($actual);
assertEqual($actual, $expected, $desc);

$desc = 'single character string';
$actual = 'A';
$expected = 'A';
reverse($actual);
assertEqual($actual, $expected, $desc);

$desc = 'longer string';
$actual = 'EDCBA';
$expected = 'ABCDE';
reverse($actual);
assertEqual($actual, $expected, $desc);

function assertEqual($a, $b, $desc)
{
    if ($a === $b) {
        echo "$desc ... PASS\n";
    } else {
        echo "$desc ... FAIL: $a != $b\n";
    }
}
