<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Admin
 */
class Admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 首頁
     */
    public function index()
    {
        $data['title'] = "cinch後台 - 首頁";
        $data['active_index'] = "active";
       	$data['state'] = base_url('back/Admin/index_state');
        $model = $this->Data_helper_model->get_model_in_id("version", 1);
        $data['model']=$model;
        $this->load->view("back/Admin/index", $data);
        //redirect(base_url('back/Admin/login'), 'refresh');
    }
    /**
     * 標籤管理狀態
     */
    public function index_state()
    {
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($this->Data_helper_model->tabel_status(1, "version", 'version_number', $value)) {
            echo 1;
            return;
        } else {
            echo 0;
            return;
        }
       
    }
    /**
     * 登入
     */
    public function login()
    {
        if (IS_POST) {
            $errors = [];
            if (valid_csrf_nonce() === FALSE) {
                return_post_json("err", "Csrf", "", null);
            }
            if (!isset($_POST['email']) || empty($_POST['email'])) {
                $errors[] = "帳號";
            }
            if (!isset($_POST['password']) || empty($_POST['password'])) {
                $errors[] = "密碼";
            }
            if (!empty($errors)) {
                $error = implode(", ", $errors);
                return_post_json("err", $error . ' 不可為空', "", null);
            }
            $remember = isset($_POST['isAlways']) && $_POST['isAlways'] = 1 ? true : false;
            if ($this->aauth->login($_POST['email'], $_POST['password'], $remember)) {
                $this->session->set_userdata('upload_image_file_manager', true);
                return_post_json("ok", "登入成功", base_url('back/Admin/index'), null);
            } else {
                $errors = $this->aauth->get_errors_array();
                return_post_json("err", $errors, "", null);
            }
        } else {
            $data['csrf'] = get_csrf_nonce();//防csrf攻擊
            $data['title'] = "cinch後台 - 登入";
            $this->load->view("back/Admin/login", $data);
        }
    }

    /**
     * 退出
     */
    public function logout()
    {
        $this->aauth->logout();
        redirect(base_url('back/Admin/login'), 'refresh');
    }

    /**
     * 修改密碼
     */
    public function password_change()
    {
        if (IS_POST) {
            $errors = [];
            if (!isset($_POST['password']) || empty($_POST['password'])) {
                $errors[] = '原密碼不可為空';
            }
            if (!isset($_POST['password_new']) || empty($_POST['password_new'])) {
                $errors[] = '新密碼不可為空';
            }
            if (!isset($_POST['password_new_again']) || empty($_POST['password_new_again'])) {
                $errors[] = '請再次輸入新密碼';
            }
            if (!$this->aauth->check_logged_user_password($_POST['password'])) {
                $errors[] = '原密碼有誤';
            }
            if (!empty($errors)) {
                get_csrf_nonce_keep();
                $error = implode(", ", $errors);
                return_post_json("err", $error, "", null);
            }
            if ($this->aauth->change_password($_POST['password_new_again'])) {
                return_post_json("ok", "修改成功", base_url('back/Admin/login'), null);
            } else {
                return_post_json("err", "修改失敗！", "", null);
            }
        } else {
            return_post_json("err", "請輸入相關數據！", "", null);
        }
    }

    /**
     * 修改密碼
     */
    public function password_change_eidt()
    {
        if (IS_POST) {
            $errors = [];
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                $errors[] = '管理員ID有誤';
            }
            if (!isset($_POST['password_new']) || empty($_POST['password_new'])) {
                $errors[] = '新密碼不可為空';
            }
            if (!isset($_POST['password_new_again']) || empty($_POST['password_new_again'])) {
                $errors[] = '請再次輸入新密碼';
            }
            if (!empty($errors)) {
                get_csrf_nonce_keep();
                $error = implode(", ", $errors);
                return_post_json("err", $error, "", null);
            }
            if ($this->aauth->change_password_eidt($_POST['id'], $_POST['password_new_again'])) {
                return_post_json("ok", "修改成功", "", null);
            } else {
                return_post_json("err", "修改失敗！", "", null);
            }
        } else {
            return_post_json("err", "請輸入相關數據！", "", null);
        }
    }


    /**
     * 管理員列表視圖
     */
    public function admin_list()
    {
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $field = array(
                'aauth_users.id',
                'aauth_users.email',
                'aauth_users.username',
                'aauth_users.is_ok',
                'aauth_users.last_login',
                'aauth_users.date_created',
                'aauth_users.remember_time',
                'aauth_users.ip_address'
            );

            $this->db->select($field);
            $this->db->group_start();
            $this->db->where('username !=', 'admin');
            $this->db->or_where('username is NULL');
            $this->db->group_end();

            if ($name != "") {
                $this->db->group_start();
                $this->db->like('email', $name);
                $this->db->or_like('username', $name);
                $this->db->group_end();
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('aauth_users.date_created >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('aauth_users.date_created <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "aauth_users");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "管理員列表";
            $data['open_admin'] = "open";
            $data['active_admin'] = "active";
            $this->load->view("back/Admin/admin_list", $data);
        }
    }

    /**
     * 改變管理員狀態
     */
    public function table_status()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $tabel = mb_strlen(trim(isset($_POST['tb']) ?: "")) == 0 ? "" : trim($_POST['tb']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $tabel != "" && $field != "" && $id != "" && $id != "") {
            if ($this->Data_helper_model->tabel_status($id, $tabel, $field, $value)) {
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
     * 刪除管理員
     */
    public function admin_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->aauth->delete_user($val)) {
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

    /**
     * 管理員編輯
     */
    public function admin_edit($id = 0)
    {
        if (IS_GET) {
            $data['open_admin'] = "open";
            $data['active_admin'] = "active";
            if (isset($id) && $id > 0) {
                $id = (int)$id;
                $data['title'] = "管理員編輯";
                $admin = $this->Data_helper_model->get_admin($id);
                if (isset($admin)) {
                    $data['admin'] = $admin;
                    $data['csrf'] = get_csrf_nonce();//防csrf攻擊
                    $this->load->view("back/Admin/admin_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Admin/admin_list'));
                }
            } else {
                $data['title'] = "管理員新增";
                $data['csrf'] = get_csrf_nonce();//防csrf攻擊
                $this->load->view("back/Admin/admin_edit", $data);
            }
        }
        if (IS_POST) {
            if (valid_csrf_nonce() === FALSE) {
                return_post_json("err", "Csrf", "", null);
            }
            $errors = [];
            $id = $_POST['id'];
            if (isset($id) && $id > 0) {
                if (!isset($_POST['username']) || empty($_POST['username'])) {
                    $errors[] = '帳號不可為空';
                }
                if (!isset($_POST['email']) || empty($_POST['email'])) {
                    $errors[] = 'email不可為空';
                }
                if (!empty($errors)) {
                    get_csrf_nonce_keep();
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                if ($this->aauth->update_user_rolename($id, $_POST['full_name'], $_POST['email'], false, $_POST['username'])) {
                    return_post_json("ok", "修改成功", base_url('back/Admin/admin_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", $this->aauth->get_errors_array(), "", null);
                }
            } else {
                if (!isset($_POST['username']) || empty($_POST['username'])) {
                    $errors[] = '帳號不可為空';
                }
                if (!isset($_POST['email']) || empty($_POST['email'])) {
                    $errors[] = 'email不可為空';
                }
                if (!isset($_POST['pass']) || empty($_POST['pass'])) {
                    $errors[] = '密碼不可為空';
                }

                if (!empty($errors)) {
                    get_csrf_nonce_keep();
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                if ($this->aauth->create_user_role($_POST, $_POST['email'], $_POST['pass'], $_POST['username']) > 0) {
                    return_post_json("ok", "新增成功", base_url('back/Admin/admin_list'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", $this->aauth->get_errors_array(), "", null);
                }
            }
        }
    }

    public function simditor_upload()
    {
        $this->load->library("Custom_upload");
        $path = "updata/simditor/image/" . date("Y-m", time());
        $img_list_num = 1;
        $file_up_src = "";
        foreach ($_FILES as $k => $file) {
            if (isset($file['name'])) {
                $up_img_file_name = $this->custom_upload->single_upload($k, date("YmdHis", time()) . $img_list_num, ["upload_path" => $path, "allowed_types" => "jpeg|jpg|png|bmp"]);
                if ($up_img_file_name) {
                    $file_up_src = $path . "/" . $up_img_file_name;
                }
            }
        }
        if (empty($file_up_src)) {
            $result = array(
                'success' => false,
                'msg' => '上傳失敗',
                'file_path' => "",
            );
        } else {
            $result = array(
                'success' => true,
                'msg' => '上傳成功',
                'file_path' => $file_up_src,
            );
        }
        ob_end_clean();
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result, JSON_UNESCAPED_UNICODE))
            ->_display();
        exit;
    }

    public function terms_edit()
    {
        if (IS_GET) {
            $data['active_terms'] = "active";
            $model = $this->Data_helper_model->get_model_in_id("terms", 1);
            if (isset($model)) {
                $data['model'] = $model;
                $this->load->view("back/Admin/terms_edit", $data);
            } else {
                $this->load->view("back/Admin/terms_edit");
            }
        }
        if (IS_POST) {
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $content = mb_strlen(trim(isset($_POST['content']) ?: "")) == 0 ? "" : trim($_POST['content']);

            if (!empty($id) && $id > 0) {
                $sql_data = [
                    "content" => $content,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->Data_helper_model->update_table_in_fileds(
                    "terms",
                    ["id"],
                    [1],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Admin/terms_edit'), null);
                } else {
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                $sql_data = [
                    "content" => $content,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("terms", $sql_data)) {
                    return_post_json("ok", "修改成功", base_url('back/Admin/terms_edit'), null);
                } else {
                    return_post_json("err", "修改成功", "", null);
                }
            }
        }
    }

    /**
     * 財務管理
     */
    public function transamounts_list()
    {
        $user_id = $this->session->userdata('id');
        if (IS_POST) {
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $amount_min = mb_strlen(trim(isset($_POST['amount_min']) ?: "")) == 0 ? "" : trim($_POST['amount_min']);
            $amount_max = mb_strlen(trim(isset($_POST['amount_max']) ?: "")) == 0 ? "" : trim($_POST['amount_max']);
            $status = mb_strlen(trim(isset($_POST['status']) ?: "")) == 0 ? "" : trim($_POST['status']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);

            $field = array(
                'transamounts.id',
                'transamounts.member_id',
                'transamounts.store_id',
                'transamounts.amount',
                'transamounts.points',
                'transamounts.created_at',
                'transamounts.status',
                'transamounts.audit_record_json',
                'members.nick_name',
                'aauth_users.store_name',
                'aauth_users.store_phone',
            );

            $this->db->select($field);
            if ($name != "") {
                $this->db->like('members.nick_name', $name);
            }
            if ($status != "") {
                $this->db->where('transamounts.status', $status);
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('transamounts.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('transamounts.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            $this->db->join("members", 'members.id = transamounts.member_id', 'left');
            $this->db->join("aauth_users", 'aauth_users.id = transamounts.store_id', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "transamounts");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "活動管理";
            $data['active_transamounts'] = "active";
            $this->load->view("back/Admin/transamounts_list", $data);
        }
    }

    public function tran_back()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $close_record = mb_strlen(trim(isset($_POST['close_record']) ?: "")) == 0 ? "" : trim($_POST['close_record']);
        $errors = [];
        if ($id == "") {
            $errors[] = 'id未獲取';
        }
        if ($close_record == "") {
            $errors[] = '取消原因不可為空';
        }
        if ($errors && count($errors) > 0) {
            $error = implode(", ", $errors);
            return_post_json("err", $error, "", null);
        }

        $tran_model = $this->Data_helper_model->get_model_in_id("transamounts", $id);
        if ($tran_model) {
            $audit_record_obj = [];
            if (!empty($tran_model->audit_record_json)) {
                $audit_record_obj = json_decode($tran_model->audit_record_json);
            }
            if (isset($audit_record_obj) && count($audit_record_obj) > 0) {
                $last_obj = end($audit_record_obj);
                $last_obj->responder = $close_record;
                $last_obj->response_time = date("Y-m-d H:i:s", time());
                $audit_record_obj[count($audit_record_obj) - 1] = $last_obj;
                $sql_data = [
                    "status" => 3,
                    "audit_record_json" => json_encode($audit_record_obj),
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->Data_helper_model->update_table_in_fileds(
                    "transamounts",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "送出成功", "", null);
                } else {
                    return_post_json("err", "送出失敗", "", null);
                }
            } else {
                return_post_json("err", "送出失敗,取消原因資料有誤", "", null);
            }

        } else {
            return_post_json("err", "資料不存在", "", null);
        }
    }

    public function tran_close()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $errors = [];
        if ($id == "") {
            $errors[] = 'id未獲取';
        }
        if ($errors && count($errors) > 0) {
            $error = implode(", ", $errors);
            return_post_json("err", $error, "", null);
        }

        $tran_model = $this->Data_helper_model->get_model_in_id("transamounts", $id);
        if ($tran_model) {
            if ($this->Data_helper_model->close_coupon($tran_model)) {
                return_post_json("ok", "送出成功", "", null);
            } else {
                return_post_json("err", "送出失敗", "", null);
            }
        } else {
            return_post_json("err", "資料不存在", "", null);
        }
    }

    public function test_img()
    {
        $store_list = $this->Data_helper_model->get_model_list_in_fileds("aauth_users", ["is_store"], [1]);
        if ($store_list && count($store_list) > 0) {
            $test = 1;
            foreach ($store_list as $store) {
                if (isset($store->store_logo)) {
                    $sql_data = [];
                    if (file_exists($store->store_logo)) {
                        $path_parts_logo = pathinfo($store->store_logo);
                        $new_sre_logo = $path_parts_logo['dirname'] . '/' . date("YmdHis", time()) . $test . "." . $path_parts_logo['extension'];
                        if (rename($store->store_logo, $new_sre_logo)) {
                            $sql_data["store_logo"] = $new_sre_logo;
                        }
                    }
                    if (file_exists($store->store_pic)) {
                        $path_parts = pathinfo($store->store_pic);
                        $new_sre = $path_parts['dirname'] . '/' . date("YmdHis", time()) . $test . "." . $path_parts['extension'];
                        if (rename($store->store_pic, $new_sre)) {
                            $sql_data["store_pic"] = $new_sre;
                        }
                    }
                    if (isset($sql_data) && count($sql_data) > 0) {
                        $this->db->where("id", $store->id);
                        $this->db->update("aauth_users", $sql_data);
                        $test++;
                    }
                }
            }
        }
    }


    //excel導入相關------------------------------------------------s----------------------------------------------------
    public function updata_excel()
    {
        $this->load->view("back/Admin/updata_excel");
    }

    public function updata_excel_store()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先      選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "categorys",
                    "B" => "username",
                    "C" => "password",
                    "D" => "store_type",
                    "E" => "store_name",
                    "F" => "store_introduction",
                    "G" => "store_logo",
                    "H" => "store_pic",
                    "I" => "store_address",
                    "J" => "store_postal",
                    "K" => "store_phone",
                    "L" => "store_business",
                ]);
            $is_ok = 0;
            $img_up = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    $store_model = $this->Data_helper_model->get_model_in_fileds("aauth_users", ["username"], [$value['username']]);
                    if (isset($store_model) && $store_model->id > 0) {
                        $sql_data = [
                            "store_logo" => 'updata/image/store/' . trim($value['store_logo']) . '.jpg',
                            "store_pic" => 'updata/image/store/' . trim($value['store_pic']) . '.jpg',
                        ];
                        $this->db->where("id", $store_model->id);
                        $this->db->update("aauth_users", $sql_data);
                        $img_up++;
                    } else {

                    }

                    // if (isset($value['categorys'])) {
                    //     $category_model = $this->Data_helper_model->get_model_in_filed("categorys", "name", $value['categorys']);
                    //     if ($category_model) {
                    //         $store_model = $this->Data_helper_model->get_model_in_fileds("aauth_users", ["username"], [$value['username']]);
                    //         if (isset($store_model) && $store_model->id > 0) {
                    //             $sql_data = [
                    //                 "store_logo" => 'updata/image/store/' . trim($value['store_logo']) . '.jpg',
                    //                 "store_pic" => 'updata/image/store/' . trim($value['store_pic']) . '.jpg',
                    //             ];
                    //             $this->db->where("id", $store_model->id);
                    //             $this->db->update("aauth_users", $sql_data);
                    //             $img_up++;
                    //         } else {
                    //             // $return_json = get_google_lng_lat($value['store_address']);
                    //             // if ($return_json) {
                    //             //     $json_obj = json_decode($return_json);
                    //             //     if (isset($json_obj) && isset($json_obj->status) && $json_obj->status == "OK") {
                    //             //         if (isset($json_obj->results[0]->geometry->location)) {
                    //             //             $lng_lat = $json_obj->results[0]->geometry->location;
                    //             //             $longitude = $lng_lat->lng;
                    //             //             $latitude = $lng_lat->lat;
                    //             //         }
                    //             //     }
                    //             // }
                    //             // $sql_data = [
                    //             //     "store_business" => $value['store_business'],
                    //             //     "store_phone" => $value['store_phone'],
                    //             //     "store_address" => $value['store_address'],
                    //             //     //"store_district" => $value['store_business'],
                    //             //     //"store_county" => $value['store_business'],
                    //             //     "store_postal" => $value['store_postal'],
                    //             //     "store_introduction" => $value['store_introduction'],
                    //             //     "store_name" => $value['store_name'],
                    //             //     "store_cate_id" => $category_model->id,
                    //             //     "store_type" => $value['store_type'] == '總店' ? 1 : 0,
                    //             //     "store_logo" => 'updata/image/store/' . $value['store_logo'] . '.jpg',
                    //             //     "store_pic" => 'updata/image/store/' . $value['store_pic'] . '.jpg',
                    //             //     "is_store" => 1,
                    //             //     "longitude" => $longitude,
                    //             //     "latitude" => $latitude,
                    //             // ];
                    //             // if ($this->aauth->create_user_role($_POST, $value['username'] . "@hdd.store.com", $value['password'], $value['username'], true, $sql_data)) {
                    //             //     $is_ok++;
                    //             // }
                    //         }
                    //     }
                    // }
                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條 圖片更新：" . $img_up . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_poi_google_id()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "google_id",
                    "B" => "name"
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (isset($value['name'])) {
                        $poi_model = $this->Data_helper_model->get_model_in_filed("poi", "name", $value["name"]);
                        if ($poi_model) {
                            $sql_data['google_id'] = $value['google_id'];
                            $this->db->where("id", $poi_model->id);
                            $this->db->update("poi", $sql_data);
                            if ($this->db->affected_rows() > 0) {
                                $is_ok++;
                            } else {
                            }
                        }
                    }
                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_poi_comment()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先      選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "google_id",
                    "B" => "user_name",
                    "C" => "mark",
                    "D" => "comments",
                    "E" => "create_time",
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (isset($value['google_id'])) {
                        $poi_model = $this->Data_helper_model->get_model_in_filed("poi", "google_id", $value["google_id"]);
                        if ($poi_model) {
                            if ($this->Data_helper_model->get_model_in_fileds("poi_comment", ["poi_id", "user_name", "comments"], [$poi_model->id, $value["user_name"], $value["comments"]])) {
                            } else {
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_id"] = $poi_model->id;
                                $sql_data["google_id"] = $value["google_id"];
                                $sql_data["user_name"] = $value["user_name"];
                                $sql_data["mark"] = $value["mark"];
                                $sql_data["comments"] = $value["comments"];
                                $sql_data["create_time"] = date("Y-m-d H:i:s", $value["create_time"]);
                                if ($this->db->insert("poi_comment", $sql_data)) {
                                    $is_ok++;
                                }
                            }
                        }
                    }
                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_business_google_id()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "google_id",
                    "B" => "name"
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (isset($value['name'])) {
                        $business_model = $this->Data_helper_model->get_model_in_filed("business", "name", $value["name"]);
                        if ($business_model) {
                            $sql_data['google_id'] = $value['google_id'];
                            $this->db->where("id", $business_model->id);
                            $this->db->update("business", $sql_data);
                            if ($this->db->affected_rows() > 0) {
                                $is_ok++;
                            } else {
                            }
                        }
                    }
                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_business_comment()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先      選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "google_id",
                    "B" => "user_name",
                    "C" => "mark",
                    "D" => "comments",
                    "E" => "create_time",
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (isset($value['google_id'])) {
                        $business_model = $this->Data_helper_model->get_model_in_filed("business", "google_id", $value["google_id"]);
                        if ($business_model) {
                            if ($this->Data_helper_model->get_model_in_fileds("business_comment", ["business_id", "user_name", "comments"], [$business_model->id, $value["user_name"], $value["comments"]])) {
                            } else {
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["business_id"] = $business_model->id;
                                $sql_data["google_id"] = $value["google_id"];
                                $sql_data["user_name"] = $value["user_name"];
                                $sql_data["mark"] = $value["mark"];
                                $sql_data["comments"] = $value["comments"];
                                $sql_data["create_time"] = date("Y-m-d H:i:s", $value["create_time"]);
                                if ($this->db->insert("business_comment", $sql_data)) {
                                    $is_ok++;
                                }
                            }
                        }
                    }
                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_ingredient()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "ingredient_type",
                    "B" => "ingredient_name"
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    //判斷是否存在當前食材類型
                    $ingredient_type = $this->Data_helper_model->get_model_in_filed("poi_menu_cuisine_ingredient_type", "name", $value["ingredient_type"]);
                    if ($ingredient_type) {
                        //判断当前食材 是否存在
                        if ($this->Data_helper_model->get_model_in_fileds("poi_menu_cuisine_ingredient", ['poi_ingredient_type_id', 'name'], [$ingredient_type->id, $value["ingredient_name"]])) {
                            continue;
                        }
                        $sql_data["id"] = $this->uuid->v4();
                        $sql_data["poi_ingredient_type_id"] = $ingredient_type->id;
                        $sql_data["name"] = $value["ingredient_name"];
                        $sql_data["create_time"] = date("Y-m-d H:i:s", time());
                        if ($this->db->insert("poi_menu_cuisine_ingredient", $sql_data)) {
                            $is_ok++;
                        }
                    }

                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_cuisine()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "B" => "country",
                    "C" => "category_name",
                    "D" => "cuisine_name",
                    "E" => "ingredient_type",
                    "F" => "ingredient_name",
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (isset($value) && !empty($value["country"]) && !empty($value["category_name"]) && !empty($value["cuisine_name"])) {
                    } else {
                        continue;
                    }
                    //獲取國家分類（預設存在）
                    $country_tag = $this->Data_helper_model->get_model_in_filed("poi_menu_cuisine_tag", "name", $value["country"]);

                    if ($country_tag) {
                    } else {
                        continue;
                    }
                    //獲取菜色分類（預設存在）
                    $cuisine_category = $this->Data_helper_model->get_model_in_filed("poi_menu_category", "name", $value["category_name"]);

                    //獲取食材分類（預設存在）
                    $ingredient_type = $this->Data_helper_model->get_model_in_filed("poi_menu_cuisine_ingredient_type", "name", $value["ingredient_type"]);

                    //獲取食材（預設存在）
                    $ingredient = $this->Data_helper_model->get_model_in_fileds("poi_menu_cuisine_ingredient", ['poi_ingredient_type_id', 'name'], [$ingredient_type->id, $value["ingredient_name"]]);


                    //存在菜色 處理 關聯國家分類表TAG poi_cuisine_join_tag 關聯食材表poi_menu_cuisine_join_ingredient
                    //否則創建菜色並處理 關聯國家分類表TAG  poi_cuisine_join_tag 關聯食材表poi_menu_cuisine_join_ingredient
                    //獲取菜色
                    $cuisine = $this->db->from('poi_menu_cuisine')
                        ->join('poi_cuisine_join_tag', 'poi_menu_cuisine.id=poi_cuisine_join_tag.cuisine_id and poi_cuisine_join_tag.cuisine_tag_id=' . $country_tag->id . '')
                        ->where('name', $value["cuisine_name"])
                        ->get()->row();

                    if ($cuisine) {
                    } else {
                        $sql_data = [];
                        $cuisine_id = $this->uuid->v4();
                        $sql_data["id"] = $cuisine_id;
                        $sql_data["name"] = $value["cuisine_name"];
                        $sql_data["create_time"] = date("Y-m-d H:i:s", time());
                        if ($this->db->insert("poi_menu_cuisine", $sql_data)) {
                            $cuisine->id = $cuisine_id;
                        }
                    }

                    if (isset($cuisine->id)) {
                        //是否存在菜色分類信息
                        $poi_menu_detail = $this->Data_helper_model->get_model_in_fileds("poi_menu_detail", ['poi_menu_category_id', 'poi_cuisine_id'], [$cuisine_category->id, $cuisine->id]);
                        if ($poi_menu_detail) {
                        } else {
                            if (isset($cuisine_category->id)) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_menu_category_id"] = $cuisine_category->id;
                                $sql_data["poi_cuisine_id"] = $cuisine->id;
                                if ($this->db->insert("poi_menu_detail", $sql_data)) {
                                }
                            }
                        }

                        //是否存在菜色TAG信息
                        $poi_cuisine_join_tag = $this->Data_helper_model->get_model_in_fileds("poi_cuisine_join_tag", ['cuisine_tag_id', 'cuisine_id'], [$country_tag->id, $cuisine->id]);
                        if ($poi_cuisine_join_tag) {
                        } else {
                            if (isset($country_tag->id)) {
                                $sql_data = [];
                                $sql_data["cuisine_tag_id"] = $country_tag->id;
                                $sql_data["cuisine_id"] = $cuisine->id;
                                if ($this->db->insert("poi_cuisine_join_tag", $sql_data)) {
                                }
                            }
                        }

                        //是否存在菜色關聯食材信息
                        $poi_menu_cuisine_join_ingredient = $this->Data_helper_model->get_model_in_fileds("poi_menu_cuisine_join_ingredient", ['poi_ingredient_id', 'poi_cuisine_id'], [$ingredient->id, $cuisine->id]);
                        if ($poi_menu_cuisine_join_ingredient) {
                        } else {
                            if (isset($ingredient->id)) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_ingredient_id"] = $ingredient->id;
                                $sql_data["poi_cuisine_id"] = $cuisine->id;
                                if ($this->db->insert("poi_menu_cuisine_join_ingredient", $sql_data)) {
                                }
                            }
                        }
                        $is_ok++;
                    }
                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_cuisine_lang()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "name_tw",
                    "B" => "name_us",
                    "C" => "name_ja",
                    "D" => "name_ko"
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (!isset($value["name_tw"])) {
                        continue;
                    }
                    $cuisine = $this->db->from('poi_menu_cuisine')
                        ->where('name', $value["name_tw"])
                        ->get()->row();

                    if ($cuisine) {
                        $cuisine_name_lang = $this->db->from('poi_menu_cuisine_basic_info')
                            ->where('poi_cuisine_id', $cuisine->id)
                            ->where('column_name', "name")
                            ->get()->row();
                        if ($cuisine_name_lang) {
                        } else {

                            if (isset($value["name_tw"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_cuisine_id"] = $cuisine->id;
                                $sql_data["country_id"] = "tw";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_tw"];
                                if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                                }

                            }
                            if (isset($value["name_us"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_cuisine_id"] = $cuisine->id;
                                $sql_data["country_id"] = "en";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_us"];
                                if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                                }
                            }
                            if (isset($value["name_ja"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_cuisine_id"] = $cuisine->id;
                                $sql_data["country_id"] = "ja";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_ja"];
                                if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                                }
                            }
                            if (isset($value["name_ko"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_cuisine_id"] = $cuisine->id;
                                $sql_data["country_id"] = "ko";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_ko"];
                                if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                                }
                            }
                            $is_ok++;
                            continue;

                        }
                    } else {
                        continue;
                    }


                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_cuisine_info_lang()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "cuisine_name",
                    "B" => "cuisine_media",
                    "C" => "description_tw",
                    "D" => "description_us",
                    "E" => "description_ja",
                    "F" => "description_ko",
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (!isset($value["cuisine_name"])) {
                        continue;
                    }
                    $cuisine = $this->db->from('poi_menu_cuisine')
                        ->where('name', $value["cuisine_name"])
                        ->get()->row();

                    if ($cuisine) {
                        $cuisine_img = $this->db->from('poi_menu_cuisine_media')
                            ->where('poi_cuisine_id', $cuisine->id)
                            ->where('media_type_id', "image")
                            ->get()->row();
                        if ($cuisine_img) {
                        } else {
                            $sql_data = [];
                            $sql_data["id"] = $this->uuid->v4();
                            $sql_data["poi_cuisine_id"] = $cuisine->id;
                            $sql_data["media_type_id"] = "image";
                            $sql_data["org_name"] = $value["cuisine_media"];
                            if ($this->db->insert("poi_menu_cuisine_media", $sql_data)) {
                            }
                        }

                        $cuisine_info_lang_tw = $this->db->from('poi_menu_cuisine_basic_info')
                            ->where('poi_cuisine_id', $cuisine->id)
                            ->where('column_name', "description")
                            ->where('country_id', "tw")
                            ->get()->row();
                        if ($cuisine_info_lang_tw) {
                        } else {
                            $sql_data = [];
                            $sql_data["id"] = $this->uuid->v4();
                            $sql_data["poi_cuisine_id"] = $cuisine->id;
                            $sql_data["country_id"] = "tw";
                            $sql_data["column_name"] = "description";
                            $sql_data["column_value"] = $value["description_tw"];
                            if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                            }
                        }

                        $cuisine_info_lang_us = $this->db->from('poi_menu_cuisine_basic_info')
                            ->where('poi_cuisine_id', $cuisine->id)
                            ->where('column_name', "description")
                            ->where('country_id', "en")
                            ->get()->row();
                        if ($cuisine_info_lang_us) {
                        } else {
                            $sql_data = [];
                            $sql_data["id"] = $this->uuid->v4();
                            $sql_data["poi_cuisine_id"] = $cuisine->id;
                            $sql_data["country_id"] = "en";
                            $sql_data["column_name"] = "description";
                            $sql_data["column_value"] = $value["description_us"];
                            if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                            }
                        }

                        $cuisine_info_lang_ja = $this->db->from('poi_menu_cuisine_basic_info')
                            ->where('poi_cuisine_id', $cuisine->id)
                            ->where('column_name', "description")
                            ->where('country_id', "ja")
                            ->get()->row();
                        if ($cuisine_info_lang_ja) {
                        } else {
                            $sql_data = [];
                            $sql_data["id"] = $this->uuid->v4();
                            $sql_data["poi_cuisine_id"] = $cuisine->id;
                            $sql_data["country_id"] = "ja";
                            $sql_data["column_name"] = "description";
                            $sql_data["column_value"] = $value["description_ja"];
                            if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                            }
                        }

                        $cuisine_info_lang_ko = $this->db->from('poi_menu_cuisine_basic_info')
                            ->where('poi_cuisine_id', $cuisine->id)
                            ->where('column_name', "description")
                            ->where('country_id', "ko")
                            ->get()->row();
                        if ($cuisine_info_lang_ko) {
                        } else {
                            $sql_data = [];
                            $sql_data["id"] = $this->uuid->v4();
                            $sql_data["poi_cuisine_id"] = $cuisine->id;
                            $sql_data["country_id"] = "ko";
                            $sql_data["column_name"] = "description";
                            $sql_data["column_value"] = $value["description_ko"];
                            if ($this->db->insert("poi_menu_cuisine_basic_info", $sql_data)) {
                            }
                        }

                        $is_ok++;
                        continue;

                    } else {
                        continue;
                    }


                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }

    public function updata_excel_cuisine_ingredient_lang()
    {
        // $adminID = mb_strlen(trim(isset($_POST['adminID']) ?: "")) == 0 ? "" : trim($_POST['adminID']);
        // if (empty($adminID)) {
        //     return_post_json("err", "請先選擇所屬管理員", "", null);
        // }

        $this->load->library("Custom_upload");
        $this->load->library("PHPExcel");
        $path = "updata/excel/" . date("Y-m", time());
        $filename = $this->custom_upload->single_upload("filepath", date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "xlsx|xls"]);

        if (isset($filename) && !empty($filename)) {
            //$data = $this->import_excel($path . "/" . $filename);

            $this->load->library("Excel_helper");
            $data = $this->excel_helper->import_excel($path . "/" . $filename,
                [
                    "A" => "name_class",
                    "B" => "name_tw",
                    "C" => "name_us",
                    "D" => "name_ja",
                    "E" => "name_ko"
                ]);


            $is_ok = 0;
            if (isset($data) && count($data) > 0) {
                foreach ($data as $value) {
                    if (!isset($value["name_tw"])) {
                        continue;
                    }

                    $ingredient_type = 0;
                    if ($value["name_class"] == "五穀類") {
                        $ingredient_type = 1;
                    }
                    if ($value["name_class"] == "肉類") {
                        $ingredient_type = 2;
                    }
                    if ($value["name_class"] == "豆類") {
                        $ingredient_type = 3;
                    }
                    if ($value["name_class"] == "辛香料") {
                        $ingredient_type = 4;
                    }
                    if ($value["name_class"] == "其他食品") {
                        $ingredient_type = 5;
                    }
                    if ($value["name_class"] == "海鮮類") {
                        $ingredient_type = 6;
                    }
                    if ($value["name_class"] == "蛋奶類") {
                        $ingredient_type = 7;
                    }
                    if ($value["name_class"] == "蔬果類") {
                        $ingredient_type = 8;
                    }
                    if ($value["name_class"] == "蔬菜類") {
                        $ingredient_type = 9;
                    }

                    $ingredient = $this->db->from('poi_menu_cuisine_ingredient')
                        ->where('name', $value["name_tw"])
                        ->where('poi_ingredient_type_id', $ingredient_type)
                        ->get()->row();

                    if ($ingredient) {
                        $ingredient_name_lang = $this->db->from('poi_menu_cuisine_ingredient_basic_info')
                            ->where('poi_ingredient_id', $ingredient->id)
                            ->where('column_name', "name")
                            ->get()->row();
                        if ($ingredient_name_lang) {
                        } else {

                            if (isset($value["name_tw"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_ingredient_id"] = $ingredient->id;
                                $sql_data["country_id"] = "tw";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_tw"];
                                if ($this->db->insert("poi_menu_cuisine_ingredient_basic_info", $sql_data)) {
                                }

                            }
                            if (isset($value["name_us"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_ingredient_id"] = $ingredient->id;
                                $sql_data["country_id"] = "en";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_us"];
                                if ($this->db->insert("poi_menu_cuisine_ingredient_basic_info", $sql_data)) {
                                }
                            }
                            if (isset($value["name_ja"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_ingredient_id"] = $ingredient->id;
                                $sql_data["country_id"] = "ja";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_ja"];
                                if ($this->db->insert("poi_menu_cuisine_ingredient_basic_info", $sql_data)) {
                                }
                            }
                            if (isset($value["name_ko"])) {
                                $sql_data = [];
                                $sql_data["id"] = $this->uuid->v4();
                                $sql_data["poi_ingredient_id"] = $ingredient->id;
                                $sql_data["country_id"] = "ko";
                                $sql_data["column_name"] = "name";
                                $sql_data["column_value"] = $value["name_ko"];
                                if ($this->db->insert("poi_menu_cuisine_ingredient_basic_info", $sql_data)) {
                                }
                            }
                            $is_ok++;
                            continue;

                        }
                    } else {
                        continue;
                    }


                }
            }
            return_post_json("ok", "導入完成 成功導入：" . $is_ok . "條", "", null);
        } else {
            return_post_json("err", "上傳失敗", "", null);
        }
    }
    //excel導入相關-------------------------------------------------e---------------------------------------------------


}
//end

/* End of file welcome.php */

/*
權限說明

創建權限組
$this->aauth->create_group('組名');

創建權限
$this->aauth->create_perm('權限名');

給組分配權限
$this->aauth->allow_group('組名','權限名');

刪除組權限
$this->aauth->deny_group('組名','權限名');

給用戶單獨分配權限
$this->aauth->allow_user(帳號id,'權限名');

判斷用戶組是否有權限
$this->aauth->is_group_allowed('組名','權限名')

判斷用戶是否有權限
$this->aauth->is_allowed('權限名',用戶id)

刪除權限
$this->aauth->delete_perm('權限名');

給未分配權限的用戶分配一個travel權限組
$this->aauth->allow_group('public','travel');

對於每個用户变量可以定义为单独的键/值对。
$this->aauth->set_user_var("key","value");
例如，如果要存储用户的电话号码
$this->aauth->set_user_var("phone","1-507-555-1234");
要检索值，您将使用get_user_var():
$this->aauth->get_user_var("key");

允许您定义系统变量。这些可以被系统中的所有用户访问。
$this->aauth->set_system_var("key","value");
$this->aauth->get_system_var("key");

私人消息
$this->aauth->send_pm(發送者id,接收者id,'標題','內容')

禁止用户
$this->aauth->ban_user(用戶id);


 */
