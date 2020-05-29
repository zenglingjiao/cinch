<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library(array('common/mobile_detect','password'));
        $this->load->helper(array('array', 'language', 'url', 'common', 'jwt'));

        // $lang = get_lang($_SERVER, $default = "tw");
        // if ($lang == "tw" || $lang == "cn") {
        //     $this->config->set_item('language', 'traditional-chinese');
        // } else if ($lang == "en") {
        //     $this->config->set_item('language', 'english');
        // } else if ($lang == "ja") {
        //     $this->config->set_item('language', 'japanese');
        // } else if ($lang == "ko") {
        //     $this->config->set_item('language', 'korean');
        // } else if ($lang == "th") {
        //     $this->config->set_item('language', 'thai');
        // }

        //$this->load->language('imarts_lang');


        /* Any mobile device (phones or tablets) */
        if ($this->mobile_detect->isMobile())
        {
            $this->data['mobile'] = TRUE;

            if ($this->mobile_detect->isiOS()){
                $this->data['ios']     = TRUE;
                $this->data['android'] = FALSE;
            }
            else if ($this->mobile_detect->isAndroidOS())
            {
                $this->data['ios']     = FALSE;
                $this->data['android'] = TRUE;
            }
            else
            {
                $this->data['ios']     = FALSE;
                $this->data['android'] = FALSE;
            }

            if ($this->mobile_detect->getBrowsers('IE')){
                $this->data['mobile_ie'] = TRUE;
            }
            else
            {
                $this->data['mobile_ie'] = FALSE;
            }
        }
        else
        {
            $this->data['mobile']    = FALSE;
            $this->data['ios']       = FALSE;
            $this->data['android']   = FALSE;
            $this->data['mobile_ie'] = FALSE;
        }

        if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
            if (is_https()) {
                $this->config->set_item('domain_url', 'https://' . $_SERVER['HTTP_HOST']);
            } else {
                $this->config->set_item('domain_url', 'http://' . $_SERVER['HTTP_HOST']);
            }
        }

	}
}

class App_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model('Data_helper_model');
        $this->load->helper('response_json', 'jwt');

        $token = $this->input->get_request_header('token', true);

        if (strtolower($this->router->method) == "login"
            || strtolower($this->router->method) == "login_new"
            || strtolower($this->router->method) == "send_code"//發送驗證碼
            || strtolower($this->router->method) == "verify"//驗證
            || strtolower($this->router->method) == "register"//註冊
            || strtolower($this->router->method) == "set_password"//設置密碼
            || strtolower($this->router->method) == "upload_picture"//上傳圖片
            || strtolower($this->router->method) == "retrieve_password"//找回密碼
            || strtolower($this->router->method) == "get_class"//獲取分類
            || strtolower($this->router->method) == "test4"
            || strtolower($this->router->method) == "get_terms"
            || strtolower($this->router->method) == "get_news_list"
            || strtolower($this->router->method) == "get_activities_details_list"
            || strtolower($this->router->method) == "get_hot_film_list"
            || strtolower($this->router->method) == "get_prediction_win_image"
            || strtolower($this->router->method) == "lottery"
            || strtolower($this->router->method) == "vote"
            || strtolower($this->router->method) == "get_prize"
            || strtolower($this->router->method) == "get_roulette"
            || strtolower($this->router->method) == "get_apply"
            || strtolower($this->router->method) == "add_apply"
            || strtolower($this->router->method) == "password_change") {
            //放行
        } else if (mb_strlen(trim(isset($token) ?: "")) == 0) {
            return_app_json("203", "token未獲取", []);
        } else if ($check_token = $this->Data_helper_model->check_token_login($token)) {
            //放行
            //判斷是否要更新token
            if ($check_token === "updata_token") {
                $new_token = $this->Data_helper_model->update_token($token);
                if ($new_token) {
                    return_app_json("201", "更新token", $new_token);
                } else {
                    return_app_json("202", "登入失敗，請重新登入", []);
                }
            }
        } else {
            return_app_json("202", "登入失敗，請重新登入", []);
        }
    }
}

class Store_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->library("session");
        $this->load->library("Aauth");
        $this->load->model('Data_helper_model');
        $this->load->helper('response_json', 'jwt');

        $token = $this->input->get_request_header('token', true);

        if (strtolower($this->router->method) == "login"
            || strtolower($this->router->method) == "test"
            || strtolower($this->router->method) == "test3"
            || strtolower($this->router->method) == "test4"
            || strtolower($this->router->method) == "password_change") {
            //放行
        } else if (mb_strlen(trim(isset($token) ?: "")) == 0) {
            return_app_json("203", "token未獲取", []);
        } else if ($check_token = $this->Data_helper_model->check_token_store_login($token)) {
            //放行
            //判斷是否要更新token
            if ($check_token === "updata_store_token") {
                $new_token = $this->Data_helper_model->update_store_token($token);
                if ($new_token) {
                    return_app_json("201", "更新token", $new_token);
                } else {
                    return_app_json("202", "登入失敗，請重新登入", []);
                }
            }
        } else {
            return_app_json("202", "登入失敗，請重新登入", []);
        }
    }
}

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Data_helper_model');
        $this->load->helper('response_json');
        $this->load->helper('form');
        $this->load->helper('curl');

        //登入 退出不需要驗證
        if (strtolower($this->router->method) == "logout"
            || strtolower($this->router->method) == "login"
            || strtolower($this->router->method) == "password_change") {

        } else {
            if ($this->aauth->is_loggedin() || $this->aauth->is_admin()) {
                // if(strtolower($this->session->userdata('groupName'))==strtolower($this->router->class))
                // {}else{
                //     redirect(base_url('back/Admin/login'), 'refresh');
                // }
            } else {
                redirect(base_url('back/Admin/login'), 'refresh');
            }
        }
    }

}


class Public_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->library("session");
        $this->load->model('Data_helper_model');
        $this->load->helper('response_json');
	}
}
