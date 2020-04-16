<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Activities_details extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 物品列表
     */
    public function activities_details_list()
    {
        if (IS_POST) {
            $title = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $third_login = mb_strlen(trim(isset($_POST['third_login']) ?: "")) == 0 ? "" : trim($_POST['third_login']);
            $lev = mb_strlen(trim(isset($_POST['lev']) ?: "")) == 0 ? "" : trim($_POST['lev']);
            $class_type = mb_strlen(trim(isset($_POST['class_type']) ?: "")) == 0 ? "" : trim($_POST['class_type']);
            $field = array(
                'activities_details.id',
                'activities_details.type',
                'activities_details.title',
                'activities_details.added_at',
                // 'activities_details.purchase_way',
                // 'activities_details.pic',
                'activities_details.created_at',
                'activities_details.state',
                'activities_details.updated_at',
                // 'activities_details.name as goods_type',
            );

            $this->db->select($field);
            if ($title != "") {
                $this->db->group_start();
                $this->db->like('title', $title);
                $this->db->group_end();


            }
            if ($class_type != "") {
                $this->db->where('goods.goods_type_id', $class_type);
            }
            if ($state != "") {
                $this->db->where('goods.state', $state);
            }
            if ($lev != "") {
                $this->db->where('lev', $lev);
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('activities_details.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('activities_details.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            // $this->db->join("goods_class", 'goods_class.id = goods.goods_type_id', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "activities_details");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "活動詳情列表";
            $data['open_challenge'] = "open";
            $data['active_activities_details'] = "active";
            $data['h_title'] = "活動詳情管理";
            $data['api_edit'] = base_url('back/Activities_details/activities_details_edit/');
            $data['api_list'] = base_url('back/Activities_details/activities_details_list');
            $data['api_delete'] = base_url('back/Activities_details/activities_details_delete');
            $data['api_state'] = base_url('back/Activities_details/activities_details_status');
            $this->load->view("back/Activities_details/activities_details_list", $data);
        }
    }

    /**
     * 物品編輯
     */
    public function activities_details_edit($id = "")
    {
        if (IS_GET) {
            $data['open_challenge'] = "open";
            $data['active_activities_details'] = "active";
            $data['api_list'] = base_url('back/Activities_details/activities_details_list');
            $data['api_edit'] = base_url('back/Activities_details/activities_details_edit');
            $data['list_title'] = "活動詳情列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "活動詳情編輯";
                $model = $this->Data_helper_model->get_model_in_id("activities_details", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "type" => $model->type,
                        "title" => $model->title,
                        "qualification" => $model->qualification,
                        "announcements_activities" => $model->announcements_activities,
                        "announcements_apply" => $model->announcements_apply,
                        "entry" => $model->entry,
                        "competition_period" => $model->competition_period,
                        "apply_period" => $model->apply_period,
                        "img_schedule" => $model->img_schedule,
                        "img_scoring" => $model->img_scoring,
                        "added_at" => $model->added_at,
                        "awards_imgs" => json_decode($model->awards_imgs),
                        "awards_explain" => json_decode($model->awards_explain),
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Activities_details/activities_details_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Activities_details/activities_details_list'));
                }
            } else {
                $data['title'] = "活動詳情新增";
                $this->load->view("back/Activities_details/activities_details_edit", $data);
            }
        }
        if (IS_POST) {
        	// var_dump($_FILES);exit();
         //   return;
            $errors = [];
            $json_obj = mb_strlen(trim(isset($_POST['json_obj']) ?: "")) == 0 ? "" : trim($_POST['json_obj']);
            $has_upimg = mb_strlen(trim(isset($_POST['has_upimg']) ?: "")) == 0 ? "" : trim($_POST['has_upimg']);
            $apply_period = mb_strlen(trim(isset($_POST['apply_period']) ?: "")) == 0 ? "" : trim($_POST['apply_period']);
            $competition_period = mb_strlen(trim(isset($_POST['competition_period']) ?: "")) == 0 ? "" : trim($_POST['competition_period']);
            $added_at = mb_strlen(trim(isset($_POST['added_at']) ?: "")) == 0 ? "" : trim($_POST['added_at']);
            $awards_explain = mb_strlen(trim(isset($_POST['awards_explain']) ?: "")) == 0 ? "" : trim($_POST['awards_explain']);

            if ($json_obj == "") {
                $errors[] = '請補全相關資料';
            }
            $api_obj = json_decode($json_obj, TRUE);

            $id = mb_strlen(trim(isset($api_obj['id']) ?: "")) == 0 ? "" : trim($api_obj['id']);
            $type = mb_strlen(trim(isset($api_obj['type']) ?: "")) == 0 ? "" : trim($api_obj['type']);
            $title = mb_strlen(trim(isset($api_obj['title']) ?: "")) == 0 ? "" : trim($api_obj['title']);
            $qualification = mb_strlen(trim(isset($api_obj['qualification']) ?: "")) == 0 ? "" : trim($api_obj['qualification']);
            $announcements_activities = mb_strlen(trim(isset($api_obj['announcements_activities']) ?: "")) == 0 ? "" : trim($api_obj['announcements_activities']);
            $state = mb_strlen(trim(isset($api_obj['state']) ?: "")) == 0 ? "" : trim($api_obj['state']);
            $announcements_apply = mb_strlen(trim(isset($api_obj['announcements_apply']) ?: "")) == 0 ? "" : trim($api_obj['announcements_apply']);
            $entry = mb_strlen(trim(isset($api_obj['entry']) ?: "")) == 0 ? "" : trim($api_obj['entry']);
//            if ($name == "") {
//                $errors[] = "分類名稱不可為空";
//            }
            if($added_at < date("Y-m-d H:i:s", time())){
               $errors[] = "上架時間不能早於當前時間";
            }
            //同一時間同一類型上架限制為一筆
            if($state){
            	//1團體2個人
            	$count=$this->Data_helper_model->get_model_list_in_fileds("activities_details", ['state' , 'added_at' ,'id !=' , 'type'], [1 ,$added_at ,$id ,$type]);
            	if($type == 1){
            		if(count($count) >= 1){
		                $errors[] = "同一時間團體上架限制為一筆";
		        	}
            	}else{
            		if(count($count) >= 1){
		                $errors[] = "同一時間個人上架限制為一筆";
		        	}
            	}
            	
	        
            }
            $up_img_src = "";
            $img_scoring = "";
            $img_schedule = "";
            if (isset($_FILES) && count($_FILES) > 0) {
                $this->load->library("Custom_upload");
               // var_dump($_FILES );exit();
                $arr=array();
                foreach ($_FILES as $k => $file) {

                    if (isset($file['name'])) {
                        $path = "updata/goods/" . date("Y-m", time());
                        $up_img_file_name = $this->custom_upload->single_upload($k, date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "jpeg|jpg|gif|png"]);
                        if ($k=='img_scoring'){
                        	$img_scoring=$path . "/" . $up_img_file_name;
                        }elseif($k=='img_schedule'){
                        	$img_schedule=$path . "/" . $up_img_file_name;
                        }else{
                        	if ($up_img_file_name) {
	                            $arr[] = $path . "/" . $up_img_file_name;
	                        }
                        }
                    }
                }
                $up_img_src=$arr;
        		// var_dump($up_img_src);exit();

            }

            if (!empty($id)) {
                //
                // return;
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "type" => $type,
                    "title" => $title,
                    "qualification" => $qualification,
                    "announcements_activities" => $announcements_activities,
                    "announcements_apply" => $announcements_apply,
                    "entry" => $entry,
                    "competition_period" => $competition_period,
                    "apply_period" => $apply_period,
                    "state" => $state,
                    "added_at" => $added_at,
                    // "state" => $state,
                    "awards_explain" => $awards_explain,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                //处理多张
                if ($up_img_src != "") {
                    if($has_upimg==''){
                        $sql_data["awards_imgs"] = $up_img_src;
                    }else{
                        $sql_data["awards_imgs"] = array_merge(explode(',',$has_upimg),$up_img_src);
                    }
                } else{
                    $sql_data["awards_imgs"] =  explode(',',$has_upimg);
                }
                $sql_data["awards_imgs"]=json_encode($sql_data["awards_imgs"]);
                //处理计分图片
                if ($img_scoring != "") {
                    $sql_data["img_scoring"] = $img_scoring;
                } else if (empty($api_obj['img_scoring'])) {
                    $sql_data["img_scoring"] = "";
                }
                 //处理赛程图片
                if ($img_schedule != "") {
                    $sql_data["img_schedule"] = $img_schedule;
                } else if (empty($api_obj['img_schedule'])) {
                    $sql_data["img_schedule"] = "";
                }
                // return_post_json('','','',$sql_data);
                if ($this->Data_helper_model->update_table_in_fileds(
                    "activities_details",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Activities_details/activities_details_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
//                if ($name == "") {
//                    $errors[] = "物品名稱不可為空";
//                }
//                if ($up_user == "") {
//                    $errors[] = "上傳帳號不可為空";
//                }
//                if ($purchase_way == "") {
//                    $errors[] = "取物方式不可為空";
//                }
//                if ($storage_titme == "") {
//                    $errors[] = "存放時間不可為空";
////                }
               if (!empty($errors)) {
                   $error = implode(", ", $errors);
                   return_post_json("err", $error, "", null);
               }


                $sql_data = [
                    "type" => $type,
                    "title" => $title,
                    "qualification" => $qualification,
                    "announcements_activities" => $announcements_activities,
                    "announcements_apply" => $announcements_apply,
                    "entry" => $entry,
                    "competition_period" => $competition_period,
                    "apply_period" => $apply_period,
                    "img_schedule" => $img_schedule,
                    "img_scoring" => $img_scoring,
                    "state" => $state,
                    "added_at" => $added_at,
                    "awards_imgs" => json_encode($up_img_src),
                    "awards_explain" => $awards_explain,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("activities_details", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Activities_details/activities_details_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 主分類狀態
     */
    public function activities_details_status()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
        	if(!empty($value)){
        		$model = $this->Data_helper_model->get_model_in_id("activities_details", $id);
	        	
	        	$count=$this->Data_helper_model->get_model_list_in_fileds("activities_details", [$field , 'type' , 'added_at'], [$value , $model->type ,$model->added_at]);
	        	if(count($count) >= 1){
	                echo 2;
	                return;
	        	}
        	}
            if ($this->Data_helper_model->tabel_status($id, "activities_details", $field, $value)) {
              
                echo 1;
                return;
            } else {
                echo 0;
                return;
            }
        } else {
            echo 0;
            return;
        }
    }


    /**
     * 刪除主分類
     */
    public function activities_details_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('activities_details', $val)) {
                    $is_ok++;
                } else {
                    $is_err++;
                }
            }
            $msg = "成功刪除：" . $is_ok;
            $msg = $msg . " 失敗：" . $is_err;

            return_post_json("ok", "操作完成" . " " . $msg, "", null);
        }
    }


}
