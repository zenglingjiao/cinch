<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Store
 */
class Front extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    public function share($id = "")
    {
        $data['title'] = "活動分享";
        $activitie     = $this->Data_helper_model->get_model_in_id("activities", $id);
        if ($activitie) {
            $data["preferential"] = $this->Data_helper_model->get_model_in_id("preferentials", $activitie->preferential_id);
        }
        $data["activitie"] = $activitie;
        $this->load->view("Front/share", $data);
    }

    public function test()
    {
        $params = [
            'partnerID' => 173,
            'invoke'    => 'lcqrtask',
            'token'     => '6486b2812055eb9ffa881275d2af7d02',
            'formData'  => '{"task_encrypt":"186c211e0892b74a"}',

        ];
        $url = 'http://60.250.137.141/CinchAPP/team.php';
        $ch  = curl_init(); //初始化
        curl_setopt($ch, CURLOPT_URL, $url); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $res = curl_exec($ch); //运行curl
        curl_close($ch);
        // return ($data);
        $data['res'] = json_decode($res, true);
        $this->load->view("Front/test", $data);
    }

    public function test_img()
    {
        //echo rename('updata/image/2019-09/201909032149531.jpg','updata/image/2019-09/201909032149531111111111111111.jpg');
        //exit;

        //$img_info = getimagesize('updata/image/2019-09/201909032149531.jpg');
        // var_dump($img_info);
        // var_dump(filesize('updata/image/2019-09/201909032149531.jpg'));
        // exit;

        // $path_parts = pathinfo('updata/image/2019-09/201909032149531.jpg');
        //
        // $img = imagecreatefrompng('updata/image/2019-09/201909052152081.png');
        // var_dump(imagejpeg($img,"fsdf.jpg"));
        // exit;
        //echo compress_img('updata/image/2019-09/201909052152081.png', 1280);

        //exit;
        //echo file_exists('updata/image/2019-09/201909032149531.jpg');

        $path_parts = pathinfo('updata/image/2019-09/201909032149531.jpg');
        var_dump($path_parts);
        exit;

        $dir    = 'updata/image/2019-09/201909032149531.jpg';
        $newDir = $path_parts['dirname'] . '/';
        //$this->load->library("Imgcompress", ["src" => $dir, "percent" => 0.2]);
        $this->load->library("Imgcompress", ["src" => $dir, "percent" => 1024 / $img_info[0]]);
        create_folders($newDir);
        $this->imgcompress->compressImg($newDir . $path_parts['filename'] . 'x1024');
        echo "完成";
    }

    //獲取cinch主張
    public function get_proposition()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('proposition', ['state'], [1], 'id', 'desc');
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取主力產品
    public function get_major_product()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('major_product', ['state'], [1], 'id', 'desc');
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取宣傳影片
    public function get_propaganda_film()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('propaganda_film', ['state'], [1], 'id', 'desc');
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取產品索取
    public function get_products_for()
    {
        $data = $this->Data_helper_model->get_model_in_id('products_for', 1);
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取纖奇保證主圖
    public function get_pledge_image()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('pledge_image', ['state', 'activities_time_start <', 'activities_time_end >'], [1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')], 'id', 'desc');
        if(empty($data)){
        	$data=$this->Data_helper_model->get_model_list_in_fileds_orderby('pledge_image', ['state'], [1], 'id', 'desc');
        }
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取見證者
    public function get_proposita()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('proposita', ['state'], [1], 'id', 'desc');
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取纖奇產品
    public function get_cinch_product()
    {

        $offset   = mb_strlen(trim(isset($_POST['offset']) ?: "")) == 0 ? 0 : (int) trim($_POST['offset']);
        $limit    = mb_strlen(trim(isset($_POST['limit']) ?: "")) == 0 ? 6 : (int) trim($_POST['limit']);
        $classify = mb_strlen(trim(isset($_POST['classify']) ?: "")) == 0 ? "" : trim($_POST['classify']);
        if (empty($classify)) {
            return return_app_json("104", "参数错误", []);
        }

        $this->db->from('cinch_product');
        $this->db->where('state', 1);
        $this->db->where('classify', $classify);
        $this->db->order_by('id', 'desc');
        //把查询条件克隆
        $db_count = clone($this->db);
        $total = $db_count->count_all_results();

        $this->db->limit($limit);
        $this->db->offset($offset * $limit);

        $query = $this->db->get();
        $data  = $query->result();
        
        return return_app_json("200", "獲取成功", ['total'=>$total,'rows'=>$data]);
    }
    //獲取纖奇产品主圖
    public function get_cinch_product_image()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('cinch_product_image', ['state', 'activities_time_start <', 'activities_time_end >'], [1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')], 'id', 'desc');
        if(empty($data)){
        	$data=$this->Data_helper_model->get_model_list_in_fileds_orderby('cinch_product_image', ['state'], [1], 'id', 'desc');
        }
        return return_app_json("200", "獲取成功", $data);
    }
    //獲取認識我們主圖
    public function get_about_us()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('about_us', ['state', 'activities_time_start <', 'activities_time_end >'], [1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')], 'id', 'desc');
        if(empty($data)){
        	$data=$this->Data_helper_model->get_model_list_in_fileds_orderby('about_us', ['state'], [1], 'id', 'desc');
        }
        return return_app_json("200", "獲取成功", $data);
    }
    //新增客戶索取
    public function insert_client_claim()
    {
        $name    = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        $phone   = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
        $email   = mb_strlen(trim(isset($_POST['email']) ?: "")) == 0 ? "" : trim($_POST['email']);
        $line_id = mb_strlen(trim(isset($_POST['line_id']) ?: "")) == 0 ? "" : trim($_POST['line_id']);

        $sql_data = [
            "name"       => $name,
            "phone"      => $phone,
            "email"      => $email,
            "line_id"    => $line_id,
            "created_at" => date("Y-m-d H:i:s", time()),
        ];
        if ($this->db->insert("client_claim", $sql_data)) {
            return_app_json("200", "送出成功", []);
        } else {
            return_app_json("104", "送出失敗", []);
        }
    }
    //獲取主页主圖
    public function get_master_image()
    {
        $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('master_image', ['state', 'activities_time_start <', 'activities_time_end >'], [1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')], 'id', 'desc');
        if(empty($data)){
        	$data=$this->Data_helper_model->get_model_list_in_fileds_orderby('master_image', ['state'], [1], 'id', 'desc');
        }
        return return_app_json("200", "獲取成功", $data);
    }
}
