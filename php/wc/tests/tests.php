<?php

/**
 * I'm having issues getting phpunit setup in my current evironment, so I'm doing a freeform unit testing setup
 */

require('unit.class.php');

require('./ccwc.class.php');

$unittest = new UnitTest('CCWC');

$ccwc = new CCWC();

$startcount = 0;
$teststring = "abcdgefghigklmnop0987654321!";
$result = $ccwc->get_bytecount($startcount, $teststring);
if ($result == 27) {
    echo 'pass';
} else {
    echo 'fail';
}
