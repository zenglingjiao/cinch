<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        $activitie = $this->Data_helper_model->get_model_in_id("activities", $id);
        if ($activitie) {
            $data["preferential"] = $this->Data_helper_model->get_model_in_id("preferentials", $activitie->preferential_id);
        }
        $data["activitie"] = $activitie;
        $this->load->view("Front/share", $data);
    }

    public function test()
    {
    	$params=[
    		'partnerID'=>173,
    		'invoke'=>'lcqrtask',
    		'token'=>'6486b2812055eb9ffa881275d2af7d02',
    		'formData'=>'{"task_encrypt":"186c211e0892b74a"}',

    	];
    	$url='http://60.250.137.141/CinchAPP/team.php';
    	$ch = curl_init();//初始化
	    curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
	    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
	    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    $res = curl_exec($ch);//运行curl
	    curl_close($ch);
	    // return ($data);
	    $data['res'] =json_decode($res,true);
		$this->load->view("Front/test",$data);
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

        $dir = 'updata/image/2019-09/201909032149531.jpg';
        $newDir = $path_parts['dirname'] . '/';
        //$this->load->library("Imgcompress", ["src" => $dir, "percent" => 0.2]);
        $this->load->library("Imgcompress", ["src" => $dir, "percent" => 1024 / $img_info[0]]);
        create_folders($newDir);
        $this->imgcompress->compressImg($newDir . $path_parts['filename'] . 'x1024');
        echo "完成";
    }

}
