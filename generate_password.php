<?php
// rand("");
$pattern = "GA0a!b1|cBdN@efg2hCiH3`jkD#lP4OmM%n^JVo\Q5pRE_<q=)SIK9rs6&tT*uUF,L-(vZ/7w~Wx+8yX>zY";
$length= strlen($pattern);
$password = [];
// $pass=  $pattern[rand(0,83)];
for ($i=0; $i < 8; $i++) { 
    $index = rand(0,$length-1);
    // There’s a small issue with your code: the rand(0, $length) will sometimes pick an index out of bounds because strlen($pattern) returns the number of characters, but the index starts from 0. So, the maximum index should be $length - 1.
    $password[] = $pattern[$index];
}
echo implode($password);
?>