<?php
// difference between == and ===
$a = 5; // integer
$b = "5"; // string

if ($a == $b) {
    echo "Equal (==)"; // true, value is equal
}

if ($a === $b) {
    echo "Identical (===)"; // false, type is not equal
}
// if-else statement
$age = 20;
if ($age < 18) {
    echo "You are a minor.<br>";
} else {
    echo "You are an adult.<br>";
}
// if-elseif-else statement
$score = 85;
if ($score >= 90) {
    echo "Grade: A<br>";
} elseif ($score >= 80) {
    echo "Grade: B<br>";
} elseif ($score >= 70) {
    echo "Grade: C<br>";
} else {
    echo "Grade: F<br>";
}
// switch statement
$day = 3;
switch ($day) {
    case 1:
        echo "Monday<br>";
        break;
    case 2:
        echo "Tuesday<br>";
        break;
    case 3:
        echo "Wednesday<br>";
        break;
    case 4:
        echo "Thursday<br>";
        break;
    case 5:
        echo "Friday<br>";
        break;
    case 6:
        echo "Saturday<br>";
        break;
    case 7:
        echo "Sunday<br>";
        break;
    default:
        echo "Invalid day<br>";
        break;
}
// Don't remove this closing tag