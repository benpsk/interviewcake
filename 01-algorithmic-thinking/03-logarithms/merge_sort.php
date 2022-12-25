<?php
function mergeSort($arrayToSort)
{
    // BASE CASE: arrays with fewer than 2 elements are sorted
    if (count($arrayToSort) < 2) {
        return $arrayToSort;
    }

    // STEP 1: divide the array in half
    // we need to round down to avoid getting a "half index"
    $midIndex = floor(count($arrayToSort) / 2);

    $left  = array_slice($arrayToSort, 0, $midIndex);
    $right = array_slice($arrayToSort, $midIndex);

    // STEP 2: sort each half
    $sortedLeft  = mergeSort($left);
    $sortedRight = mergeSort($right);

    // STEP 3: merge the sorted halves
    $sortedArray = [];
    $currentIndexLeft = 0;
    $currentIndexRight = 0;

    while (count($sortedArray) < count($left) + count($right)) {

        // sortedLeft's first element comes next
        // if it's less than sortedRight's first
        // element or if sortedRight is exhausted
        if (
            $currentIndexLeft < count($left) &&
            ($currentIndexRight == count($right) ||
                $sortedLeft[$currentIndexLeft] < $sortedRight[$currentIndexRight])
        ) {
            array_push($sortedArray, $sortedLeft[$currentIndexLeft]);
            $currentIndexLeft += 1;
        } else {
            array_push($sortedArray, $sortedRight[$currentIndexRight]);
            $currentIndexRight += 1;
        }
    }

    return $sortedArray;
}
