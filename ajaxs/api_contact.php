<?php
/**
 * Created by Bùi Văn Chiến (skype: chien88edu).
 * Email: cbquyetchien973@gmail.com - Phone: 0989.197.xxx
 * Date: 9/27/2018
 * Time: 11:21 PM
 */

include 'config.php';

$result = [
    'code' => 200,
    'msg'   => '',
    'data'  => ''
];

$pro_id     = getValue('pid', 'int', 'POST', 0);
$phone      = getValue('phone', 'str', 'POST', '');
$name       = getValue('name', 'str', 'POST', '');
$email      = getValue('email', 'str', 'POST', '');

if($pro_id > 0 && $phone != '' && $name != ''){

    $phone  = trim($phone);
    $phone  = str_replace(array('.', ' ','-'),'', $phone);

    if(strlen($phone) > 11 || strlen($phone) < 9){
        $result['code'] = 402;
        $result['msg']  = '[số điện thoại] bạn nhập chưa đúng';
    }else{

        $db_ex = new db_execute_return();
        $con_id = $db_ex->db_execute("INSERT IGNORE INTO contact (con_name,con_phone,con_email,con_pro_id,con_date)
                                        VALUES ('". replaceMQ($name) ."','". replaceMQ($phone) ."','". replaceMQ($email) ."',". intval($pro_id) .",". time() .")");
        if($con_id > 0){
            $result['msg']  = 'Cảm ơn quý khách đã để lại thông tin, nhân viên tư vấn của chúng tôi sẽ liên hệ và gửi tài liệu sớm nhất cho quý khách.';
        }

    }

}else{
    $result['code'] = 402;
    $result['msg']  = 'Thông tin [tên],[số điện thoại] cần được nhập';
}

echo json_encode($result);
exit();