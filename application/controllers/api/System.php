<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class System
 */
class System extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
        $this->load->library("Jpush");

    }

    /**
     * 上傳圖像
     */
    public function file_upload_user_head()
    {
        $this->load->library("Custom_upload");
        $user_id          = $this->Data_helper_model->get_app_user_id();
        $path             = "updata/user_head/" . date("Y-m", time());
        $up_img_file_name = $this->custom_upload->single_upload("file", date("YmdHis", time()) . "_" . $user_id, ["upload_path" => $path, "allowed_types" => "jpeg|jpg|png|bmp"]);
        if ($up_img_file_name) {
            $sql_data = [
                "user_head"  => $path . "/" . $up_img_file_name,
                "updated_at" => date("Y-m-d H:i:s", time()),
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return return_app_json("200", "上傳成功", [
                    'urls' => $path . "/" . $up_img_file_name,
                ]);
            } else {
                return return_app_json("118", "上傳失敗", []);
            }
        }
        return return_app_json("118", "上傳失敗", []);
    }

    /*
     * 上傳文件
     * $type 上傳類別
     * $file_name 上傳參數名
     */
    private function file_upload($type, $file_name)
    {
        $this->load->library("Custom_upload");
        $path             = "updata/" . $type . "/" . date("Y-m", time());
        $up_img_file_name = $this->custom_upload->single_upload($file_name, date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "jpeg|jpg|png|bmp"]);
        if ($up_img_file_name) {
            return $path . "/" . $up_img_file_name;
        } else {
            return false;
        }

    }

    //上傳圖片
    public function upload_picture()
    {
        $res = $this->file_upload('home', 'file');
        if ($res) {
            return_app_json('200', '上傳成功', ['path' => $res]);
        } else {
            return_app_json("118", '上傳失敗', []);
        }
    }

    //獲取最新消息
    public function get_news_list()
    {
        // $user_id    = $this->Data_helper_model->get_app_user_id();
        // $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        // if ($user_model) {
        $field = array(
            'news.id',
            'news.title',
            'news.imgs',
            'news.content',
            'news.created_at',
        );
        $this->db->select($field);
        if ($name != "") {
            $this->db->group_start();
            $this->db->like('news.title', $name);
            $this->db->or_like('news.content', $name);
            $this->db->group_end();
        }
        // if ($c_time != "") {
        //     $c_time = explode("~", $c_time);
        //     $this->db->where('project.created_at >=', $c_time[0]);
        //     //日期必須小於加一天的。 有時間<=就好，不需要加一天。
        //     $this->db->where('project.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
        // }
        // $this->db->join('members', 'members.id =project.proposer', 'left');
        // $this->db->join('company', 'company.id =members.company_id', 'left');
        $this->db->where('news.state', 1);
        $this->db->where('news.added_time <', date('Y-m-d H:i:s'));
        $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "news");
        // var_dump($this->db->last_query());exit();
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
        // } else {
        //     return return_app_json("102", "獲取失敗", []);
        // }
    }
     //獲取最新消息詳情
    public function get_news_read()
    {
      
        $news_id = mb_strlen(trim(isset($_POST['news_id']) ?: "")) == 0 ? "" : trim($_POST['news_id']);
        $field = array(
            'news.id',
            'news.title',
            'news.imgs',
            'news.content',
            'news.created_at',
        );
        $this->db->select($field);
        $this->db->where('news.state', 1);
        $this->db->where('news.id', $news_id);
        $query=$this->db->get('news');

        $data = $query->row();
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //獲取活動詳情
    public function get_activities_details_list()
    {

        $field = array(
            'activities_details.id',
            'activities_details.type',
            'activities_details.apply_period',
            'activities_details.qualification',
            'activities_details.entry',
            'activities_details.competition_period',
            'activities_details.img_schedule',
            'activities_details.img_scoring',
            'activities_details.awards_imgs',
            'activities_details.awards_explain',
            'activities_details.announcements_activities',
        );
        $this->db->select($field);
        // if($name != ""){
        //     $this->db->group_start();
        //     $this->db->like('news.title', $name);
        //     $this->db->or_like('news.content', $name);
        //     $this->db->group_end();
        // }
        // $this->db->join('members', 'members.id =project.proposer', 'left');
        $this->db->where('activities_details.state', 1);
        $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "activities_details");
        // var_dump($this->db->last_query());exit();
        foreach ($data['rows'] as $key => $value) {
            $data['rows'][$key]['awards_imgs']    = json_decode($value['awards_imgs']);
            $data['rows'][$key]['awards_explain'] = json_decode($value['awards_explain']);
        }
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }

    }
    //獲取熱門影音
    public function get_hot_film_list()
    {

        $field = array(
            'hot_film.id',
            'hot_film.url',
            'hot_film.title',
        );
        $this->db->select($field);
        $this->db->where('hot_film.state', 1);
        $_POST['offset'] = 0;
        $_POST['limit']  = 5;
        $data            = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "hot_film");
        // var_dump($this->db->last_query());exit();
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }

    }
    //添加報名
    public function add_apply()
    {
        $type       = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        $name       = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        $team_name  = mb_strlen(trim(isset($_POST['team_name']) ?: "")) == 0 ? "" : trim($_POST['team_name']);
        $no         = mb_strlen(trim(isset($_POST['no']) ?: "")) == 0 ? "" : trim($_POST['no']);
        $manifesto  = mb_strlen(trim(isset($_POST['manifesto']) ?: "")) == 0 ? "" : trim($_POST['manifesto']);
        $imgs       = mb_strlen(trim(isset($_POST['imgs']) ?: "")) == 0 ? "" : trim($_POST['imgs']);
        $phone      = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
        $crew1_name = mb_strlen(trim(isset($_POST['crew1_name']) ?: "")) == 0 ? "" : trim($_POST['crew1_name']);
        $crew1_no   = mb_strlen(trim(isset($_POST['crew1_no']) ?: "")) == 0 ? "" : trim($_POST['crew1_no']);
        $crew2_name = mb_strlen(trim(isset($_POST['crew2_name']) ?: "")) == 0 ? "" : trim($_POST['crew2_name']);
        $crew2_no   = mb_strlen(trim(isset($_POST['crew2_no']) ?: "")) == 0 ? "" : trim($_POST['crew2_no']);
        $crew3_name = mb_strlen(trim(isset($_POST['crew3_name']) ?: "")) == 0 ? "" : trim($_POST['crew3_name']);
        $crew3_no   = mb_strlen(trim(isset($_POST['crew3_no']) ?: "")) == 0 ? "" : trim($_POST['crew3_no']);
        $crew4_name = mb_strlen(trim(isset($_POST['crew4_name']) ?: "")) == 0 ? "" : trim($_POST['crew4_name']);
        $crew4_no   = mb_strlen(trim(isset($_POST['crew4_no']) ?: "")) == 0 ? "" : trim($_POST['crew4_no']);

        $sql_data = [
            "type"       => $type,
            "name"       => $name,
            "team_name"  => $team_name,
            "no"         => $no,
            "manifesto"  => $manifesto,
            "imgs"       => $imgs,
            "phone"      => $phone,
            "crew1_name" => $crew1_name,
            "crew1_no"   => $crew1_no,
            "crew2_name" => $crew2_name,
            "crew2_no"   => $crew2_no,
            "crew3_name" => $crew3_name,
            "crew3_no"   => $crew3_no,
            "crew4_name" => $crew4_name,
            "crew4_no"   => $crew4_no,
            "created_at" => date("Y-m-d H:i:s", time()),
        ];
        if ($this->db->insert("apply", $sql_data)) {
            return return_app_json('200', '報名成功', null);
        } else {
            return return_app_json('104', '報名成功', null);
        }

    }
    //獲取預測贏家圖片
    public function get_prediction_win_image()
    {
        $this->db->select(['imgs']);
        $this->db->where('activities_time_start <=', date('Y-m-d H:i:s'));
        $this->db->where('activities_time_end >=', date('Y-m-d H:i:s'));
        $this->db->where('state', 1);

        $query = $this->db->get("prediction_win_image");
        $data  = $query->row();
        // var_dump($this->db->last_query());exit();
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", null);
        }

    }
    //獲取報名
    public function get_apply()
    {
        $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        // if ($user_model) {
        $field = array(
            'apply.id',
            'apply.name',
            'apply.imgs',
            'apply.manifesto',
            'apply.poll',
        );
        $this->db->select($field);
        if ($name != "") {
            $this->db->group_start();
            $this->db->like('apply.name', $name);
            $this->db->group_end();
        }

        $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "apply");
        // var_dump($this->db->last_query());exit();
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //投票
    public function vote()
    {
        $account  = mb_strlen(trim(isset($_POST['account']) ?: "")) == 0 ? "" : trim($_POST['account']);
        $apply_id = mb_strlen(trim(isset($_POST['apply_id']) ?: "")) == 0 ? "" : trim($_POST['apply_id']);
        if(empty($account) || empty($apply_id)){
            return return_app_json('104', '投票失败', null);
        }
        $this->load->driver('lock', array('adapter' => 'file', 'key_prefix' => ''));
        $this->lock->lock('vote');
        $query = $this->db->where('account', $account)
            ->like('created_at', date('Y-m-d'))
            ->get('vote');
        $res = $query->row();
        if ($res) {
            $this->lock->unlock('vote');
            return return_app_json('102', '今日已投过', null);
        }
        $sql_data = [
            "account"    => $account,
            "created_at" => date("Y-m-d H:i:s", time()),
        ];
        if ($this->db->insert("vote", $sql_data)) {
            //票数加1
            $this->db->where('id', $apply_id)
                ->set('poll', 'poll+1', false)
                ->update('apply');
            //抽獎
            $data=$this->lottery();
            $this->lock->unlock('vote');
            return return_app_json('200', '投票成功', $data);
        } else {
            $this->lock->unlock('vote');
            return return_app_json('104', '投票失败', null);
        }
    }

    //抽奖
    public function lottery()
    {
        $this->load->driver('lock', array('adapter' => 'file', 'key_prefix' => ''));
        $this->lock->lock('lottery');
        $data = $this->Data_helper_model->get_model_list_in_fileds('roulette', ['state'], [1]);
        $sum  = 0; //總數
        foreach ($data as $key => $value) {
            $sum += $value->odds;
        }
        $start = 0; //區間開始
        $i     = 1; //區間結束
        foreach ($data as $key => $value) {
            $start += $value->odds;
            $data[$key]->qj = [$i, $start];
            $i              = $start + 1;
        }
        $num = rand(1, $sum); //隨機數
        $j; //中獎獎品
        foreach ($data as $key => $value) {
            if ($num >= $value->qj[0] && $num <= $value->qj[1]) {
                $j = $value;
            }
        }
        // var_dump($data);exit();
        $model = [
            'id'   => $j->id,
            'name' => $j->name,
            'type' => $j->type,
        ];
        $this->lock->unlock('lottery');

        return $model;
        // var_dump($data);exit();
    }
    //獎品列表
    public function get_roulette()
    {
        $query = $this->db->select(['id', 'name','odds','type'])->where('state', 1)->get('roulette');
        $data  = $query->result();
        $query = $this->db->select_sum('odds')->where('state', 1)->get('roulette');
        $sum  = $query->row();
        // foreach ($data as $key => $value) {
        // 	$data[$key]->degree =intval(360*($value->odds/$sum->odds));
        // }
        return return_app_json('200', '成功', $data);
        // var_dump($data);exit();
    }
    //领取奖品
    public function get_prize()
    {
        $awards  = mb_strlen(trim(isset($_POST['awards']) ?: "")) == 0 ? "" : trim($_POST['awards']);
        $name    = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['session_name()']);
        $phone   = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
        $address = mb_strlen(trim(isset($_POST['address']) ?: "")) == 0 ? "" : trim($_POST['address']);

        $this->load->driver('lock', array('adapter' => 'file', 'key_prefix' => ''));
        $this->lock->lock('get_prize');

        $roulette = $this->Data_helper_model->get_model_in_id("roulette", $awards);
        if ($roulette->stock < 1) {
            return return_app_json('104', '庫存不足', null);
        }
        $sql_data = [
            "awards"     => $awards,
            "name"       => $name,
            "phone"      => $phone,
            "address"    => $address,
            "created_at" => date("Y-m-d H:i:s", time()),
        ];
        if ($this->db->insert("winning", $sql_data)) {

            //奖品库存减1
            $this->db->where('id', $awards)
                ->set('stock', 'stock-1', false)
                ->update('roulette');

            $this->lock->unlock('get_prize');
            return return_app_json('200', '成功', null);
        } else {
            $this->lock->unlock('get_prize');
            return return_app_json('104', '失败', null);
        }

    }
    //驗證
    public function verification()
    {
        $mb_no = mb_strlen(trim(isset($_POST['mb_no']) ?: "")) == 0 ? "" : trim($_POST['mb_no']);
    	// https://www.cinch-api.com.tw/CinchAPP/member.php?partnerID=173&invoke=checkuser&token=31890c5d7b58e2baf4c20f144c2c6f26&formData={"mb_no":"8159675"}
    	$this->load->helper('curl');
    	// $mb_no=8159675;
    	$fordata='{"mb_no":"'.$mb_no.'"}';
    	$token=md5($fordata);
    	$url='https://www.cinch-api.com.tw/CinchAPP/member.php?partnerID=173&invoke=checkuser&token='.$token.'&formData='.$fordata;
    	$aa=curl_get($url);

	    ob_end_clean();
	    $this->output
	        ->set_content_type('application/json', 'utf-8')
	        ->set_output($aa)
	        ->_display();
	    exit;

    }

}
