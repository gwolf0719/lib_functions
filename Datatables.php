<?php 
class Datatables 
{
    /**
     * Datatables Server Side 解決方案
     * v1 James 2019 10 09
     * 
     */

    /**
     * 主要呼叫這個 full_data 即可
     * 前端需要載入 cdn 
     * <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
     * <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
     * 
     * 前端載入語法如下：
     * $('#datalist').DataTable(
     * {
     *           processing: true,  // 顯示載入中
     *           serverSide:true, // 使用 server api
     *           ajax:"./api/xxx/xxx?xxx", // api 路徑
     *           order : [6,'desc'] , // 排序方式
     *           columnDefs:[ // 不使用排序功能的欄位
     *               {
     *           　　　　targets : [7],
　　　*　                orderable : false
     *               }]
     *       }
     *   );
     * 
     * * @param datalist Array 完整的資料列表
     * * @param search_data_arr Array 允許被搜尋的欄位
     * * @param sort_arr  Array  允許排序的欄位
     */
    function full_data($datalist, $search_data_arr, $sort_arr){
        // 資料位篩選前總數
        $json_arr['recordsTotal'] = count($datalist);
        // 資料位搜尋
        $search_data = $this->find_like($datalist, $search_data_arr, $_GET['search']['value']);
        // 資料位搜尋總數
        $json_arr['recordsFiltered'] = count($search_data);
        // 排序
        $col_num = $_GET['order'][0]['column'];
        
        $order_type = $_GET['order'][0]['dir'];
        $search_data = $this->order_by($search_data, $sort_arr[$col_num], $order_type);
        $page_data_list = $this->datalist_by_start($search_data, $_GET['length'], $_GET['start']);

        $json_arr['data'] = $page_data_list;
        $json_arr['draw'] = (int) $_GET['draw'];
        return $json_arr;
    }

    // 篩選出這一頁需要的資料內容 (由 page lib 複製過來用的)
    function datalist_by_start($arr, $items, $start)
    {
        $count = count($arr);
        $end = $start + $items;
        $res = array();
        $arr = array_values($arr);
        while (
            $start < $end
        ) {
            if (isset($arr[$start])) {
                $res[] = $arr[$start];
            }
            $start = $start + 1;
        }
        return $res;
    }
    /**
     * 把記憶體當資料庫使用～ like
     *  $arr 來源陣列
     *  $col 要篩選的欄位（以單為陣列表示）
     *  $value 要找的值
     */
    function find_like($arr, $col, $value)
    {

        if ($value == '') {
            return $arr;
        }
        $arr = array_values($arr);
        $res = array();
        $arr_temp = array();
        foreach ($arr as $k => $v) {
            $sv = '';
            foreach ($v as $k2 => $v2) {
                if (in_array($k2, $col)) { // 
                    $sv = $sv . $v2;
                }
            }
            $arr_temp[] = $sv;
        }
        foreach ($arr_temp as $k3 => $v3) {
            $reg = "/" . $value . "/i";
            if (preg_match($reg, (string) $v3, $matches)) { //比對文字內容
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
    function order_by($arr, $col, $type)
    {
        $res = array();
        foreach ($arr as $v) {
            $res[] = $v[$col];
        }
        if ($type == 'asc') {
            array_multisort($res, SORT_ASC, $arr);
        } else {
            array_multisort($res, SORT_DESC, $arr);
        }
        return $arr;
    }
}

?>
