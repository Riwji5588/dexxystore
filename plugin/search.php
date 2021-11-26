<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST)){
   
    

    /* result */
    if(empty($errorMSG)){
        echo json_encode(['code'=>200,]);
    }else{
        echo json_encode(['code'=>500, 'msg'=>$errorMSG]);
    }

}else{
  header("Location: 403.php");
}

?>