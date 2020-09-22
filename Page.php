<?php
/**
 * 2020-09-22 @ James 
 * 預設會繼承之前使用的 items 和 now_page
 * 2019-06-03 @ James
 * 後端製作資料分頁 lib
 * 將where過的資料陣列放到 datalist 中就可以擷取特定頁碼資料回傳
 * 
 * arr 完整資料陣列
 * items 單頁筆數
 * now_page 目前頁碼
 * 
 * 回傳值
 * datalist 已經擷取完成的資料
 * current_page 目前頁碼
 * total_count 總筆數
 * total_page 總頁數
 * 
 */
class Page
{
  // 取得items
  function items(){
    if(isset($_GET['items'])){
      if($_GET['items'] == ""){
          if(isset($_SESSION['items'])){
            $items = $_SESSION['items'];
          }else{
            $items = 10;
          }
      }else{
          $items = $_GET['items'];
      }
    }else{
        if(isset($_SESSION['items'])){
            $items = $_SESSION['items'];
        }else{
            $items = 10;
        }
    }
    return $items;
  }
  // 取得items
  function now_page(){
    if(isset($_GET['now_page'])){
      if($_GET['now_page'] == ""){
          if(isset($_SESSION['now_page'])){
            $now_page = $_SESSION['now_page'];
          }else{
            $now_page = 10;
          }
      }else{
          $now_page = $_GET['now_page'];
      }
    }else{
        if(isset($_SESSION['now_page'])){
            $now_page = $_SESSION['now_page'];
        }else{
            $now_page = 10;
        }
    }
    return $now_page;
  }


  // 完整輸出
  function pages_data($arr, $items, $now_page)
  {
    $data = $this->pages_config($arr, $items);
    $data['datalist'] = $this->datalist($arr, $items, $now_page);
    $data['current_page'] = $now_page;
    return $data;
  }
  // 單純取得資料
  function datalist($arr, $items, $now_page)
  {
    $count = count($arr);
    $start = ($now_page - 1) * $items;
    $end = $start + $items;
    $res = array();
    while (
      $start < $end
    ) {
      if (isset($arr[$start])) {
        $res[] = $arr[$start];
      }
      $start = $start + 1;
      # code...
    }
    // 設定緩存 session 狀態
    $_SESSION['items'] = $items;
    $_SESSION['now_page'] = $now_page;
    return $res;
  }
  // 取得分頁設定資料
  function pages_config($arr, $items)
  {
    $res['total_count'] = count($arr);
    $res['total_page'] = ceil(count($arr) / $items);
    return $res;
  }
}
