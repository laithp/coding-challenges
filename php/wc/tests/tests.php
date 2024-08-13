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
    $ccwc = new CCWC();
    $result = $ccwc->get_bytecount($startcount, $simple_teststring);
    $r = $tests->assertEqual(31, $result);
    $tests->testResults($r);

$tests->testDescription('Test get_wordcount with simple string');
$ccwc = new CCWC();
$result = $ccwc->get_wordcount($startcount, $simple_teststring);
$tests->assertEqual(5, $result);
$tests->testResults($r);

$tests->testDescription('Test linecount - this one is kinda silly');
$ccwc = new CCWC();
$result = $ccwc->get_linecount($startcount, $simple_teststring);
$r = $tests->assertEqual(1, $result);
$tests->testResults($r);

$test_argv1 = array('test.php', '-c', 'test.txt');

$tests->testDescription('Test get_bytecount with test.txt');
$ccwc = new CCWC();
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->bytecount;
$r = $tests->assertEqual(342190, $result);
$tests->testResults($r);

$test_argv1[1] = '-l';
$tests->testDescription('Test get_linecount with test.txt');
$ccwc = new CCWC();
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->linecount;
$r = $tests->assertEqual(7145, $result);
$tests->testResults($r);


$test_argv1[1] = '-w';
$tests->testDescription('Test get_wordcount with test.txt');
$ccwc = new CCWC();
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->wordcount;
$r = $tests->assertEqual(58164, $result);
$tests->testResults($r);

$test_argv1[1] = '-cl';
$tests->testDescription('Test get_bytecount & get_linecount with test.txt');
$ccwc = new CCWC();
$ccwc->process(count($test_argv1), $test_argv1);
$result = $ccwc->bytecount;
$r = $tests->assertEqual(342190, $result);
$result2 = $ccwc->linecount;
$r2 = $tests->assertEqual(7145, $result2);
$tests->testResults($r&&$r2);

$tests->summary();
