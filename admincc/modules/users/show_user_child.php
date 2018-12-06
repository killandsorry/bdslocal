<?
ob_start();
include 'inc_security.php';

$user_id = getValue('uid', 'int', 'POST', 0);

$arrayReturn   = array(
   'status' => 0,
   'data' => ''
);
if($user_id > 0){
   $db_user = new db_query("SELECT * FROM users WHERE use_parent_id = ". intval($user_id) . " AND use_id <> " . intval($user_id));
   while($row  = mysqli_fetch_assoc($db_user->result)){
      echo '<li>'. $row['use_fullname'] . '<div style="white-space: nowrap;"><a target="_blank" href="/banhang/fakelogin.php?'. crateUrlToken(array("loginname" => $row['use_login']),0) .'">Face login</a> --|-- <a target="_blank" href="/banhang/fakelogin.php?'. crateUrlToken(array("loginname" => $row['use_login'],"dev"=>1),0) .'">Face debug</a></div></li>';
   }
}

$html = ob_get_contents();
ob_end_clean();

if($html != ''){
   $arrayReturn   = array(
      'status' => 1,
      'data' => '<ul class="show_list">'. $html .'</ul>'
   );
}

echo json_encode($arrayReturn);
exit();