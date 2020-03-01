<?php
function get_csrf_nonce()
{
    $ci = &get_instance();
    $ci->load->helper('string');
    $key = random_string('alnum', 8);
    $value = random_string('alnum', 20);
    $ci->session->set_flashdata('csrfkey', $key);
    $ci->session->set_flashdata('csrfvalue', $value);

    return array($key => $value);
}

function get_csrf_nonce_keep()
{
    $ci = &get_instance();
    $ci->session->keep_flashdata('csrfkey');
    $ci->session->keep_flashdata('csrfvalue');
}

function valid_csrf_nonce()
{
    $ci = &get_instance();
    // if ($ci->input->post($ci->session->flashdata('csrfkey')) !== FALSE && $ci->input->post($ci->session->flashdata('csrfkey')) == $ci->session->flashdata('csrfvalue')) {
    //     return TRUE;
    // } else {
    //     return FALSE;
    // }
    if ($_POST[$ci->session->flashdata('csrfkey')] !== FALSE && $_POST[$ci->session->flashdata('csrfkey')] == $ci->session->flashdata('csrfvalue')) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function create_folders($dir)
{
    return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
}

function sendMail_126($title, $content, $address)
{
    $ci = &get_instance();
    $ci->load->library("email");
    //$this->load->library('email');
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.126.com';
    $config['smtp_user'] = 'senlin198988@126.com';//你邮箱的账号
    $config['smtp_pass'] = 'forestdai';//你申请的密码
    $config['mailtype'] = 'html';
    $config['smtp_port'] = 25;
    $config['charset'] = 'utf-8';
    $config['smtp_timeout'] = 120;
    $ci->email->initialize($config);
    $ci->email->from("senlin198988@126.com", "senlin198988");
    $ci->email->to($address);
    $ci->email->subject($title);
    $ci->email->message($content);
    if ($ci->email->send()) {
        return true;
    } else {
        //echo $ci->email->print_debugger();
        $ci->log->write_log('Error', $ci->email->print_debugger());
        return false;
    }
}

function sendMail($title, $content, $address)
{
    $ci = &get_instance();
    $ci->load->library("email");
    $ci->load->library("logs");

    // $ci->email->initialize(array(
    //     'protocol' => 'smtp',
    //     'smtp_host' => 'smtp.sendgrid.net',
    //     'smtp_user' => 'apikey',
    //     'smtp_pass' => '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',
    //     'smtp_port' => 587,
    //     'crlf' => "\r\n",
    //     'newline' => "\r\n"
    // ));
    //
    // $ci->email->from('service@imarts.co', 'apikey');
    // $ci->email->to('senlin198988@126.com');
    // //$ci->email->cc('another@another-example.com');
    // //$ci->email->bcc('them@their-example.com');
    // $ci->email->subject('Email Test');
    // $ci->email->message('Testing the email class.');
    // if ($ci->email->send()) {
    //     return true;
    // } else {
    //     $ci->log->write_log('Error', "---------------------start----------------------------");
    //     $ci->log->write_log('Error', $ci->email->print_debugger());
    //     $ci->log->write_log('Error', "----------------------end-----------------------------");
    //     return false;
    // }
    // exit;


    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.sendgrid.net';
    $config['smtp_user'] = $ci->config->item('smtp_user_gmail');//帳號
    $config['smtp_pass'] = $ci->config->item('smtp_pass_gmail');//密碼
    $config['mailtype'] = 'html';
    $config['smtp_port'] = 587;
    $config['charset'] = 'utf-8';
    $config['smtp_timeout'] = 500;
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
    $ci->email->initialize($config);
    $ci->email->from($ci->config->item('smtp_address_gmail'), $ci->config->item('smtp_from_name'));
    $ci->email->to($address);
    $ci->email->subject($title);
    $ci->email->message($content);
    if ($ci->email->send()) {
        return true;
    } else {
        $ci->log->write_log('Error', "---------------------start----------------------------");
        $ci->log->write_log('Error', $ci->email->print_debugger());
        $ci->log->write_log('Error', "----------------------end-----------------------------");
        return false;
    }
}

// function sendMail($title,$content,$address){
//     $ci = &get_instance();
//     $ci->load->library("email");
//     $config['protocol'] = 'smtp';
//     $config['smtp_host'] = 'smtp.gmail.com';
//     $config['smtp_user'] = 'no-reply@173wifi.com';//你邮箱的账号
//     $config['smtp_pass'] = '51xueLeifeng';//你申请的密码
//     $config['mailtype'] = 'html';
//     $config['smtp_port'] = 587;
//     $config['charset'] = 'utf-8';
//     $config['smtp_timeout']=120;
//     $ci->email->initialize($config);
//     $ci->email->from("no-reply@173wifi.com", "no-reply");
//     $ci->email->to($address);
//         //$this->email->to('1005656735@qq.com');
//        // $this->email->cc('347508552@qq.com');
//     //$ci->email->cc('290918528@qq.com');
//       //  $this->email->bcc('18310442556@163.com');
//      //        $this->email->to('997242980@qq.com');
//     $ci->email->subject($title);
//     $ci->email->message($content);
//     if ($ci->email->send()) {
//         return true;
//     } else {
//         //echo $ci->email->print_debugger();
//         $ci->log->write_log('Error',print_debugger());
//         return false;
//     }
// } 

function is_value_in_object($fied, $value, $array)
{
    foreach ($array as $k => $v) {
        $v = (array)$v;
        if (isset($v[$fied]) && $v[$fied] == $value) {
            return true;
        }
    }
    return false;
}

function get_lang($server, $default = "en")
{
    $country_id = $default;
    if (isset($server['HTTP_ACCEPT_LANGUAGE']) && !empty($server['HTTP_ACCEPT_LANGUAGE'])) {
        $country_id = $server['HTTP_ACCEPT_LANGUAGE'];
        $country_id = substr($country_id, 0, 4);
    } else {
        return $country_id;
    }
    if (preg_match("/zh-c/i", $country_id)) {
        $country_id = "cn";
    } elseif (preg_match("/zh/i", $country_id)) {
        $country_id = "tw";
    } elseif (preg_match("/en/i", $country_id)) {
        $country_id = "en";
    } elseif (preg_match("/ja/i", $country_id)) {
        $country_id = "ja";
    } elseif (preg_match("/ko/i", $country_id)) {
        $country_id = "ko";
    } elseif (preg_match("/th/i", $country_id)) {
        $country_id = "th";
    } elseif (preg_match("/id/i", $country_id)) {
        $country_id = "id";
    } elseif (preg_match("/ph/i", $country_id)) {
        $country_id = "ph";
    }
    return $country_id;
}

// function test()
// {
//     set_error_handler(function($error_type,$error_message,$error_file,$error_line){
//         if($error_type==E_WARNING){
//
//         }
//         throw new Exception("错误信息：{$error_message}，错误文件：{$error_file}，错误行数{$error_line}");
//     });
//
//     try{
//         $dd = ["le"=>3,"cc"=>"34"];
//         $dd->le;
//     }
//     catch (Exception  $e)
//     {
//         echo $e;
//         exit;
//     }
//     restore_error_handler();
// }

/**
 * 判斷營業時間
 * [
 * ["name"=>"星期天","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ["name"=>"星期一","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ["name"=>"星期二","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ["name"=>"星期三","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ["name"=>"星期四","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ["name"=>"星期五","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ["name"=>"星期六","open"=>false, "time"=>[["time_s"=>"","time_e"=>""]]],
 * ]
 */
function get_business_show($b_time)
{
    $business_work = [
        "is_work" => '-',
        "last_open_time" => "-",
    ];
    $now_time = date("H:i");
    if ($b_time && count($b_time) > 0) {
    } else {
        return $business_work;
    }
    foreach ($b_time as $b_index => $b_value) {
        if (date("w") == $b_index) {
            if ($b_value->open) {
                foreach ($b_value->time as $t) {
                    if ($t->time_s < $now_time && $now_time < $t->time_e) {
                        $business_work['is_work'] = "營業中";
                    }
                    $business_work['last_open_time'] = $t->time_e;
                }
            } else {
                $business_work['is_work'] = '公休';
                $business_work['last_open_time'] = '-';
            }
        }
    }
    return $business_work;
}

/**
 * 發送email
 * @param $email 接收email
 * @param $email 業務
 * @param $param_arr 信息模板參數
 * @param $code 驗證碼
 */
function to_email_param($email, $service, $param_arr, $template_code = "")
{
    $ci = &get_instance();
    $user_id = $ci->session->userdata('id');
    if ($ci->Data_helper_model->get_model_in_fileds("user_email", ['email', 'send_time >'], [$email, date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -5 minutes"))])) {
        return "101";
    }
    $email_model = $ci->Data_helper_model->get_model_in_fileds("msg_template", ["msg_type", "code"], ["email", $template_code]);
    if ($email_model) {
        $email_content = $ci->Data_helper_model->get_msg_template($param_arr, $email_model->msg_template);
        $is_ok = sendMail($email_model->msg_title, $email_content, $email);
        if ($is_ok) {
            $sql_data["id"] = $ci->uuid->v4();
            $sql_data["email"] = $email;
            $sql_data["send_time"] = date("Y-m-d H:i:s", time());
            $sql_data["invalid_time"] = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +5 minutes"));
            $sql_data["email_content"] = $email_content;
            $sql_data["code"] = $param_arr[0];
            $sql_data["service"] = $service;
            if ($ci->db->insert("user_email", $sql_data)) {
                //return_post_json("ok", "發送成功", "", null);
                return true;
            }
        } else {
            $ci->logs->log("電子郵件發送失敗：");
            return false;
        }
    }
    return false;
}

function get_google_lng_lat($address)
{
    $ci = &get_instance();
    $google_lng_lat = curl_get_google("https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . $ci->config->item('google_geocode_key') . "");
    //$ci->logs->log("get_google_lng_lat：".$google_lng_lat);
    return $google_lng_lat;
}

/**
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 * @return int
 */
function getDistance($lat1, $lng1, $lat2, $lng2)
{

    // 将角度转为狐度
    $radLat1 = deg2rad($lat1);// deg2rad()函数将角度转换为弧度
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137;

    return $s;

}

/**
 * @param $lat1
 * @param $lon1
 * @param $lat2
 * @param $lon2
 * @param float $radius 星球半径 KM
 * @return float
 */
function distance($lat1, $lon1, $lat2, $lon2, $radius = 6378.137)
{
    $rad = floatval(M_PI / 180.0);

    $lat1 = floatval($lat1) * $rad;
    $lon1 = floatval($lon1) * $rad;
    $lat2 = floatval($lat2) * $rad;
    $lon2 = floatval($lon2) * $rad;

    $theta = $lon2 - $lon1;

    $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));

    if ($dist < 0) {
        $dist += M_PI;
    }
    return $dist = $dist * $radius;
}

function compress_img($y_file_src, $ratio = 1280, $n_file_src = '')
{
    if (file_exists($y_file_src)) {
        $img_info = getimagesize($y_file_src);

        //var_dump($img_info);
        //exit;
        $path_parts = pathinfo($y_file_src);
        // var_dump($path_parts);
        // exit;
        //$dir = 'updata/image/2019-09/201909032149531.jpg';
        if (!empty($n_file_src)) {
            $newDir = $n_file_src;
        } else {
            $newDir = $path_parts['dirname'] . '/';
        }

        if (file_exists($newDir . $path_parts['filename'] . 'x' . $ratio . "." . $path_parts['extension'])) {
            return $newDir . $path_parts['filename'] . 'x' . $ratio . "." . $path_parts['extension'];
        }

        if ($img_info && $img_info[0] > 1920) {
        } else {
            if (filesize($y_file_src) / 1024 > 800) {
                if (pathinfo($y_file_src, PATHINFO_EXTENSION) == "png") {
                    $img = imagecreatefrompng($y_file_src);
                    if(imagejpeg($img, $newDir . $path_parts['filename'] . ".jpg")){
                        return $newDir . $path_parts['filename'] . ".jpg";
                    }
                }
            } else {
                return $y_file_src;
            }
        }

        $ci = &get_instance();
        //$this->load->library("Imgcompress", ["src" => $dir, "percent" => 0.2]);
        $ci->load->library("Imgcompress", ["src" => $y_file_src, "percent" => $ratio / $img_info[0]]);
        create_folders($newDir);
        $ci->imgcompress->compressImg($newDir . $path_parts['filename'] . 'x' . $ratio);

        return $newDir . $path_parts['filename'] . 'x' . $ratio . "." . $path_parts['extension'];
    } else {
        return $y_file_src;
    }
}

?>