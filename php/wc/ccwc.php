<?php

/**
 * ccwc - A PHP implementation of the coding challenges "Build Your Own wc Tool"
 * 
 * by: Lathrop Preston (lathrop@prestonfam.org) github:@laithp
 * init: 2024-08-06
 * 
 */


require('ccwc.class.php');

$ccwc = new CCWC();
$ccwc->process($argc, $argv);
