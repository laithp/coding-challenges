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
            case '-m': //characters in file - my locale doesn't support multibyte 
                echo $this->get_bytecount($filename);
                break;
            case '-d': //bytes in file - direct php implemenation
            case '-n': //characters in file - my locale doesn't support multibyte  - direct php implemenation
                echo $this->php_get_bytecount($filename);
                break;
            case '-l': //lines in file
                echo $this->get_linecount($filename);
                break;
            case '-w': //words in file
                echo $this->get_wordcount($filename);
                break;
            case '-x': //words in file - direct php implemenation
                echo $this->php_get_wordcount($filename);
                break;

            default:
                $this->report_error("ERROR: directive not recognized\n");
        }
        echo " ";
        echo $filename;
    }

    function get_wordcount($filename) {
        //This function will open the file and itterate
        // to get the wordcount
        //
        // expected result from cc text.txt = 58164 
        // 
        // NOTE: - simpler way use str_word_count() ?

        $fp = fopen($filename,"r");

        $wordcount = 0;
        while($str = fread($fp,10000)){
            //need to handle rn type linefeeds
            $normalized_str = str_replace("\r\n","\n",$str);

            //need to handle r alone if it happens ?
            $clean_normalized_str = str_replace("\r","\n",$normalized_str);

            //clear out newlines
            $newlines_removed_str = str_replace("\n"," ",$clean_normalized_str);

            if(strlen($newlines_removed_str)>0){ 
                $words = explode(" ",$newlines_removed_str);
                foreach($words as $word){
                    if(strlen($word)>0){
                        $wordcount++;
                    }
                }
                //$wordcount = $wordcount + count($words) - 1;
            }
             
        }
        return $wordcount;

    }

    function php_get_wordcount($filename) {
        //Simpler way using str_word_count()
        //
        // expected result from cc text.txt = 58164 
        $fp = fopen($filename,"r");

        $wordcount = 0;
        while($str = fread($fp,10000)){
            $wordcount += str_word_count($str);
        }
        return $wordcount;
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