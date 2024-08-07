<?php
/**
* ccwc class file implementation of the wc tool
*
*/

class CCWC {

    const FILECHUNKSIZE = 100000;

    public $file = null;

    public $bytesflag = false;
    public $bytecount = 0;

    public $linesflag = false;
    public $linecount = 0;

    public $wordsflag = false;
    public $wordcount = 0;

    function __construct($argc, $argv)
    {
 
        if($argc<3){
           $this->report_error(
            "ERROR: ccwc expects directive and file as parameters\n"
                . "like: 'ccwc.php -c file.txt'\n");
            exit;
        }
        
        $this->parse_flags($argv[1]);

        $filename = $argv[2];
        $this->file = fopen($filename,"r");
        
        while($filestring = fread($this->file,self::FILECHUNKSIZE)){

            if($this->bytesflag){
                $this->bytecount = $this->get_bytecount($this->bytecount, $filestring);
            }
            if($this->linesflag){
                $this->linecount = $this->get_linecount($this->linecount, $filestring);
            }

        }
        echo $this->bytecount;
        echo " ";
        echo $this->linecount;
        echo " ";
        echo $this->wordcount;
        echo " ";
        echo $filename;
        /*
        switch($argv[1]){
            case '-d': //bytes in file - direct php implemenation
            case '-n': //characters in file - my locale doesn't support multibyte  - direct php implemenation
                echo $this->php_get_bytecount($filename);
                break;
            case '-w': //words in file
                echo $this->get_wordcount($filename);
                break;
            case '-x': //words in file - direct php implemenation
                echo $this->php_get_wordcount($filename);
                break;

            default:
                $this->report_error("ERROR: directive not recognized\n");
        }*/
        
    }

    function parse_flags($param){
        echo $param;
        $this->bytesflag = (strstr($param,'c'))?true:false; //bytes in file
            $this->bytesflag = (strstr($param,'m'))?true:false; //characters in file - my locale doesn't support multibyte

        $this->linesflag = (strstr($param,'l'))?true:false; //lines in file

        
    }

    function get_bytecount($bytecount, $filestring) {
        // -c
        //This function will open the file 
        // and by iterating over it get the number of bytes
        //
        // expected result from cc test.txt = 342190 
        //
        // NOTE: a simple way to do it would be to just use the php internal filesize()
    
        $bytecount += strlen($filestring);
        return $bytecount;
    }

    function get_linecount($linecount, $filestring) {
        // -l
        //This function will open the file
        // and by iterating over it and counting the number of newlines
        // determine the number of lines in the file 
        //
        // expected result from cc test.txt = 7145 
        //
        // first pass I used strpos, however this resulted in an undercount when there are blank lines
        //
        // NOTE: - simpler way ? -
        
            $pieces = explode("\n",$filestring);
            $linecount = $linecount + count($pieces) - 1 ; // subtracting 1 fixes for an overcount condition
    
        return $linecount;
    }




    function get_wordcount($filename) {
        // -w
        //This function will open the file and itterate
        // to get the wordcount
        //
        // expected result from cc text.txt = 58164 
        // 
        // NOTE: - simpler way use str_word_count() ?

        $wordcount = 0;
        while($str = fread($this->file,self::FILECHUNKSIZE)){
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
                
            }
             
        }
        return $wordcount;

    }

    function php_get_wordcount($filename) {
        //Simpler way using str_word_count()
        //
        // expected result from cc text.txt = 58164 

        $wordcount = 0;
        while($str = fread($this->file,self::FILECHUNKSIZE)){
            $wordcount += str_word_count($str);
        }
        return $wordcount;
    }




    function php_get_bytecount($filename) {
        //simpler using filesize()
        //
        // expected result from cc test.txt = 342190 
        return filesize($filename);
    }

    function report_error($message){
        echo $message;
    }

}