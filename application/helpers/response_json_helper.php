<?php
function return_post_json($code = "", $message = "", $url = "", $data = array())
{
    $CI =& get_instance();

    $result = array(
        'Statu' => $code,
        'Msg' => $message,
        'BackUrl' => $url,
        'Data' => $data
    );
    ob_end_clean();
    $CI->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_UNESCAPED_UNICODE))
        ->_display();
    exit;
    // ob_end_clean();
    // header('Content-Type:application/json; charset=utf-8');
    // $result = array(
    //     'Statu' => $code,
    //     'Msg' => $message,
    //     'BackUrl' => $url,
    //     'Data' => $data
    // );
    // // 输出json
    // echo json_encode($result, JSON_UNESCAPED_UNICODE);
    //exit();
}

function return_app_json($code = 1, $message = "", $data = array())
{
    $CI =& get_instance();

    $result = array(
        'code' => $code,
        'msg' => $message,
        'data' => $data
    );
    ob_end_clean();
    $CI->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($result, JSON_UNESCAPED_UNICODE))
        ->_display();
    exit;
    // ob_end_clean();
    // header('Content-Type:application/json; charset=utf-8');
    // $result = array(
    //     'code' => $code,
    //     'msg' => $message,
    //     'data' => $data
    // );
    // //输出json
    // echo json_encode($result, JSON_UNESCAPED_UNICODE);
    // exit;
}

function return_get_msg($msg = "", $url = "")
{
    $CI =& get_instance();

    if($msg=="無權限")
    {
        $data["title"] = "無權限";
        $data["referer_url"] = $url;
        $out_string = $CI->load->view('back/partials/_include_no_permission', $data, TRUE);
    }else{
        $out_string = "<script>alert('" . $msg . "');window.location.href='" . $url . "';</script>";
    }

    ob_end_clean();
    $CI->output
        ->set_content_type('text/html', 'UTF-8')
        ->set_output($out_string)
        ->_display();
    exit;
    // ob_end_clean();
    // echo "<script>alert('" . $msg . "');window.location.href='" . $url . "';</script>";
    // return;
    // exit;
}


?>