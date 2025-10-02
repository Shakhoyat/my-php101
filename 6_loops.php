<?php

// for loop
for ($i = 1; $i <= 5; $i++) {
    echo " $i<br>";
}

// while loop
$j = 1;
while ($j <= 5) {
    echo "Count: $j<br>";
    $j++;
}

// for-each loop
$colors = array("red", "green", "blue");
foreach ($colors as $color) {
    echo "Color: $color <br>";
}
// do-while loop
$k = 1;
do {
    echo " $k<br>";
    $k++;
} while ($k <= 5);

// Don't remove this closing tag