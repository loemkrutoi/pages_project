<?php
    require_once '../config/link.php';
    if(!empty($_GET)){
        print_r($_GET);
        $to=$link->query("SELECT * FROM `pages` WHERE `key_page`='$_GET[to]'")->fetch_array(MYSQLI_ASSOC);
        $from=$link->query("SELECT * FROM `pages` WHERE `key_page`='$_GET[from]'")->fetch_array(MYSQLI_ASSOC);
        print_r($from);
        $link->query("UPDATE `pages` SET `key_page`='$to[key_page]',`name_page`='$to[name_page]' WHERE `id_page`=$from[id_page]");
        $link->query("UPDATE `pages` SET `key_page`='$from[key_page]',`name_page`='$from[name_page]' WHERE `id_page`=$to[id_page]");
        header("Location: /mainPages/admin.php");
    }
    // header('Content-Type: application/json');
    // $arrayOrder = json_decode(file_get_contents('php://input'), true);
    // foreach ($arrayOrder as $order){
    //     foreach($order as $page){
    //         if($page['order_page'] == 0){

    //         }
    //         else{
    //             $position = $page['order_page'];
    //             $idPage = $page['id_page'];
    //             $querySave = " UPDATE `pages` SET `order_page` =  '$position'  WHERE `id_page`  =  '$idPage'";
    //             $resultSave = $link->query($querySave);
    //             echo 'id: ' . $page['id_page'] . ' ' . 'position: ' . $page['order_page'] . ' '; 
    //         }
    //     }
    // }
?>