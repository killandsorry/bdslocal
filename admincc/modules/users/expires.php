<?
require_once("inc_security.php");
$users = array('reset' => 'taikhoan');
$realm	= "Thong tin tai khoan";
function check_authen($recheck = 0){
    global $realm;
    if (empty($_SERVER['PHP_AUTH_DIGEST']) || $recheck == 1) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="'.$realm.
            '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
        die('Truy cap bi tu choi');
    }
}
// function to parse the http auth header
function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

check_authen();

// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])){
    check_authen(1);
    die("Xin loi ban ko co quyen");
}
// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response){
    check_authen(1);
    die("Xin loi ban ko co quyen");
}


$user_id = getValue('uid');

$array_branch = array();

if($user_id > 0){
    $db_u = new db_query("SELECT * FROM users WHERE use_id = " . intval($user_id) . " LIMIT 1");
    if($ru   = $db_u->fetch()){
        $db_branch  = new db_query("SELECT * FROM user_branch WHERE usb_use_id = " . $ru['use_id'] . " AND usb_active = 1");
        while($rb = $db_branch->fetch()){
            $array_branch[$rb['usb_id']] = $rb;
        }
        unset($db_branch);
    }else{
        die('Không có thông tin');
    }
}else{
    header('location:manager.php');
    exit();
}


$success = 0;
$action  = getValue('action', 'str', 'POST', '');
$branch_id  = getValue('branch_id', 'int', 'POST', 0);
if($action == 'action'){
    if($user_id > 0 && $branch_id > 0){

        $key   = 'usb_date_expires_' . $branch_id;
        $time   = getValue($key, 'str', 'POST', '');
        $dateExpires    = convertDateTime($time);
        if($dateExpires > 0){

            $db_ex = new db_execute("UPDATE user_branch SET usb_date_expires = " . $dateExpires . "
                                            WHERE usb_id = " . $branch_id);
            unset($db_ex);

            $content = date('d/m/Y - H:i', time()) . "\n" . "Admin reset user id : " . $user_id . ' Fullname: ' . $ru['use_fullname'] . "\n \n \n";
            @file_put_contents('../../../logs/reset_'. date('Ymd') .'.cfn', $content, FILE_APPEND);
            $success = 1;
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?=$load_header?>
    <style>

    </style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<!--<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
<input type="hidden" name="iQuick" value="update" />-->

<div id="listing">
    <div style=" margin: 0 auto;padding: 50px 10px; line-height: 20px;">
        <?
        if($success == 1) echo '<p style="color: green">Cập nhật thành công</p>';
        ?>
        <p>Cập nhật hạn sử dụng cho tài khoản: <b><?=$ru['use_fullname']?></b> Hoặc <a href="/qladminbt/modules/users/manager.php">Về trang quản lý</a> </p>
        <table class="table" border="1" bordercolor="#C3DAF9">
            <?
            foreach($array_branch as $id => $br){
                if($br['usb_date_expires'] <= 0) $br['usb_date_expires'] = $ru['use_date_expires'];
                $attid  = 'usb_date_expires_' . $id;
                ?>
                <form method="post" action="">
                    <tr>
                        <td><?=$br['usb_name']?></td>
                        <td><?=$br['usb_address']?></td>
                        <td><?=date("d/m/Y",$br['usb_date'])?></td>
                        <td>
                            <input type="text" value="<?=date('d/m/Y', $br['usb_date_expires'])?>" name="<?=$attid?>" id="<?=$attid?>" onKeyPress="displayDatePicker('<?=$attid?>', this);" onClick="displayDatePicker('<?=$attid?>', this);" />
                        </td>
                        <td>

                            <input type="submit" value="Cập nhật ngày hết hạn" />
                            <input type="hidden" value="action" name="action" />
                            <input type="hidden" value="<?=$id?>" name="branch_id" />

                        </td>
                    </tr>
                </form>
                <?
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>