<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Label_state extends Admin_Controller
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
    public function label_list()
    {
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $third_login = mb_strlen(trim(isset($_POST['third_login']) ?: "")) == 0 ? "" : trim($_POST['third_login']);
            $lev = mb_strlen(trim(isset($_POST['lev']) ?: "")) == 0 ? "" : trim($_POST['lev']);
            $field = array(
                'status_label.id',
                'status_label.name',
                'status_label.created_at',
                'status_label.state',
                'status_label.updated_at'
            );

            $this->db->select($field);
            if ($name != "") {
                $this->db->group_start();
                $this->db->like('name', $name);
                $this->db->group_end();


            }
            if ($state != "") {
                $this->db->where('state', $state);
            }

            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('goods_class.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('goods_class.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "status_label");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "狀態標籤列表";
            $data['open_label'] = "open";
            $data['active_label'] = "active";
            $data['h_title'] = "狀態標籤管理";
            $data['edit'] = base_url('back/Label_state/Label_edit/');
            $data['api_list'] = base_url('back/Label_state/label_list');
            $data['api_delete'] = base_url('back/Label_state/label_delete');
            $data['state'] = base_url('back/Label_state/label_state');
            $this->load->view("back/Label_state/label_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function label_edit($id = "")
    {
        if (IS_GET) {
            $data['open_label'] = "open";
            $data['active_label'] = "active";
            $data['list'] = base_url('back/Label_state/label_list');
            $data['edit'] = base_url('back/Label_state/Label_edit/');
            $data['list_title'] = "狀態標籤列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "狀態標籤編輯";
                $model = $this->Data_helper_model->get_model_in_id("status_label", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "name" => $model->name,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Label_state/label_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Label_state/label_list'));
                }
            } else {
                $data['title'] = "新增狀態標籤";
                $this->load->view("back/Label_state/label_edit", $data);
            }
        }
        if (IS_POST) {
            $errors = [];
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);

            if ($name == "") {
                $errors[] = "狀態標籤名稱不可為空";
            }

            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "name" => $name,
                    "state" => $state ? 1 : 0 ,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($this->Data_helper_model->update_table_in_fileds(
                    "status_label",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Label_state/label_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                //
                if ($name == "") {
                    $errors[] = "狀態標籤名稱不可為空";
                }
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }


                $sql_data = [
                    "name" => $name,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("status_label", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Label_state/label_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function label_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "status_label", $field, $value)) {
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
    public function label_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('status_label', $val)) {
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