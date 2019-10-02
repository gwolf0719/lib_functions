<?php
class Debug 
{

    // v0 @james
    /**
     * 
     * 印出陣列內容
     * 如果 index.php 中設定 ENVIRONMENT 為 production 就自動略過
     * @param array 要印的陣列內容
     * @param cutoff 預設要截斷後面的顯示
     */
    function print_array($array,$cutoff=true,$format='array'){
        if(ENVIRONMENT === 'production'){

        }else{
            if($format == 'array'){
                echo $this->memory_use_now('print_array');
                print_r($array);
            }else{
                $json['array_info']= $array;
                $json['memory']=$this->memory_use_now('print_array');
                echo json_encode($json);
            }
            
            
            if($cutoff == true){
                exit();
            }
        }

    }
    
    // 檢測使用的記憶體
    function memory_use_now($name)
    {
        $level = array('Bytes', 'KB', 'MB', 'GB');
        $n = memory_get_usage();
        for ($i=0, $max=count($level); $i<$max; $i++)
        {
            if ($n < 1024)
            {
                $n = round($n, 2);
                return $name .' used memory:'."{$n} {$level[$i]}";
            }
            $n /= 1024;
        }
    }
}
