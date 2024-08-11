<?php

/**
 * a simple php unit testing framework 
 * 
 * by Lathrop PrestonS
 * started: 2024-08-10
 */

class UnitTest
{

    public $theclass = null;

    function __construct($classname)
    {
        $this->theclass = new $classname();
    }
}
