<?php 
/**
 * v1.4 新增 find_col_array 將特定的資料欄位當作陣列搜尋內容
 * v1.3 新增 select_col 可以取得二維陣列的特定子欄位如果沒有就填 ""
 * v1.2 新增 distinct 取得不重複資料
 * v1.1 find_like 比對正則式修正 ＠ James Chou 2019-09-26
 * v1 James Chou 2019-09-19
 * find_like  模糊比對內容
 * order_by 二維陣列排序
 * v0 James Chou 2019-09-12
 * 陣列處理 二維陣列補充包 
 */
class Arr
{
    // 將特定的資料欄位當作陣列搜尋內容
    function find_col_array($arr,$col,$target){
        $res = [];
        foreach ($arr as $key => $value) {
            # code...
            try {
                $s_arr = explode(',',$value[$col]);
                if(in_array($target,$s_arr)){
                    $res[] = $value;
                }
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }
        return $res;
    }

    // 可以取得二維陣列的特定子欄位如果沒有就填 ""
    function select_col($arr,$cols){
        $new = array();
        foreach($arr as $key => $value){
            $new_sub = array();
            foreach($cols as $kc=>$vc){
                $new_sub[$vc] = '';
            }
            foreach($value as $k=>$v){
                if(in_array($k,$cols)){
                    $new_sub[$k] = $v;
                }
            }
            $new[] = $new_sub;
        }
        return $new;
    }
    /**
     * 取得不重複資料
     */
    function distinct($arr,$distinct_key){
        $new = array();
        foreach ($arr as $key => $value) {
            # code...
            if(!$this->in_array($new,$distinct_key,$value[$distinct_key])){
                $new[] = $value; 
            }
        }
        return $new;
    }
    /**
     * 確認某個 key 的 value 在二維陣列中
     * arr 原始二維陣列
     * key 
     * value
     * 
     * 回傳 true 存在 ，不存在 false
     */
    function in_array($arr,$key,$value){
        foreach($arr as $k=>$v){
            if($v[$key] == $value){
                return TRUE;
            }
        }
        return FALSE;
    }

    

    /**
     * 把記憶體當資料庫使用～ where
     * $where參數請帶陣列
     * $where = array(
     *  col_1=>val_1,
     *  col_2=>val_2
     * );
     */
    function where($arr,$where){
        $res = array();
        foreach ($arr as $key => $value) {
            $w = true;
            foreach ($where as $k => $v) {
                if($value[$k] != $v){
                    $w = false;
                }
            }
            if($w == true){
                $res[] = $value;
            }
        }
        return $res;
    }
    /**
     * 把記憶體當資料庫使用～ like
     *  $arr 來源陣列
     *  $col 要篩選的欄位（以單為陣列表示）
     *  $value 要找的值
     */
    function find_like($arr,$col,$value){
        
        if($value == ''){
            return $arr;
        }
        $arr = array_values($arr);
        $res = array();
        $arr_temp = array();
        foreach($arr as $k=>$v){
            $sv = '';
            foreach($v as $k2=>$v2){
                if(in_array($k2,$col)){ // 
                    $sv = $sv.$v2;
                }
            }
            $arr_temp[] = $sv;
        }
        foreach($arr_temp as $k3=>$v3){
            $reg = "/".$value."/i";
            if(preg_match($reg,(string)$v3,$matches)){//比對文字內容
                $res[] = $arr[$k3];
            }
        }
        
        return $res;
    }
    /**
     * 把記憶體當資料庫使用～ order_by
     * $arr  來源陣列
     * col 目標排序欄位
     * type asc , desc
     * 
     */
    function order_by($arr,$col,$type){
        $res = array();
        foreach ($arr as $v) {
            $res[] = $v[$col];
        }
        if($type == 'asc'){
            array_multisort($res, SORT_ASC, $arr);    
        }else{
            array_multisort($res, SORT_DESC, $arr);
        }
        return $arr;
        
    }
    /**
     * 把記憶體當資料庫使用～ group_by
     * $arr 原始陣列
     * $group_by 要被 group_by 的欄位
     * $where參數請帶陣列
     * $where = array(
     *  col_1=>val_1,
     *  col_2=>val_2
     * );
     */
    function group_by($arr,$group_by,$where=''){
        $res = array();
        // 如果需要where 功能先過濾需要的 start
        if($where != ""){
            $arr = $this->where($arr, $where);
        }
        // 如果需要where 功能先過濾需要的 end
        foreach ($arr as $key => $value) {
            # code...
            if(!$this->in_array($res,$group_by,$value[$group_by])){
                $res[] = $value;
            }
        }
        return $res;
    }

    function sum($arr,$col,$where=''){
        $res = 0;
        // 如果需要where 功能先過濾需要的 start
        if($where != ""){
            $arr = $this->where($arr, $where);
        }
        // 如果需要where 功能先過濾需要的 end
        
        $a = array_column($arr,$col);
        return array_sum($a);

    }
    
}
?>
