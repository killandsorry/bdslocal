<?php
/**
 * Created by Bùi Văn Chiến (skype: chien88edu).
 * Email: cbquyetchien973@gmail.com - Phone: 0989.197.xxx
 * Date: 8/19/2018
 * Time: 12:05 PM
 */

include 'inc_security.php';

$cit_id     = getValue('cit_id', 'int', 'POST', 0);

$result     = array(
    'code' => 0,
    'html' => '',
    'error' => ''
);
$html   = '';

if($cit_id <= 0){
    $result['code'] = 0;
    $result['error'] = 'Không có tỉnh thành phố';
}else{
    $html .='<select class="form_control" id="pro_district_id" name="pro_district_id">';
    $db_ex = new db_query("SELECT * FROM city
                                  WHERE cit_parent_id = " . $cit_id);
    while($row = $db_ex->fetch()){
        $html .= '<option value="'. $row['cit_id'] .'">'. $row['cit_name'] .'</option>';
    }
    $html .= '</select>';
    unset($db_ex);

    $result['code'] = 1;
    $result['html'] = $html;
}


echo json_encode($result);
exit();