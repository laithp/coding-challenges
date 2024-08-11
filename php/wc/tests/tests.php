<?php

/**
 * I'm having issues getting phpunit setup in my current evironment, so I'm doing a freeform unit testing setup
 */

require('./lp_unitframework.class.php'); 

require('../ccwc.class.php');


$ccwc = new CCWC();

$tests = new UnitFramework('CCWC');

$startcount = 0;
$simple_teststring = "abcdg ef ghigkl mnop09 87654321";


$tests->testDescription('Test get_bytecount with simple string');
    $result = $ccwc->get_bytecount($startcount, $simple_teststring);
$tests->assertEqual(31,$result);

$tests->testDescription('Test get_wordcount with simple string');
    $result = $ccwc->get_wordcount($startcount, $simple_teststring);
$tests->assertEqual(5,$result);

