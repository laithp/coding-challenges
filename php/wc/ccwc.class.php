<?php
/**
* ccwc class file implementation of the wc tool
*
*/

class CCWC {

    function report_error($message){
        echo $message;
    }

    function __construct($argc, $argv)
    {
 
        if($argc<3){
           $this->report_error(
            "ERROR: ccwc expects directive and file as parameters\n"
                . "like: 'ccwc.php -c file.txt'\n");
            exit;
        }
        
        $filename = $argv[2];
        switch($argv[1]){
            case '-c': //bytes in file
                echo $this->get_bytecount($filename);
                break;
            case '-cp': //direct php implemenation
                echo $this->php_get_bytecount($filename);
                break;
            case '-l': //lines in file
                echo $this->get_linecount($filename);
                break;
     
            default:
                $this->report_error("ERROR: directive not recognized\n");
        }
        echo " ";
        echo $filename;
    }

    function get_linecount($filename) {
        //This function will open the file
        // and by iterating over it and counting the number of newlines
        // determine the number of lines in the file 
        //
        // expected result from cc test.txt = 7145 
        //
        // first pass I used strpos, however this resulted in an undercount when there are blank lines
        //
        // NOTE: - simpler way ? -

        $fp = fopen($filename,"r");

        $linecount = 0;
        while($str = fread($fp,1000)){
            $pieces = explode("\n",$str);
            $linecount = $linecount + count($pieces) - 1 ; // subtracting 1 fixes for an overcount condition
        }
        return $linecount;
    }

    function get_bytecount($filename) {
        //This function will open the file 
        // and by iterating over it get the number of bytes
        //
        // expected result from cc test.txt = 342190 
        //
        // NOTE: a simple way to do it would be to just use the php internal filesize()
       
        $fp = fopen($filename,"r");

        $bitecount = 0;
        while($str = fread($fp,1000)){
            $bitecount += strlen($str);
        }
        return $bitecount;
    }

    function php_get_bytecount($filename) {
        //simpler using filesize()
        //
        // expected result from cc test.txt = 342190 
        return filesize($filename);
    }

}