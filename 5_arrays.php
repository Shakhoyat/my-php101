<?php
// Indexed array
$colors = array("red", "green", "blue");
echo "<pre>"; // Optional: for better formatting in a browser
print_r($colors);


$fruits = array("Apple", "Banana", "Cherry");
echo $fruits[1]; // Banana
echo "<br>";
$fruits[4] = "Grapes"; // Add element
print_r($fruits);

//mixed type arrays in php
$mixed = array("Hello", 42, 3.14, true);
print_r($mixed);

// Associative array
$person = array(
    "name" => "John",
    "age" => 30,
    "cities" => array("New York", "Los Angeles")
);
echo $person["name"] . "<br>"; // John
echo $person["cities"][0] . "<br>"; // New York
var_dump($person) . "<br>";

// Multidimensional array
$students = array(
    array("name" => "Alice", "age" => 20),
    array("name" => "Bob", "age" => 22)
);
echo $students[0]["name"]; // Alice
print_r($students);

// Array functions
array_push($fruits, "Orange"); // Add to end
array_pop($fruits); // Remove from end
array_shift($fruits); // Remove from beginning
array_unshift($fruits, "Mango"); // Add to beginning
print_r($fruits);
echo count($fruits); // Number of elements
sort($fruits); // Sort array
echo "</pre>";
