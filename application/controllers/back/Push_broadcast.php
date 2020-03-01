<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Members
 */
class Push_broadcast extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
        $this->load->library("Jpush");

    }


    /**
     * 推播管理
     */
    public function broadcast_list()
    {
        if (IS_POST) {
            $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field = array(
                'push_broadcast.id',
                'push_broadcast.title',
                'push_broadcast.schedule_time',
                'push_broadcast.created_at',
                'push_broadcast.updated_at'
            );

            $this->db->select($field);
            if ($title != "") {
                $this->db->group_start();
                $this->db->like('title', $title);
                $this->db->group_end();
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('push_broadcast.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('push_broadcast.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "push_broadcast");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "推播列表";
            $data['open_broadcast'] = "open";
            $data['active_broadcast'] = "active";
            $data['h_title'] = "推播管理";
            $data['edit'] = base_url('back/Push_broadcast/broadcast_edit/');
            $data['api_list'] = base_url('back/Push_broadcast/broadcast_list');
            $data['api_delete'] = base_url('back/Push_broadcast/broadcast_delete');
            $data['state'] = base_url('back/Push_broadcast/broadcast_state');
            $this->load->view("back/Push_broadcast/broadcast_list", $data);
        }
    }

    public function push1()
    {
        $this->load->library("Jpush");
        $res=$this->jpush->push('2020-01-13 16:00:00','hello',array(
            "registration_id" => array("140fe1da9ec4089ab92")//指定registration_id用户
        ));
        var_dump($res);exit();
        $res=json_decode($res);
        if(isset($res->name)){
            echo '成功';
            return;
        }else{
            echo '失敗';
            return;
        }


    }
    /**
     * 推播編輯
     */
    public function broadcast_edit($id = "")
    {
        if (IS_GET) {
            $data['open_broadcast'] = "open";
            $data['active_broadcast'] = "active";
            $data['list'] = base_url('back/Push_broadcast/broadcast_list');
            $data['edit'] = base_url('back/Push_broadcast/broadcast_edit/');
            $data['list_title'] = "推播列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "推播編輯";
                $model = $this->Data_helper_model->get_model_in_id("push_broadcast", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "title" => $model->title,
                        "schedule_time" => $model->schedule_time,
                        "schedule_id" => $model->schedule_id,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Push_broadcast/broadcast_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Push_broadcast/broadcast_list'));
                }
            } else {
                $data['title'] = "新增推播";
                $this->load->view("back/Push_broadcast/broadcast_edit", $data);
            }
        }
        if (IS_POST) {
//            return;
            $errors = [];
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $schedule_time = mb_strlen(trim(isset($_POST['schedule_time']) ?: "")) == 0 ? "" : trim($_POST['schedule_time']);
            $schedule_id = mb_strlen(trim(isset($_POST['schedule_id']) ?: "")) == 0 ? "" : trim($_POST['schedule_id']);
            if ($title == "") {
                $errors[] = "標題不可為空";
            }
            //當前時間+5分鐘
            $now_time=strtotime("+5 minutes");
            if($now_time > strtotime($schedule_time)){
                $errors[] = "上架時間必須大於當前5分鐘";
            }
            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "title" => $title,
                    "schedule_time" => $schedule_time,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($this->Data_helper_model->update_table_in_fileds(
                    "push_broadcast",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    //修改定時推送
                    $res=$this->jpush->update_schedule_push($schedule_time,$title,$schedule_id);
//                    var_dump($res);exit();
                    return_post_json("ok", "修改成功", base_url('back/Push_broadcast/broadcast_list'), null);
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
                //新增定時推送
                $res=$this->jpush->schedule_push($schedule_time,$title,$schedule_id);
                $res=json_decode($res);
                $sql_data = [
                    "title" => $title,
                    "schedule_id" => $res->schedule_id,
                    "schedule_time" => $schedule_time,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("push_broadcast", $sql_data)) {

                    return_post_json("ok", "新增成功", base_url('back/Push_broadcast/broadcast_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }
    /**
     * 標籤管理狀態
     */
    public function broadcast_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "push_broadcast", $field, $value)) {
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
    public function broadcast_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('push_broadcast', $val)) {
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