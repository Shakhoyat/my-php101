<?php
$number1 = 10;
$number2 = 3.5;
$sum = $number1 + $number2;
echo "The sum of $number1 and $number2 is: $sum<br>";
echo "Integer value: " . (int)$number2 . "<br>";
echo "Float value: " . (float)$number1 . "<br>";
echo "Formatted number: " . number_format($number1, 2) . "<br>";
$x = 5;
$y = 2;
echo "The value of x^y is: " . pow($x, $y) . "<br>";
echo $x ** $y . "<br>";
$y++;
echo "After increment, y is: $y<br>";
$y--;
echo "After decrement, y is: $y<br>";
$y -= 2;
echo "After decrementing by 2, y is: $y<br>";
$y += 10;
echo "After incrementing by 10, y is: $y<br>";




// Don't remove this closing tag