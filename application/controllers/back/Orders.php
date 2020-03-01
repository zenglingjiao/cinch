<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Orders extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 訂單管理
     */
    public function orders_list()
    {
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $field = array(
                'orders.id',
                'orders.order_no',
                'orders.member_account',
                'orders.goods_type',
                'orders.goods_name',
                'orders.donor_account',
                'orders.created_at',
                'orders.state',
                'orders.updated_at'
            );

            $this->db->select($field);
            if ($name != "") {
                $this->db->group_start();
                $this->db->like('order_no', $name);
                $this->db->or_like('goods_name', $name);
                $this->db->or_like('member_account', $name);
                $this->db->group_end();
            }
            if ($state != "") {
                $this->db->where('state', $state);
            }

            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('orders.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('orders.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "orders");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "訂單列表";
            $data['open_orders'] = "open";
            $data['active_orders'] = "active";
            $data['h_title'] = "訂單管理";
            $data['edit'] = base_url('back/Orders/orders_edit/');
            $data['api_list'] = base_url('back/Orders/orders_list');
            $data['api_delete'] = base_url('back/Orders/orders_delete');
            $data['state'] = base_url('back/Orders/orders_state');
            $this->load->view("back/Orders/orders_list", $data);
        }
    }

    /**
     * 訂單編輯
     */
    public function orders_edit($id = "")
    {
        if (IS_GET) {
            $data['open_orders'] = "open";
            $data['active_orders'] = "active";
            $data['list'] = base_url('back/Orders/orders_list');
            $data['edit'] = base_url('back/Orders/orders_edit/');
            $data['list_title'] = "訂單列表";
            $goods_data = $this->Data_helper_model->get_model_list_in_fileds("goods", ['status'], [1]);
            $sc_list = $this->Data_helper_model->get_model_list_in_fileds("goods_class", ["class_type"], [2]);
            $goods_list=[];
            foreach ($goods_data  as $key => $value){
                $goods_list[$value->name]=$value->up_user;
            }
            $data["goods_data"] = $goods_data;
            $data["goods_list"] = $goods_list;
            $data["small_class_list"] = $sc_list;
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "訂單編輯";
                $model = $this->Data_helper_model->get_model_in_id("orders", $id);
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
                    $this->load->view("back/Orders/orders_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Orders/orders_list'));
                }
            } else {
                $data['title'] = "新增訂單";
                $this->load->view("back/Orders/orders_edit", $data);
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
                    "orders",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Orders/orders_list'), null);
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

                $orderby_noid=$this->Data_helper_model->get_model_in_fileds_orderby('orders',[],[],'id','desc');
//                var_dump($orderby_noid);exit();
                $sql_data = [
                    "order_no" => $orderby_noid->order_no+1,
                    "member_account" => $member_account,
                    "goods_type" => $goods_type,
                    "goods_name" => $goods_name,
                    "donor_account" => $donor_account,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("orders", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Orders/orders_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function orders_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "orders", $field, $value)) {
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
     * 刪除訂單
     */
    public function orders_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('orders', $val)) {
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