<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Goods
 */
class Apply extends Admin_Controller
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
    public function apply_list()
    {
        if (IS_POST) {
//            return;
            $name   = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state  = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title  = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field  = array(
                'apply.id',
                'apply.name',
                'apply.type',
                'apply.imgs',
                'apply.created_at',
                'apply.updated_at',
            );

            $this->db->select($field);
            if ($title != "") {
                $this->db->group_start();
                $this->db->like('name', $title);
                $this->db->group_end();

            }
            if ($state != "") {
                $this->db->where('state', $state);
            }

            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('apply.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('apply.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "apply");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title']          = "報名列表";
            $data['open_challenge'] = "open";
            $data['active_apply']   = "active";
            $data['h_title']        = "報名管理";
            $data['edit']           = base_url('back/Apply/apply_edit/');
            $data['api_list']       = base_url('back/Apply/apply_list');
            $data['api_delete']     = base_url('back/Apply/apply_delete');
            $data['state']          = base_url('back/Apply/apply_state');
            $this->load->view("back/Apply/apply_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function apply_edit($id = "")
    {
        if (IS_GET) {
            $data['open_challenge'] = "open";
            $data['active_apply']   = "active";
            $data['list']           = base_url('back/Apply/apply_list');
            $data['edit']           = base_url('back/Apply/apply_edit/');
            $data['list_title']     = "報名列表";
            if (!empty($id)) {
                $id            = (int) $id;
                $data['title'] = "報名編輯";
                $model         = $this->Data_helper_model->get_model_in_id("apply", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id"         => $model->id,
                        "type"       => $model->type,
                        "name"       => $model->name,
                        "team_name"  => $model->team_name,
                        "no"         => $model->no,
                        "manifesto"  => $model->manifesto,
                        "imgs"       => $model->imgs,
                        "phone"      => $model->phone,
                        "crew1_name" => $model->crew1_name,
                        "crew1_no"   => $model->crew1_no,
                        "crew2_name" => $model->crew2_name,
                        "crew2_no"   => $model->crew2_no,
                        // "crew3_name" => $model->crew3_name,
                        // "crew3_no" => $model->crew3_no,
                        // "crew4_name" => $model->crew4_name,
                        // "crew4_no" => $model->crew4_no,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Apply/apply_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Apply/apply_list'));
                }
            } else {
                $data['title'] = "新增報名";
                $this->load->view("back/Apply/apply_edit", $data);
            }
        }
        if (IS_POST) {
//            return;
            $errors   = [];
            $json_obj = mb_strlen(trim(isset($_POST['json_obj']) ?: "")) == 0 ? "" : trim($_POST['json_obj']);
            if ($json_obj == "") {
                $errors[] = '請補全相關資料';
            }
            $api_obj = json_decode($json_obj, true);

            $id         = mb_strlen(trim(isset($api_obj['id']) ?: "")) == 0 ? "" : trim($api_obj['id']);
            $type       = mb_strlen(trim(isset($api_obj['type']) ?: "")) == 0 ? "" : trim($api_obj['type']);
            $team_name  = mb_strlen(trim(isset($api_obj['team_name']) ?: "")) == 0 ? "" : trim($api_obj['team_name']);
            $name       = mb_strlen(trim(isset($api_obj['name']) ?: "")) == 0 ? "" : trim($api_obj['name']);
            $no         = mb_strlen(trim(isset($api_obj['no']) ?: "")) == 0 ? "" : trim($api_obj['no']);
            $manifesto  = mb_strlen(trim(isset($api_obj['manifesto']) ?: "")) == 0 ? "" : trim($api_obj['manifesto']);
            $phone      = mb_strlen(trim(isset($api_obj['phone']) ?: "")) == 0 ? "" : trim($api_obj['phone']);
            $crew1_name = mb_strlen(trim(isset($api_obj['crew1_name']) ?: "")) == 0 ? "" : trim($api_obj['crew1_name']);
            $crew1_no   = mb_strlen(trim(isset($api_obj['crew1_no']) ?: "")) == 0 ? "" : trim($api_obj['crew1_no']);
            $crew2_name = mb_strlen(trim(isset($api_obj['crew2_name']) ?: "")) == 0 ? "" : trim($api_obj['crew2_name']);
            $crew2_no   = mb_strlen(trim(isset($api_obj['crew2_no']) ?: "")) == 0 ? "" : trim($api_obj['crew2_no']);
            // $crew3_name = mb_strlen(trim(isset($api_obj['crew3_name']) ?: "")) == 0 ? "" : trim($api_obj['crew3_name']);
            // $crew3_no = mb_strlen(trim(isset($api_obj['crew3_no']) ?: "")) == 0 ? "" : trim($api_obj['crew3_no']);
            // $crew4_name = mb_strlen(trim(isset($api_obj['crew4_name']) ?: "")) == 0 ? "" : trim($api_obj['crew4_name']);
            // $crew4_no = mb_strlen(trim(isset($api_obj['crew4_no']) ?: "")) == 0 ? "" : trim($api_obj['crew4_no']);

            // if ($title == "") {
            //     $errors[] = "標題不可為空";
            // }
            // if ($content == "") {
            //     $errors[] = "內容不可為空";
            // }
            // if ($integral == "") {
            //     $errors[] = "積分不可為空";
            // }
            // if ($activities_time == "") {
            //     $errors[] = "活動時間不可為空";
            // }
            $up_img_src = "";
            if (isset($_FILES) && count($_FILES) > 0) {
                $this->load->library("Custom_upload");
                foreach ($_FILES as $k => $file) {
                    if (isset($file['name'])) {
                        $path             = "updata/Apply/" . date("Y-m", time());
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
                    "type"       => $type,
                    "name"       => $name,
                    "team_name"  => $team_name,
                    "no"         => $no,
                    "manifesto"  => $manifesto,
                    "phone"      => $phone,
                    "crew1_name" => $crew1_name,
                    "crew1_no"   => $crew1_no,
                    "crew2_name" => $crew2_name,
                    "crew2_no"   => $crew2_no,
                    // "crew3_name" => $crew3_name,
                    // "crew3_no" => $crew3_no,
                    // "crew4_name" => $crew4_name,
                    // "crew4_no" => $crew4_no,
                    "updated_at" => date("Y-m-d H:i:s", time()),
                ];

                if ($up_img_src != "") {
                    $sql_data["imgs"] = $up_img_src;
                } else if (empty($api_obj['imgs'])) {
                    $sql_data["imgs"] = "";
                }

                if ($this->Data_helper_model->update_table_in_fileds(
                    "apply",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Apply/apply_list'), null);
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
                    "type"       => $type,
                    "name"       => $name,
                    "team_name"  => $team_name,
                    "no"         => $no,
                    "imgs"       => $up_img_src,
                    "manifesto"  => $manifesto,
                    "phone"      => $phone,
                    "crew1_name" => $crew1_name,
                    "crew1_no"   => $crew1_no,
                    "crew2_name" => $crew2_name,
                    "crew2_no"   => $crew2_no,
                    // "crew3_name" => $crew3_name,
                    // "crew3_no" => $crew3_no,
                    // "crew4_name" => $crew4_name,
                    // "crew4_no" => $crew4_no,
                    "created_at" => date("Y-m-d H:i:s", time()),
                ];
                if ($this->db->insert("apply", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Apply/apply_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function apply_state()
    {
        $id    = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "apply", $field, $value)) {
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
    public function apply_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok   = 0;
            $is_err  = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('apply', $val)) {
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

    //導出專案
    public function out_excel()
    {
        // return;
        $user_id = $this->session->userdata('id');
        if (isset($user_id) && $user_id > 0) {
        } else {
            return_get_msg("請重新登入", base_url('back/Admin/login'));
        }
        $name       = mb_strlen(trim(isset($_GET['name']) ?: "")) == 0 ? "" : trim($_GET['name']);
        $c_time     = mb_strlen(trim(isset($_GET['c_time']) ?: "")) == 0 ? "" : trim($_GET['c_time']);
        $excel_name = mb_strlen(trim(isset($_GET['excel_name']) ?: "")) == 0 ? "導出訂單" : trim($_GET['excel_name']);
        $field      = array(
            'apply.id',
            'apply.name',
            "if(type=1,'團體','個人') type",
            'apply.team_name',
            'apply.poll',
            'apply.no',
            'apply.manifesto',
            'apply.phone',
            'apply.crew1_name',
            'apply.crew1_no',
            'apply.crew2_name',
            'apply.crew2_no',
            'apply.created_at',
            'apply.updated_at',
        );

        $this->db->select($field);
        
        $this->load->library("Excel_generator");

        $query = $this->db->get('apply');
//        var_dump($this->db->last_query());exit();
        $this->excel_generator->set_query($query);
        $this->excel_generator->set_header(array(
            '類型',
            '主要人員姓名',
            '隊名',
            '會員編號',
            '手機',
            '宣言',
            '組員1姓名',
            '會員編號',
            '新朋友姓名',
            '會員編號',
            '創建時間',
        ));
        $this->excel_generator->set_column(array(
            'type',
            'name',
            'team_name',
            'no',
            'phone',
            'manifesto',
            'crew1_name',
            'crew1_no',
            'crew2_name',
            'crew2_no',
            'created_at',
        ));
        // $this->excel_generator->set_width(array(25, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30));
        $this->excel_generator->exportTo2007($excel_name . date("YmdHis"));
        return;
    }

}
