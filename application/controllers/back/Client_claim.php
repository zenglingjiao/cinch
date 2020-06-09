<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Goods
 */
class Client_claim extends Admin_Controller
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
    public function client_claim_list()
    {
        if (IS_POST) {
//            return;
            $name   = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state  = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title  = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field  = array(
                'client_claim.id',
                'client_claim.phone',
                'client_claim.name',
                'client_claim.email',
                'client_claim.line_id',
                'client_claim.created_at',
                'client_claim.updated_at',
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
                $this->db->where('client_claim.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('client_claim.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "client_claim");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title']               = "客戶索取列表";
            $data['open_client_claim']   = "open";
            $data['active_client_claim'] = "active";
            $data['h_title']             = "客戶索取管理";
            $data['edit']                = base_url('back/Client_claim/client_claim_edit/');
            $data['api_list']            = base_url('back/Client_claim/client_claim_list');
            $data['api_delete']          = base_url('back/Client_claim/client_claim_delete');
            $data['state']               = base_url('back/Client_claim/client_claim_state');
            $this->load->view("back/Client_claim/client_claim_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function client_claim_edit($id = "")
    {
        if (IS_GET) {
            $data['open_client_claim']   = "open";
            $data['active_client_claim'] = "active";
            $data['list']                = base_url('back/Client_claim/client_claim_list');
            $data['edit']                = base_url('back/Client_claim/client_claim_edit/');
            $data['list_title']          = "客戶索取列表";
            if (!empty($id)) {
                $id            = (int) $id;
                $data['title'] = "客戶索取編輯";
                $model         = $this->Data_helper_model->get_model_in_id("client_claim", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id"         => $model->id,
                        "name"       => $model->name,
                        "phone"      => $model->phone,
                        "email"      => $model->email,
                        "line_id"    => $model->line_id,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Client_claim/client_claim_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Client_claim/client_claim_list'));
                }
            } else {
                $data['title'] = "新增客戶索取";
                $this->load->view("back/Client_claim/client_claim_edit", $data);
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

            $id      = mb_strlen(trim(isset($api_obj['id']) ?: "")) == 0 ? "" : trim($api_obj['id']);
            $name    = mb_strlen(trim(isset($api_obj['name']) ?: "")) == 0 ? "" : trim($api_obj['name']);
            $phone   = mb_strlen(trim(isset($api_obj['phone']) ?: "")) == 0 ? "" : trim($api_obj['phone']);
            $email   = mb_strlen(trim(isset($api_obj['email']) ?: "")) == 0 ? "" : trim($api_obj['email']);
            $line_id = mb_strlen(trim(isset($api_obj['line_id']) ?: "")) == 0 ? "" : trim($api_obj['line_id']);

            if ($name == "") {
                $errors[] = "姓名不可為空";
            }
            if ($phone == "") {
                $errors[] = "手機不可為空";
            }
            if ($email == "") {
                $errors[] = "郵箱不可為空";
            }
            if ($line_id == "") {
                $errors[] = "Line-ID不可為空";
            }

            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "name"       => $name,
                    "phone"      => $phone,
                    "email"      => $email,
                    "line_id"    => $line_id,
                    "updated_at" => date("Y-m-d H:i:s", time()),
                ];

                if ($this->Data_helper_model->update_table_in_fileds(
                    "client_claim",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Client_claim/client_claim_list'), null);
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
                    "name"       => $name,
                    "phone"      => $phone,
                    "email"      => $email,
                    "line_id"    => $line_id,
                    "created_at" => date("Y-m-d H:i:s", time()),
                ];
                if ($this->db->insert("client_claim", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Client_claim/client_claim_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function client_claim_state()
    {
        $id    = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "client_claim", $field, $value)) {
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
    public function client_claim_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok   = 0;
            $is_err  = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('client_claim', $val)) {
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
            'client_claim.id',
            'client_claim.phone',
            'client_claim.name',
            'client_claim.email',
            'client_claim.line_id',
            'client_claim.created_at',
            'client_claim.updated_at',
        );

        $this->db->select($field);
        if ($name != "") {
            $this->db->group_start();
            $this->db->like('client_claim.name', $name);
            $this->db->group_end();

        }
        // if ($state != "") {
        //     $this->db->where('state', $state);
        // }

        if ($c_time != "") {
            $c_time = explode("~", $c_time);
            $this->db->where('client_claim.created_at >=', $c_time[0]);
            //日期必須小於加一天的。 有時間<=就好，不需要加一天。
            $this->db->where('client_claim.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
        }
        $this->db->order_by('created_at','desc');
        $this->load->library("Excel_generator");

        $query = $this->db->get('client_claim');
//        var_dump($this->db->last_query());exit();
        $this->excel_generator->set_query($query);
        $this->excel_generator->set_header(array(
            'ID',
            '姓名',
            '手機',
            'E-MAIL',
            'Line ID',
            '創建時間',
        ));
        $this->excel_generator->set_column(array(
            'id',
            'name',
            'phone',
            'email',
            'line_id',
            'created_at',
        ));
        $this->excel_generator->set_width(array(25, 30, 30, 30, 30, 30));
        $this->excel_generator->exportTo2007($excel_name . date("YmdHis"));
        return;
    }

}
