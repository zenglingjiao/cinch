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
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $third_login = mb_strlen(trim(isset($_POST['third_login']) ?: "")) == 0 ? "" : trim($_POST['third_login']);
            $lev = mb_strlen(trim(isset($_POST['lev']) ?: "")) == 0 ? "" : trim($_POST['lev']);
            $class_type = mb_strlen(trim(isset($_POST['class_type']) ?: "")) == 0 ? "" : trim($_POST['class_type']);
            $field = array(
                'activities_details.id',
                'activities_details.type',
                'activities_details.title',
                // 'activities_details.goods_type_id',
                // 'activities_details.purchase_way',
                // 'activities_details.pic',
                'activities_details.created_at',
                // 'activities_details.state_label',
                'activities_details.updated_at',
                // 'activities_details.name as goods_type',
            );

            $this->db->select($field);
            if ($name != "") {
                $this->db->group_start();
                $this->db->like('name', $name);
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
            $data['title'] = "物品列表";
            $data['open_challenge'] = "open";
            $data['active_activities_details'] = "active";
            $data['h_title'] = "物品管理";
            $data['api_edit'] = base_url('back/Activities_details/activities_details_edit/');
            $data['api_list'] = base_url('back/Activities_details/activities_details_list');
            $data['api_delete'] = base_url('back/Activities_details/activities_details_delete');
            $data['api_state'] = base_url('back/Activities_details/activities_details_status');

            $mc_list = $this->Data_helper_model->get_model_list_in_fileds("goods_class", ["class_type"], [1]);
            $sc_list = $this->Data_helper_model->get_model_list_in_fileds("goods_class", ["class_type"], [2]);
            $main_class_list = [];
            if (isset($mc_list)) {
                foreach ($mc_list as $mc) {
                    foreach ($sc_list as $sc) {
                        if ($mc->id == $sc->parent_id) {
                            $main_class_list[] = $mc;
                            break;
                        }
                    }
                }
            }
            $data["main_class_list"] = $main_class_list;
            $data["small_class_list"] = $sc_list;
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
            $data['list_title'] = "物品列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "物品編輯";
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
                        "awards_explain" => $model->awards_explain,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Activities_details/activities_details_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Activities_details/activities_details_list'));
                }
            } else {
                $data['title'] = "物品新增";
                $this->load->view("back/Activities_details/activities_details_edit", $data);
            }
        }
        if (IS_POST) {
        	// var_dump($_FILES);exit();
         //   return;
            $errors = [];
            $json_obj = mb_strlen(trim(isset($_POST['json_obj']) ?: "")) == 0 ? "" : trim($_POST['json_obj']);
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

            $up_img_src = "";
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
                $up_img_src=json_encode($arr);
        		// var_dump($up_img_src);exit();

            }

            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "name" => $name,
                    "up_user" => $up_user,
                    "goods_type_id" => $goods_type_id,
                    "purchase_way" => $purchase_way,
                    "m_place" => $m_place,
                    "custom_label" => $custom_label,
                    "use_number" => $use_number,
                    "storage_titme" => $storage_titme,
                    "storage_titme_units" => $storage_titme_units,
                    "state_label" => json_encode($state_label),
                    "freight" => $freight,
                    "freight_pt" => $freight_pt,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                if ($up_img_src != "") {
                    if($has_upimg==''){
                        $sql_data["pic"] = $up_img_src;
                    }else{
                        $sql_data["pic"] = $has_upimg.','.$up_img_src;
                    }
                } else{
                    $sql_data["pic"] =  $has_upimg;
                }
                if ($this->Data_helper_model->update_table_in_fileds(
                    "goods",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Goods/goods_list'), null);
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
//                if (!empty($errors)) {
//                    $error = implode(", ", $errors);
//                    return_post_json("err", $error, "", null);
//                }


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
                    "awards_imgs" => $up_img_src,
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
    public function main_class_status()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "goods_class", $field, $value)) {
                // $db_debug = $this->db->db_debug;
                // $this->db->db_debug = FALSE;
                // $sql_data = [
                //     "updated_at"=>date("Y-m-d H:i:s", time())
                // ];
                // $this->db->where("id", $id);
                // if(!$this->db->update($tabel, $sql_data))
                // {
                //     $error = $this->db->error();
                // }
                // $this->db->db_debug = $db_debug;
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
    public function main_class_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('goods_class', $val)) {
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


    /**
     * 次分類管理
     */
    public function small_class_list()
    {
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $class_type = mb_strlen(trim(isset($_POST['class_type']) ?: "")) == 0 ? "" : trim($_POST['class_type']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $third_login = mb_strlen(trim(isset($_POST['third_login']) ?: "")) == 0 ? "" : trim($_POST['third_login']);
            $lev = mb_strlen(trim(isset($_POST['lev']) ?: "")) == 0 ? "" : trim($_POST['lev']);
            $field = array(
                'goods_class.id',
                'goods_class.name',
                'goods_class.class_type',
                'goods_class.parent_id',
                'goods_class.pic',
                'goods_class.created_at',
                'goods_class.state',
                'goods_class.updated_at',
                'main_class.name main_name',
            );

            $this->db->select($field);
            $this->db->where('goods_class.class_type', "2");
            if ($name != "") {
                $this->db->group_start();
                $this->db->like('goods_class.name', $name);
                $this->db->group_end();


            }
            if ($state != "") {
                $this->db->where('goods_class.state', $state);
            }
            if ($class_type != "") {
                $this->db->where('goods_class.parent_id', $class_type);
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('goods_class.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('goods_class.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            $this->db->join("goods_class main_class", 'main_class.id = goods_class.parent_id', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "goods_class");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "分類列表";
            $data['open_goods'] = "open";
            $data['active_small_class'] = "active";
            $data['h_title'] = "小分類管理";
            $data['h_title'] = "主分類管理";
            $data['api_edit'] = base_url('back/Goods_class/small_class_edit');
            $data['api_list'] = base_url('back/Goods_class/small_class_list');
            $data['api_delete'] = base_url('back/Goods_class/small_class_delete');
            $data['api_state'] = base_url('back/Goods_class/small_class_status');
            $data['main_class_list'] = $this->Data_helper_model->get_model_list_in_fileds("goods_class", ["class_type"], [1]);
            $this->load->view("back/Goods_class/small_class_list", $data);
        }
    }


    /**
     * 次分類編輯
     */
    public function small_class_edit($id = "")
    {
        if (IS_GET) {
            $data['open_goods'] = "open";
            $data['active_small_class'] = "active";
            $data['api_list'] = base_url('back/Goods_class/small_class_list');
            $data['api_edit'] = base_url('back/Goods_class/small_class_edit');
            $data['list_title'] = "次分類列表";
            $data['main_type_list'] = $this->Data_helper_model->get_model_list_in_fileds("goods_class", ["class_type"], [1]);
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "次分類編輯";
                $model = $this->Data_helper_model->get_model_in_id("goods_class", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "name" => $model->name,
                        "class_type" => $model->class_type,
                        "parent_id" => $model->parent_id,
                        "pic" => $model->pic,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Goods_class/small_class_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Goods_class/small_class_list'));
                }
            } else {
                $data['title'] = "次分類新增";
                $this->load->view("back/Goods_class/small_class_edit", $data);
            }
        }
        if (IS_POST) {
            $errors = [];
            $json_obj = mb_strlen(trim(isset($_POST['json_obj']) ?: "")) == 0 ? "" : trim($_POST['json_obj']);
            if ($json_obj == "") {
                $errors[] = '請補全相關資料';
            }
            $api_obj = json_decode($json_obj, TRUE);

            $id = mb_strlen(trim(isset($api_obj['id']) ?: "")) == 0 ? "" : trim($api_obj['id']);
            $name = mb_strlen(trim(isset($api_obj['name']) ?: "")) == 0 ? "" : trim($api_obj['name']);
            $state = mb_strlen(trim(isset($api_obj['state']) ?: "")) == 0 ? "" : trim($api_obj['state']);
            $parent_id = mb_strlen(trim(isset($api_obj['parent_id']) ?: "")) == 0 ? "" : trim($api_obj['parent_id']);

            if ($name == "") {
                $errors[] = "分類名稱不可為空";
            }

            $up_img_src = "";
            if (isset($_FILES) && count($_FILES) > 0) {
                $this->load->library("Custom_upload");
                foreach ($_FILES as $k => $file) {
                    if (isset($file['name'])) {
                        $path = "updata/goods_class/" . date("Y-m", time());
                        $up_img_file_name = $this->custom_upload->single_upload($k, date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "jpeg|jpg|gif|png"]);
                        if ($up_img_file_name) {
                            $up_img_src = $path . "/" . $up_img_file_name;
                        }
                    }
                }
            }


            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "name" => $name,
                    "state" => $state ? 1 : 0,
                    //"class_type" => 2,
                    "parent_id" => $parent_id,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                if ($up_img_src != "") {
                    $sql_data["pic"] = $up_img_src;
                } else if (empty($api_obj['pic'])) {
                    $sql_data["pic"] = "";
                }


                if ($this->Data_helper_model->update_table_in_fileds(
                    "goods_class",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Goods_class/small_class_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                //
                if ($name == "") {
                    $errors[] = "分類名稱不可為空";
                }
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }


                $sql_data = [
                    "name" => $name,
                    "class_type" => 2,
                    "state" => $state,
                    "pic" => $up_img_src,
                    "parent_id" => $parent_id,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("goods_class", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Goods_class/small_class_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }


}
