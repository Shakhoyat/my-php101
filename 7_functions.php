<?php

//simple function
function hello()
{
    return "Hello, World!";
}
echo hello() . "<br>";

//function with parameters
function add($a, $b)
{
    return $a + $b;
}
echo "Addition: " . add(10, 5) . "<br>";
// function with default parameters
function greet($name = "Guest")
{
    return "Hello, $name!";
}
echo greet() . "<br>";
echo greet("Sujon") . "<br>";

// function with multiple parameters and error handling
function addMultiple(...$numbers)
{
    if (empty($numbers)) {
        return "No numbers provided";
    }
    return array_sum($numbers);
}
echo "Sum: " . addMultiple(1, 2, 3, 4, 5) . "<br>";
