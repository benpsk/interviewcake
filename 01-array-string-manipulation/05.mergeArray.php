<?php

function mergeArrays($myArray, $alicesArray)
{
    // // combine the sorted arrays into one large sorted array
    // if (count($myArray) < 1 && count($alicesArray) < 1) {
    //     return [];
    // }

    // $mergeArray = array_merge($myArray, $alicesArray);

    // sort($mergeArray);

    // return $mergeArray;


    // set up our mergedArray
    $mergedArray = [];

    $currentIndexAlices = 0;
    $currentIndexMine   = 0;
    $currentIndexMerged = 0;

    while ($currentIndexMerged < (count($myArray) + count($alicesArray))) {

        $isMyArrayExhausted = $currentIndexMine >= count($myArray);
        $isAlicesArrayExhausted = $currentIndexAlices >= count($alicesArray);

        // case: next comes from my array
        // my array must not be exhausted, and EITHER:
        // 1) Alice's array IS exhausted, or
        // 2) the current element in my array is less
        //    than the current element in Alice's array
        if (!$isMyArrayExhausted && ($isAlicesArrayExhausted
            || $myArray[$currentIndexMine] < $alicesArray[$currentIndexAlices])) {

            $mergedArray[$currentIndexMerged] = $myArray[$currentIndexMine];
            $currentIndexMine++;

            // case: next comes from Alice's array
        } else {
            $mergedArray[$currentIndexMerged] = $alicesArray[$currentIndexAlices];
            $currentIndexAlices++;
        }

        $currentIndexMerged++;
    }

    return $mergedArray;
}






// tests
$time_start = microtime(true);

$desc = 'both arrays are empty';
$myArray = [];
$alicesArray = [];
$expected = [];
$actual = mergeArrays($myArray, $alicesArray);
assertArrayEquals($actual, $expected, $desc);

$desc = 'first array is empty';
$myArray = [];
$alicesArray = [1, 2, 3];
$expected = [1, 2, 3];
$actual = mergeArrays($myArray, $alicesArray);
assertArrayEquals($actual, $expected, $desc);

$desc = 'second array is empty';
$myArray = [5, 6, 7];
$alicesArray = [];
$expected = [5, 6, 7];
$actual = mergeArrays($myArray, $alicesArray);
assertArrayEquals($actual, $expected, $desc);

$desc = 'both arrays have some numbers';
$myArray = [2, 4, 6];
$alicesArray = [1, 3, 7];
$expected = [1, 2, 3, 4, 6, 7];
$actual = mergeArrays($myArray, $alicesArray);
assertArrayEquals($actual, $expected, $desc);

$desc = 'arrays are different lengths';
$myArray = [2, 4, 6, 8];
$alicesArray = [1, 7];
$expected = [1, 2, 4, 6, 7, 8];
$actual = mergeArrays($myArray, $alicesArray);
assertArrayEquals($actual, $expected, $desc);

function assertArrayEquals($a, $b, $desc)
{
    sort($a);
    sort($b);
    $serializedA = json_encode($a);
    $serializedB = json_encode($b);

    if ($serializedA === $serializedB) {
        echo "$desc ... PASS\n";
    } else {
        echo "$desc ... FAIL: $serializedA != $serializedB\n";
    }
}


$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo 'Execution Time: ' . ($execution_time * 1000) . ' Milliseconds' . "\n";
