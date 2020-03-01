<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Evaluate extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 評價管理
     */
    public function evaluate_list()
    {
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $field = array(
                'evaluate.id',
                'evaluate.order_id',
                'evaluate.matter',
                'evaluate.created_at',
                'evaluate.updated_at',
                'orders.order_no',
                'orders.member_account',
                'orders.goods_name',
                'orders.donor_account',
            );

            $this->db->select($field);
            if ($name != "") {
                $this->db->group_start();
                $this->db->like('orders.order_no', $name);
                $this->db->or_like('orders.member_account', $name);
                $this->db->or_like('orders.goods_name', $name);
                $this->db->group_end();
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('evaluate.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('evaluate.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            $this->db->join("orders", 'orders.id = evaluate.order_id', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "evaluate");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "評價列表";
            $data['open_evaluate'] = "open";
            $data['active_evaluate'] = "active";
            $data['h_title'] = "評價管理";
            $data['edit'] = base_url('back/Evaluate/evaluate_edit/');
            $data['api_list'] = base_url('back/Evaluate/evaluate_list');
            $data['api_delete'] = base_url('back/Evaluate/evaluate_delete');
            $data['state'] = base_url('back/Evaluate/evaluate_state');
            $this->load->view("back/Evaluate/evaluate_list", $data);
        }
    }

    /**
     * 評價編輯
     */
    public function evaluate_edit($id = "")
    {
        if (IS_GET) {
            $data['open_evaluate'] = "open";
            $data['active_evaluate'] = "active";
            $data['list'] = base_url('back/Evaluate/evaluate_list');
            $data['edit'] = base_url('back/Evaluate/evaluate_edit/');
            $data['list_title'] = "評價列表";
            $goods_data = $this->Data_helper_model->get_model_list_in_fileds("goods", [], []);
            $goods_list=[];
            foreach ($goods_data  as $key => $value){
                $goods_list[$value->name]=$value->up_user;
            }

            $data["goods_list"] = $goods_list;
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "評價編輯";
                $model = $this->Data_helper_model->get_model_in_id("evaluate", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "order_no" => $model->order_no,
                        "member_account" => $model->member_account,
                        "goods_type" => $model->goods_type,
                        "goods_name" => $model->goods_name,
                        "donor_account" => $model->donor_account,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Evaluate/evaluate_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Evaluate/evaluate_list'));
                }
            } else {
                $data['title'] = "新增評價";
                $this->load->view("back/Evaluate/evaluate_edit", $data);
            }
        }
        if (IS_POST) {
//            return;
            $errors = [];
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $member_account = mb_strlen(trim(isset($_POST['member_account']) ?: "")) == 0 ? "" : trim($_POST['member_account']);
            $goods_name = mb_strlen(trim(isset($_POST['goods_name']) ?: "")) == 0 ? "" : trim($_POST['goods_name']);
            $goods_type = mb_strlen(trim(isset($_POST['goods_type']) ?: "")) == 0 ? "" : trim($_POST['goods_type']);
            $donor_account = mb_strlen(trim(isset($_POST['donor_account']) ?: "")) == 0 ? "" : trim($_POST['donor_account']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);

//            if ($name == "") {
//                $errors[] = "狀態標籤名稱不可為空";
//            }

            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "state" => $state,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($this->Data_helper_model->update_table_in_fileds(
                    "evaluate",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Evaluate/evaluate_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                //
//                if ($name == "") {
//                    $errors[] = "狀態標籤名稱不可為空";
//                }
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }

                $orderby_noid=$this->Data_helper_model->get_model_in_fileds_orderby('evaluate',[],[],'id','desc');
//                var_dump($orderby_noid);exit();
                $sql_data = [
                    "order_no" => $orderby_noid->order_no+1,
                    "member_account" => $member_account,
                    "goods_type" => $goods_type,
                    "goods_name" => $goods_name,
                    "donor_account" => $donor_account,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("evaluate", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Evaluate/evaluate_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function evaluate_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "evaluate", $field, $value)) {
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
     * 刪除評價
     */
    public function evaluate_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('evaluate', $val)) {
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