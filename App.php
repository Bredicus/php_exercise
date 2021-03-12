<?php

require_once('Command.php');

$userInput = trim($_POST['userinput']);
$inputArray = explode(" ", $userInput);
$inputCommand = array_shift($inputArray);

if (strpos($inputCommand, '-') !== false) {
    $inputCommand = str_replace('-', '', $inputCommand);
}
$inputArray = array_filter($inputArray, fn($value) => !is_null($value) && $value !== '');

if (class_exists($inputCommand)) {
    $commandObj = new $inputCommand();
    $commandObj->printResult($inputArray);
}
else {
    print("Command not found");
}

?>