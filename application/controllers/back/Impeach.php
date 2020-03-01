<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Impeach extends Admin_Controller
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
    public function impeach_list()
    {
        if (IS_POST) {
//            return;
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $field = array(
                'impeach.id',
                'impeach.type',
                'impeach.content',
                'impeach.imgs',
                'impeach.reply',
                'impeach.status',
                'impeach.created_at',
                'impeach.updated_at',
                'orders.order_no',
                'orders.member_account',
                'orders.goods_name',
            );

            $this->db->select($field);
            if ($name != "") {
                $this->db->group_start();
                $this->db->like('orders.order_no', $name);
                $this->db->or_like('orders.member_account', $name);
                $this->db->or_like('orders.goods_name', $name);
                $this->db->group_end();
            }
            if ($state != "") {
                if($state==1){
                    $this->db->where('reply !=', '');
                }else{
                    $this->db->where('reply', '');
                }

            }

            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('impeach.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('impeach.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            $this->db->join("orders", 'orders.id = impeach.order_id', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "impeach");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "檢舉回報列表";
            $data['open_impeach'] = "open";
            $data['active_impeach'] = "active";
            $data['h_title'] = "檢舉回報管理";
            $data['edit'] = base_url('back/Impeach/impeach_edit/');
            $data['api_list'] = base_url('back/Impeach/impeach_list');
            $data['api_delete'] = base_url('back/Impeach/impeach_delete');
            $data['state'] = base_url('back/Impeach/impeach_state');
            $this->load->view("back/Impeach/impeach_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function impeach_edit($id = "")
    {
        if (IS_GET) {
            $data['open_impeach'] = "open";
            $data['active_impeach'] = "active";
            $data['list'] = base_url('back/Impeach/impeach_list');
            $data['edit'] = base_url('back/Impeach/impeach_edit/');
            $data['list_title'] = "檢舉回報列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "檢舉回報編輯";
                $model = $this->Data_helper_model->get_model_in_id("impeach", $id);
                $orders = $this->Data_helper_model->get_model_in_id("orders", $model->order_id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "order_id" => $model->order_id,
                        "type" => $model->type,
                        "content" => $model->content,
                        "reply" => $model->reply,
                        "imgs" => explode(',',$model->imgs),
                        "status" => $model->status,
                        'order_no'=>$orders->order_no,
                        'member_account'=>$orders->member_account,
                        'goods_name'=>$orders->goods_name,
                        'donor_account'=>$orders->donor_account,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Impeach/impeach_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Impeach/impeach_list'));
                }
            } else {
                $data['title'] = "新增檢舉回報";
                $this->load->view("back/Impeach/impeach_edit", $data);
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
            $reply = mb_strlen(trim(isset($api_obj['reply']) ?: "")) == 0 ? "" : trim($api_obj['reply']);


            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "reply" => $reply,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($this->Data_helper_model->update_table_in_fileds(
                    "impeach",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Impeach/impeach_list'), null);
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
                    "content" => $content,
                    "integral" => $integral,
                    "impeach_time_start" => $impeach_time[0],
                    "impeach_time_end" => $impeach_time[1],
                    "title" => $title,
                    "imgs" => $up_img_src,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("impeach", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Impeach/impeach_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function impeach_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "impeach", $field, $value)) {
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
    public function impeach_delete()
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