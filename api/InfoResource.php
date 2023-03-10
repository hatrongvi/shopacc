<?php

define("IN_SITE", true);
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/helper.php");
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if (isset($_GET['username']) && isset($_GET['password'])) {
    if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".check_string($_GET['username'])."'  ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Thông tin đăng nhập không chính xác'
        ]));
    }
    if($CMSNT->site('status_api_buyproduct') == 0){
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng kết nối API đã được tắt trên website này')]));
    }
    $password = check_string($_GET['password']);
    if ($CMSNT->site('type_password') == 'bcrypt') {
        if (!password_verify($password, $getUser['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Thông tin đăng nhập không chính xác'
            ]));
        }
    } else {
        if ($getUser['password'] != TypePassword($password)) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Thông tin đăng nhập không chính xác'
            ]));
        }
    }
    if (!isset($_GET['id'])) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Thiếu ID sản phẩm cần lấy thông tin'
        ]));
    }
    $id = check_string($_GET['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `products` WHERE  `status` = 1 AND `id` = '$id'  ORDER BY `id` desc ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID sản phẩm không hợp lệ'
        ]));
    }
    // $conlai = $CMSNT->num_rows(" SELECT * FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `status` = 'LIVE' AND `buyer` IS NULL ");
    // $conlai = $conlai ? $conlai : 0;
    $conlai = $row['id_api'] != 0 ? $row['api_stock'] : $CMSNT->get_row("SELECT COUNT(id) FROM `accounts` WHERE `product_id` = '".$row['id']."' AND `buyer` IS NULL AND `status` = 'LIVE' ")['COUNT(id)'];
    $list_dichvu = [];
    $list_dichvu =
    [
        'id'            => $row['id'],
        'name'          => $row['name'],
        'price'         => $row['price'],
        'amount'        => $conlai,
        'country'       => $row['flag'],
        'description'   => $row['content']
    ];
    die(json_encode([
        'status'    => 'success',
        'msg'       => 'Lấy thông tin sản phẩm thành công',
        'data'      => $list_dichvu
    ]));
    echo json_encode($data, JSON_PRETTY_PRINT);
} else {
    die(json_encode([
        'status'    => 'error',
        'msg'       => 'Vui lòng nhập thông tin đăng nhập'
    ]));
}
