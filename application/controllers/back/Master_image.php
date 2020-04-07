<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Master_image extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 狀態標籤管理
     */
    public function master_image_list()
    {
        if (IS_POST) {
//            return;
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field = array(
                'master_image.id',
                'master_image.title',
                'master_image.imgs',
                'master_image.activities_time_start',
                'master_image.activities_time_end',
                'master_image.created_at',
                'master_image.state',
                'master_image.updated_at'
            );

            $this->db->select($field);
            if ($title != "") {
                $this->db->group_start();
                $this->db->like('title', $title);
                $this->db->group_end();


            }
            if ($state != "") {
                $this->db->where('state', $state);
            }

            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('user_ratings.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('master_image.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "master_image");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "主頁主圖列表";
            $data['open_home'] = "open";
            $data['active_master_image'] = "active";
            $data['h_title'] = "主頁主圖管理";
            $data['edit'] = base_url('back/Master_image/master_image_edit/');
            $data['api_list'] = base_url('back/Master_image/master_image_list');
            $data['api_delete'] = base_url('back/Master_image/master_image_delete');
            $data['state'] = base_url('back/Master_image/master_image_state');
            $this->load->view("back/Master_image/master_image_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function master_image_edit($id = "")
    {
        if (IS_GET) {
            $data['open_home'] = "open";
            $data['active_master_image'] = "active";
            $data['list'] = base_url('back/Master_image/master_image_list');
            $data['edit'] = base_url('back/Master_image/master_image_edit/');
            $data['list_title'] = "主頁主圖列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "主頁主圖編輯";
                $model = $this->Data_helper_model->get_model_in_id("master_image", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "title" => $model->title,
                        "activities_time" => $model->activities_time_start.'~'.$model->activities_time_end,
//                        "activities_time" => $model->activities_time_end,
                        "imgs" => $model->imgs,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Master_image/master_image_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Master_image/master_image_list'));
                }
            } else {
                $data['title'] = "新增主頁主圖";
                $this->load->view("back/Master_image/master_image_edit", $data);
            }
        }
        if (IS_POST) {
//            return;
            $errors = [];
            $json_obj = mb_strlen(trim(isset($_POST['json_obj']) ?: "")) == 0 ? "" : trim($_POST['json_obj']);
            if ($json_obj == "") {
                $errors[] = '請補全相關資料';
            }
            $api_obj = json_decode($json_obj, TRUE);

            $id = mb_strlen(trim(isset($api_obj['id']) ?: "")) == 0 ? "" : trim($api_obj['id']);
            $title = mb_strlen(trim(isset($api_obj['title']) ?: "")) == 0 ? "" : trim($api_obj['title']);
            $content = mb_strlen(trim(isset($api_obj['content']) ?: "")) == 0 ? "" : trim($api_obj['content']);
            $sort = mb_strlen(trim(isset($api_obj['sort']) ?: "")) == 0 ? "" : trim($api_obj['sort']);
            $state = mb_strlen(trim(isset($api_obj['state']) ?: "")) == 0 ? "" : trim($api_obj['state']);
            $integral = mb_strlen(trim(isset($api_obj['integral']) ?: "")) == 0 ? "" : trim($api_obj['integral']);
            $activities_time = mb_strlen(trim(isset($_POST['activities_time']) ?: "")) == 0 ? "" : trim($_POST['activities_time']);


            if ($title == "") {
                $errors[] = "標題不可為空";
            }
            
            if ($activities_time == "") {
                $errors[] = "期間不可為空";
            }
            $activities_time=explode('~',$activities_time);
            $up_img_src = "";
            if (isset($_FILES) && count($_FILES) > 0) {
                $this->load->library("Custom_upload");
                foreach ($_FILES as $k => $file) {
                    if (isset($file['name'])) {
                        $path = "updata/Master_image/" . date("Y-m", time());
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
                    "activities_time_start" => $activities_time[0],
                    "activities_time_end" => $activities_time[1],
                    "title" => $title,
                    "state" => $state ? 1 : 0 ,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($up_img_src != "") {
                    $sql_data["imgs"] = $up_img_src;
                } else if (empty($api_obj['imgs'])) {
                    $sql_data["imgs"] = "";
                }

                if ($this->Data_helper_model->update_table_in_fileds(
                    "master_image",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Master_image/master_image_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {

                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }

                $sql_data = [
                    "activities_time_start" => $activities_time[0],
                    "activities_time_end" => $activities_time[1],
                    "title" => $title,
                    "imgs" => $up_img_src,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("master_image", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Master_image/master_image_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function master_image_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "master_image", $field, $value)) {
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
     * 刪除狀態標籤
     */
    public function master_image_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('master_image', $val)) {
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
