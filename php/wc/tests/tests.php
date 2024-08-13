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
$tests->assertEqual(31, $result);

$tests->testDescription('Test get_wordcount with simple string');
$result = $ccwc->get_wordcount($startcount, $simple_teststring);
$tests->assertEqual(5, $result);

$tests->testDescription('Test linecount - this one is kinda silly');
$result = $ccwc->get_linecount($startcount, $simple_teststring);
$tests->assertEqual(1, $result);

$test_argv1 = array('test.php', '-c', 'test.txt');

$tests->testDescription('Test get_bytecount with test.txt');
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->bytecount;
$tests->assertEqual(342190, $result);

$test_argv1[1] ='-l';
$tests->testDescription('Test get_linecount with test.txt');
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->linecount;
$tests->assertEqual(7145, $result);

$test_argv1[1] ='-w';
$tests->testDescription('Test get_wordcount with test.txt');
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->wordcount;
$tests->assertEqual(58164, $result);


$tests->summary();
