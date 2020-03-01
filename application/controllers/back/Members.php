<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Members
 */
class Members extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 會員管理
     */
    public function member_list()
    {
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $third_login = mb_strlen(trim(isset($_POST['third_login']) ?: "")) == 0 ? "" : trim($_POST['third_login']);
            $lev = mb_strlen(trim(isset($_POST['lev']) ?: "")) == 0 ? "" : trim($_POST['lev']);
            $field = array(
                'members.id',
                'members.third_login',
                'members.nick_name',
                'members.phone',
                'members.email',
                'members.integral',
                'members.created_at',
                'members.updated_at'
            );

            $this->db->select($field);

            if ($name != "") {
                $this->db->group_start();
                $this->db->like('email', $name);
                $this->db->or_like('nick_name', $name);
                $this->db->or_like('phone', $name);
                $this->db->group_end();


            }
            if ($third_login != "") {
                $this->db->where('third_login', $third_login);
            }
            if ($lev != "") {
                $this->db->where('lev', $lev);
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('members.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('members.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "members");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "會員列表";
            $data['open_member'] = "open";
            $data['active_member'] = "active";
            $this->load->view("back/Members/member_list", $data);
        }
    }

    /**
     * 會員編輯
     */
    public function member_edit($id = "")
    {
        if (IS_GET) {
            $data['open_member'] = "open";
            $data['active_member'] = "active";
            $user_ratings = $this->Data_helper_model->get_model_list_in_fileds("user_ratings", ["state"], [1]);
            $data["user_ratings"] = $user_ratings;
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "會員編輯";
                $model = $this->Data_helper_model->get_model_in_id("members", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "email" => $model->email,
                        "nick_name" => $model->nick_name,
                        "phone" => $model->phone,
                        "address" => $model->address,
                        "integral" => $model->integral,
                        "lev" => $model->lev,
                        "hobby" => $model->hobby,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Members/member_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Members/member_list'));
                }
            } else {
                $data['title'] = "會員新增";
                $this->load->view("back/Members/member_edit", $data);
            }
        }
        if (IS_POST) {

            $errors = [];
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $points = mb_strlen(trim(isset($_POST['points']) ?: "")) == 0 ? "" : trim($_POST['points']);
            $nick_name = mb_strlen(trim(isset($_POST['nick_name']) ?: "")) == 0 ? "" : trim($_POST['nick_name']);
            $email = mb_strlen(trim(isset($_POST['email']) ?: "")) == 0 ? "" : trim($_POST['email']);
            $phone = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
            $address = mb_strlen(trim(isset($_POST['address']) ?: "")) == 0 ? "" : trim($_POST['address']);
            $userpassword = mb_strlen(trim(isset($_POST['userpassword']) ?: "")) == 0 ? "" : trim($_POST['userpassword']);
            $integral = mb_strlen(trim(isset($_POST['integral']) ?: "")) == 0 ? "" : trim($_POST['integral']);
            $lev = mb_strlen(trim(isset($_POST['lev']) ?: "")) == 0 ? "" : trim($_POST['lev']);
            $xq = mb_strlen(trim(isset($_POST['xq']) ?: "")) == 0 ? "" : trim($_POST['xq']);

            if ($email == "") {
                $errors[] = "電子信箱不可為空";
            }
            $this->load->library("Password");
            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "nick_name" => $nick_name,
                    "phone" => $phone,
                    "address" => $address,
                    "integral" => $integral,
                    "lev" => $lev,
                    "hobby" => $xq,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                if ($userpassword == "") {
                } else {
                    $sql_data["userpassword"] = md5($userpassword);
                }

                if ($this->Data_helper_model->update_table_in_fileds(
                    "members",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Members/member_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                //
                if ($userpassword == "") {
                    $errors[] = "密碼不可為空";
                }
                if ($email == "") {
                    $errors[] = "電子信箱不可為空";
                }
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                if ($this->Data_helper_model->get_model_in_fileds("members", ["email"], [$email])) {
                    return_post_json("err", "帳號重複", "", null);
                }
                $sql_data = [
                    "nick_name" => $nick_name,
                    "email" => $email,
                    "phone" => $phone,
                    "address" => $address,
                    "integral" => $integral,
                    "lev" => $lev,
                    "hobby" => $xq,
                    "userpassword" => $this->password->hash($userpassword),
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("members", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Members/member_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 刪除會員
     */
    public function member_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('members', $val)) {
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