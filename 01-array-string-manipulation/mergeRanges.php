<?php
class Meeting
{
    private $startTime;
    private $endTime;

    public function __construct($startTime, $endTime)
    {
        // number of 30 min blocks past 9:00 am
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function __toString()
    {
        return "($this->startTime, $this->endTime)";
    }
}


function mergeRanges($meetings)
{
    // single object array
    if (count($meetings) == 1) {
        return $meetings;
    }

    $meetingsCopy = [];
    foreach ($meetings as $meeting) {
        $meetingsCopy[] = clone $meeting;
    }

    // sort by start time
    $sortedMeetings = $meetingsCopy;
    usort($sortedMeetings, 'compareMeetingsByStartTime');

    // initialize mergedMeetings with the earliest meeting
    $mergedMeetings = [$sortedMeetings[0]];

    for ($i = 1; $i < count($sortedMeetings); $i++) {
        $currentMeeting = $sortedMeetings[$i];
        $lastMergedMeeting = $mergedMeetings[count($mergedMeetings) - 1];

        // if the current meeting overlaps with the last merged meeting, use the
        // later end time of the two
        if ($currentMeeting->getStartTime() <= $lastMergedMeeting->getEndTime()) {
            $latestEndTime = max($lastMergedMeeting->getEndTime(), $currentMeeting->getEndTime());
            $lastMergedMeeting->setEndTime($latestEndTime);

            // add the current meeting since it doesn't overlap
        } else {
            $mergedMeetings[] = $currentMeeting;
        }
    }

    return $mergedMeetings;
}

function compareMeetingsByStartTime($meetingA, $meetingB)
{
    return $meetingA->getStartTime() > $meetingB->getStartTime() ? 1 : -1;
}




// tests

$desc = 'single data';
$actual = mergeRanges([new Meeting(2, 4)]);
$expected = [new Meeting(2, 4)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'meetings overlap';
$actual = mergeRanges([new Meeting(1, 3), new Meeting(2, 4)]);
$expected = [new Meeting(1, 4)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'meetings touch';
$actual = mergeRanges([new Meeting(5, 6), new Meeting(6, 8)]);
$expected = [new Meeting(5, 8)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'meeting contains other meeting';
$actual = mergeRanges([new Meeting(1, 8), new Meeting(2, 5)]);
$expected = [new Meeting(1, 8)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'meetings stay separate';
$actual = mergeRanges([new Meeting(1, 3), new Meeting(4, 8)]);
$expected = [new Meeting(1, 3), new Meeting(4, 8)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'multiple merged meetings';
$actual = mergeRanges([
    new Meeting(1, 4),
    new Meeting(2, 5),
    new Meeting(5, 8)
]);
$expected = [new Meeting(1, 8)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'meetings not sorted';
$actual = mergeRanges([
    new Meeting(5, 8),
    new Meeting(1, 4),
    new Meeting(6, 8)
]);
$expected = [new Meeting(1, 4), new Meeting(5, 8)];
assertArrayEquals($actual, $expected, $desc);

$desc = 'one long meeting contains smaller meetings';
$actual = mergeRanges([
    new Meeting(1, 10),
    new Meeting(2, 5),
    new Meeting(6, 8),
    new Meeting(9, 10),
    new Meeting(10, 12)
]);
$expected = mergeRanges([
    new Meeting(1, 12),
]);
assertArrayEquals($actual, $expected, $desc);

$desc = 'sample input';
$actual = mergeRanges([
    new Meeting(0, 1),
    new Meeting(3, 5),
    new Meeting(4, 8),
    new Meeting(10, 12),
    new Meeting(9, 10)
]);
$expected = mergeRanges([
    new Meeting(0, 1),
    new Meeting(3, 8),
    new Meeting(9, 12)
]);
assertArrayEquals($actual, $expected, $desc);

function assertArrayEquals($a, $b, $desc)
{
    $serializedA = serialize($a);
    $serializedB = serialize($b);

    if ($serializedA === $serializedB) {
        echo "$desc ... PASS\n";
    } else {
        echo "$desc ... FAIL: " . arrayToString($a) . " != " . arrayToString($b) . "\n";
    }
}

function arrayToString($array)
{
    return "[" . implode($array, ',') . "]";
}
