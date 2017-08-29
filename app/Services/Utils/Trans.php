<?php namespace App\Services\Utils;


class Trans{

    public function pendingTrans(){
        $dirbase = "C:\\Users\\adhemar\\bj20\\brasiljuridico\\app\\Http\\Controllers\\";

        return $this->listFolderFiles($dirbase);

    }

    function listFolderFiles($dir){
        $ffs = scandir($dir);
        $ret = ''; //'<ul>';
        foreach($ffs as $ff){
            if($ff != '.' && $ff != '..'){
                //$ret = $ret . '<li>'.$ff;
                if(is_dir($dir.'/'.$ff)){
                    $ret = $ret . $this->listFolderFiles($dir.'/'.$ff);
                } else {
                    $str = file_get_contents( $dir.'/'.$ff );
                    if (strlen($str) != 0){
                        $ret = $ret . $this->pendingTransStr( $str );
                    }
                }
                //$ret = $ret . '</li>';


            }
        }
        $ret = $ret . ''; //'</ul>';
        return $ret;
    }

    function pendingTransStr( $str ){
        $pos = 1;
        //$ret = '<ul>';
        $ret = '';
        while ($pos != 0){
            $pos = strpos($str, 'trans(', $pos + 1);
            if ($pos != 0){
                $posclose = strpos($str, ')', $pos + 1);
                if (($posclose != 0) && ($posclose > $pos)) {
                    $translabel = substr($str, $pos + 7, $posclose - $pos - 8);
                    $transResult = trans($translabel);
                    if ($translabel === $transResult) {
                        $ret = $ret . $translabel . '<br/>';
                    }
                }
                $pos = $pos + 1;
            }
        }
        //$ret = $ret . '</ul>';
        return $ret;
    }

}