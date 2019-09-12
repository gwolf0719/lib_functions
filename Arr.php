<?php 
/**
 * v0 James Chou 2019-09-12
 * 陣列處理 二維陣列補充包 
 */
class Arr
{
    
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
    
}
?>
