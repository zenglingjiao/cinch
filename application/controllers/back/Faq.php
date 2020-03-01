<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Members
 */
class Faq extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }


    /**
     * 常見問題管理
     */
    public function faq_list()
    {
        if (IS_POST) {
            $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field = array(
                'faq.id',
                'faq.title',
                'faq.type',
                'faq.sort',
                'faq.created_at',
                'faq.state',
                'faq.updated_at'
            );

            $this->db->select($field);
            if ($type != "") {
                $this->db->group_start();
                $this->db->where('type', $type);
                $this->db->group_end();
            }
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
                $this->db->where('faq.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('faq.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "faq");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "常見問題列表";
            $data['open_faq'] = "open";
            $data['active_faq'] = "active";
            $data['h_title'] = "常見問題管理";
            $data['edit'] = base_url('back/Faq/faq_edit/');
            $data['api_list'] = base_url('back/Faq/faq_list');
            $data['api_delete'] = base_url('back/Faq/faq_delete');
            $data['state'] = base_url('back/Faq/faq_state');
            $this->load->view("back/Faq/faq_list", $data);
        }
    }

    /**
     * 常見問題編輯
     */
    public function faq_edit($id = "")
    {
        if (IS_GET) {
            $data['open_faq'] = "open";
            $data['active_faq'] = "active";
            $data['list'] = base_url('back/Faq/faq_list');
            $data['edit'] = base_url('back/Faq/faq_edit/');
            $data['list_title'] = "常見問題列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "常見問題編輯";
                $model = $this->Data_helper_model->get_model_in_id("faq", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "title" => $model->title,
                        "type" => $model->type,
                        "content" => $model->content,
                        "sort" => $model->sort,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Faq/faq_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Faq/faq_list'));
                }
            } else {
                $data['title'] = "新增常見問題";
                $this->load->view("back/Faq/faq_edit", $data);
            }
        }
        if (IS_POST) {
//            return;
            $errors = [];
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
            $content = mb_strlen(trim(isset($_POST['content']) ?: "")) == 0 ? "" : trim($_POST['content']);
            $sort = mb_strlen(trim(isset($_POST['sort']) ?: "")) == 0 ? "" : trim($_POST['sort']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);

            if ($title == "") {
                $errors[] = "標題不可為空";
            }
            if ($type == "") {
                $errors[] = "分類不可為空";
            }
            if ($content == "") {
                $errors[] = "內容不可為空";
            }

            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "title" => $title,
                    "type" => $type,
                    "content" => $content,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0 ,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($this->Data_helper_model->update_table_in_fileds(
                    "faq",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Faq/faq_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                //

                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }

                $sql_data = [
                    "title" => $title,
                    "type" => $type,
                    "content" => $content,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("faq", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Faq/faq_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }
    /**
     * 標籤管理狀態
     */
    public function faq_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "faq", $field, $value)) {
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
    public function faq_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('faq', $val)) {
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