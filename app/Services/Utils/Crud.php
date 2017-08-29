<?php namespace App\Services\Utils;


class Crud{

    public function generateCrud(){
        $old = "Analysis";
        $new = "AnalysisExam";

        $dirbase = "C:\\Users\\adhemar\\bj20\\brasiljuridico\\";

        $from = $dirbase . "\\app\\Http\\Controllers\\Backend\\" . $old . "Controller.php";
        $to = $dirbase . "\\app\\Http\\Controllers\\Backend\\" . $new . "Controller.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Http\\Routes\\Backend\\" . $old . "s.php";
        $to = $dirbase . "\\app\\Http\\Routes\\Backend\\" . $new . "s.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Providers\\" . $old . "ServiceProvider.php";
        $to = $dirbase . "\\app\\Providers\\". $new . "ServiceProvider.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Repositories\\Backend\\" . $old . "\\" . $old . "Contract.php";
        $to = $dirbase . "\\app\\Repositories\\Backend\\" . $new . "\\" . $new . "Contract.php";
        if (file_exists($dirbase . "\\app\\Repositories\\Backend\\" . $new . "\\")  == false) mkdir( $dirbase . "\\app\\Repositories\\Backend\\" . $new . "\\" );
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Repositories\\Backend\\" . $old . "\\Eloquent" . $old . "Repository.php";
        $to = $dirbase . "\\app\\Repositories\\Backend\\" . $new . "\\Eloquent" . $new . "Repository.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Services\\" .$old  . "\\Traits\\" . $old . "Attributes.php";
        $to = $dirbase . "\\app\\Services\\" .$new  . "\\Traits\\" . $new . "Attributes.php";
        if (file_exists($dirbase . "\\app\\Services\\" .$new  . "\\")  == false) mkdir( $dirbase . "\\app\\Services\\" .$new  . "\\" );
        if (file_exists($dirbase . "\\app\\Services\\" .$new  . "\\Traits\\")  == false) mkdir( $dirbase . "\\app\\Services\\" .$new  . "\\Traits\\" );
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Http\\Requests\\Backend\\" .$old  . "\\Create" . $old . "Request.php";
        $to = $dirbase . "\\app\\Http\\Requests\\Backend\\" .$new  . "\\Create" . $new . "Request.php";
        if (file_exists($dirbase . "\\app\\Http\\Requests\\Backend\\" .$new  . "\\")  == false) mkdir( $dirbase . "\\app\\Http\\Requests\\Backend\\" .$new  . "\\" );
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\app\\Http\\Requests\\Backend\\" .$old  . "\\Update" . $old . "Request.php";
        $to = $dirbase . "\\app\\Http\\Requests\\Backend\\" .$new  . "\\Update" . $new . "Request.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\resources\\views\\backend\\" . strtolower($old)  . "s\\index.blade.php";
        $to = $dirbase . "\\resources\\views\\backend\\" . strtolower($new)  . "s\\index.blade.php";
        if (file_exists($dirbase . "\\resources\\views\\backend\\" . strtolower($new)  . "s\\")  == false) mkdir( $dirbase . "\\resources\\views\\backend\\" . strtolower($new)  . "s\\" );
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\resources\\views\\backend\\" . strtolower($old)  . "s\\create.blade.php";
        $to = $dirbase . "\\resources\\views\\backend\\" . strtolower($new)  . "s\\create.blade.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        $from = $dirbase . "\\resources\\views\\backend\\" . strtolower($old)  . "s\\edit.blade.php";
        $to = $dirbase . "\\resources\\views\\backend\\" . strtolower($new)  . "s\\edit.blade.php";
        copy($from, $to);
        $this->replaceContent($old, $new, $to);

        //adicionar rota nou routes.php
        // serviceprovider no app.php
        //traducoes
        //sidebar
        //criar autorizacao

    }

    public function replaceContent($old, $new, $file){
        $str=file_get_contents( $file );
        $str=str_replace("$old", "$new",$str);
        $str=str_replace(strtolower("$old"), strtolower("$new"),$str);
        file_put_contents($file, $str);

    }

}