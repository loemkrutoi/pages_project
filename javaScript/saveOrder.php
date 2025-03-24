<?php
    require_once '../config/link.php';
    header('Content-Type: application/json');
    $arrayOrder = json_decode(file_get_contents('php://input'), true);
    foreach ($arrayOrder as $order){
        foreach($order as $page){
            if($page['page_order'] == 0){

            }
            else{
                $position = $page['page_order'];
                $idPage = $page['page_id'];
                $querySave = " UPDATE `pages` SET `page_order` =  '$position'  WHERE `id-page`  =  '$idPage'";
                $resultSave = $link->query($querySave);
                echo 'id: ' . $page['id'] . ' ' . 'position: ' . $page['page_order'] . ' '; 
            }
        }
    }
?>