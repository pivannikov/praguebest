<?php
error_reporting(E_ALL);

require_once 'Person.php';
require_once 'Group.php';
require_once 'memory.php';


$group = Group::getInstance();


$group->setSourceFile('data.txt');

$group->fillPersonsStorage();

echo '<pre>';
var_dump($group->getPersonsStorage());
echo '</pre>';

echo '<hr>';
var_dump($group->getPersonById(2));
echo '<hr>';
var_dump($group->getPersonById(2)->lifeExpectancyCalculate());

echo '<hr>';
var_dump($group->getGenderPercent('mu¾'));
echo '<hr>';

print "<br>" . formatBytes(memory_get_peak_usage()) . "<br>";






