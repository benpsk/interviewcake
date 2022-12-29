<?php

function getIthItemInLinkedList($head, $i)
{
    if ($i < 0) {
        throw new InvalidArgumentException("i can't be negative: $i");
    }

    $currentNode = $head;
    $currentPosition = 0;

    while ($currentNode) {

        if ($currentPosition == $i) {
            // found it!
            return $currentNode;
        }

        // move on to the next node
        $currentNode = $currentNode->getNext();
        $currentPosition += 1;
    }

    throw new InvalidArgumentException("List has fewer than i + 1 ($i) nodes");
}
