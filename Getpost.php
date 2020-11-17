<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * v1 解析二維陣列資料
 * v.02  chk_assign_val  檢查限定內容欄位
 * v.01  過濾必填與非必填功能
 * 
 *
 **/
class Getpost
{
    //二維陣列解析驗證 資料來源輸入 post json
	function array2d_json_format($request,$requred= array()){
        $input_data = file_get_contents('php://input');
        if($input_data != ''){  
            $init_data = json_decode($input_data, true);
            return $this->array2d_array_format($request,$requred,$init_data);
        }else{
            return false;
        }
        
    }
    // 資料來源輸入陣列
    function array2d_array_format($request,$requred,$init_data){
        try {
            //code...
            $res = array();
            foreach ($init_data as $key => $value) { //拆解2d
                # code...
                // print_r($value);
                $r = array();
                foreach ($value as $k => $v) { //驗證欄位
                    # code...
                    // 寫入所有需要的欄位
                    foreach($request as $v1) { 
                        if(!in_array($v1, $requred)){ // 如果不是必填
                            if(isset($value[$v1])){
                                $r[$v1] = $value[$v1];
                            }else{
                                $value[$v1] = '';
                            }
                        }else{
                            if(!isset($value[$v1])){
                                return false;
                            }else{
                                $r[$v1] = $value[$v1];
                            }
                        }
                    }
                }
                $res[] = $r;
            }
            return $res;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        
    }
// 將需要的GET POST 資料轉成一個陣列處理 res 陣列回傳	
// data 取得所有要拿的資料
// requred 需要必填的資料
    function getpost_array($data, $requred = array())
    {
        $CI = &get_instance();
        $CI->load->helper('url');
        $res = array();
        foreach ($data as $key => $value) {
			# code...
            if (in_array($value, $requred)) {
                if ($CI->input->get_post($value) == "") {
                    return false;
                } else {
                    $res[$value] = $CI->input->get_post($value);
                }
            } else {
                $res[$value] = $CI->input->get_post($value);
            }

        }
        return $res;
    }

    function get_in_datalist_post_array($data, $requred = array())
    {
        $CI = &get_instance();
        $CI->load->helper('url');
        $res = array();
        foreach ($data as $key => $value) {
			# code...
            if (in_array($value, $requred)) {
                if (!isset($CI->input->post()['data_list'][$value]) OR $CI->input->post()['data_list'][$value] == "") {
                    return false;
                } else {
                    $res[$value] = $CI->input->post()['data_list'][$value];
                }
            } else {
                if(isset($CI->input->post()['data_list'][$value])){
                    $res[$value] = $CI->input->post()['data_list'][$value];
                }else{
                    $res[$value] = '';
                }
            }

        }
        return $res;
    }    

// 檢查必填資料，沒有被填寫到的資料就會被丟回陣列回傳
    function report_requred($data)
    {
        $CI = &get_instance();
        $CI->load->helper('url');
        $res = array();
        foreach ($data as $key => $value) {
            if ($CI->input->get_post($value) == "") {
                $res[] = $value;
            }
        }
        return $res;
    }

    function report_requred_post($data)
    {
        $CI = &get_instance();
        $CI->load->helper('url');
        $res = array();
        foreach ($data as $key => $value) {
            if ($CI->input->post()['data_list'][$value] == "") {
                $res[] = $value;
            }
        }
        return $res;
    }

// 檢查限定內容欄位
    function chk_assign_val($value, $assign_val)
    {
        foreach ($assign_val as $k => $v) {
			# code...
            if ($v == $value) {
                return true;
            }
        }
        return false;
    }
}
/* End of file Getpost.php */
/* Location: ./application/libraries/Getpost.php */
