<?php
error_reporting(E_ALL);

require_once 'Person.php';
require_once 'Group.php';
require_once 'memory.php';



$group = Group::getInstance();
$group->setSourceFile('data.txt');


foreach($group->getFileContent() as $key => $value) {
    if ($value->getId() == 20000) {
        var_dump($value);
        echo '<br>';
        echo 'Life days count: ' . $value->lifeExpectancyCalculate();
        break;
    }
    $group->deletePersonById($key);
}

echo '<br>';
echo 'Mens percent: ' . $group->getGenderPercent('mu¾');

print "<br>" . formatBytes(memory_get_peak_usage()) . "<br>";







