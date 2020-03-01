<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Store
 */
class Store extends Store_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 登入
     */
    public function login()
    {
        if (IS_POST) {
            $username = mb_strlen(trim(isset($_POST['username']) ?: "")) == 0 ? "" : trim($_POST['username']);
            $password = mb_strlen(trim(isset($_POST['password']) ?: "")) == 0 ? "" : trim($_POST['password']);
            if ($username != "" && $password != "") {
                $token_status = $this->Data_helper_model->store_login($username, $password);
                if ($token_status["status"]) {
                    return_app_json("200", "登入成功", $token_status["token"]);
                } else {
                    return_app_json("101", $token_status["msg"], []);
                }
            } else {
                return_app_json("101", "登入失敗，未獲取到相關憑證參數", []);
            }
        } else {
            return_get_msg("Get", "");
        }
    }

    /**
     * 獲取會員信息
     */
    public function get_store_info()
    {
        $user_id = $this->Data_helper_model->get_app_store_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("aauth_users", $user_id);
        if ($user_model) {
            // if (!empty($user_model->store_cate_id)) {
            //     $categorys = $this->Data_helper_model->get_model_in_id("categorys", $user_model->store_cate_id);
            // }
            $cate_lab = "";
            if (isset($user_model->store_cate_id)) {
                $cate = $this->Data_helper_model->get_model_in_id("categorys", $user_model->store_cate_id);
                if ($cate) {
                    $cate_lab = $cate->name;
                }
            }
            return return_app_json("200", "獲取成功", [
                'store_name' => isset($user_model->store_name) ? $user_model->store_name : "",
                'store_introduction' => isset($user_model->store_introduction) ? $user_model->store_introduction : "",
                'store_logo' => isset($user_model->store_logo) ? (!empty($user_model->store_logo) ? explode(",img,", $user_model->store_logo)[0] : "") : "",
                'store_pic' => isset($user_model->store_pic) ? (!empty($user_model->store_pic) ? explode(",img,", $user_model->store_pic) : []) : [],
                'store_phone' => isset($user_model->store_phone) ? $user_model->store_phone : "",
                'store_county' => isset($user_model->store_county) ? $user_model->store_county : "",
                'store_district' => isset($user_model->store_district) ? $user_model->store_district : "",
                'store_address' => isset($user_model->store_address) ? $user_model->store_address : "",
                'store_business' => isset($user_model->store_business) ? $user_model->store_business : "",
                'category' => isset($user_model->store_cate_id) ? $user_model->store_cate_id : "",
                'label' => [$cate_lab],
            ]);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    /**
     * 設置用戶信息
     */
    public function set_store_info()
    {
        $user_id = $this->Data_helper_model->get_app_store_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("aauth_users", $user_id);
        if (isset($_POST['store_name'])) {
            $sql_data['store_name'] = $_POST['store_name'];
        }
        if (isset($_POST['store_introduction'])) {
            $sql_data['store_introduction'] = $_POST['store_introduction'];
        }
        if (isset($_POST['store_phone'])) {
            $sql_data['store_phone'] = $_POST['store_phone'];
        }
        if (isset($_POST['store_address'])) {
            $sql_data['store_address'] = $_POST['store_address'];
        }
        if (isset($_POST['store_business'])) {
            $sql_data['store_business'] = $_POST['store_business'];
        }
        if (isset($_POST['category_id'])) {
            $sql_data['store_cate_id'] = $_POST['category_id'];
        }
        if (isset($_POST['store_county'])) {
            $sql_data['store_county'] = $_POST['store_county'];
        }
        if (isset($_POST['store_district'])) {
            $sql_data['store_district'] = $_POST['store_district'];
        }
        if (isset($_POST['store_logo'])) {
            $sql_data['store_logo'] = $_POST['store_logo'];
        }
        $store_pic = [];
        if (isset($_POST['store_pic'])) {
            $store_pic = explode(",img,", $_POST['store_pic']);
        }
        if ($user_model) {
            if (isset($sql_data['store_name']) && !empty($sql_data['store_name'])) {
                if ($this->Data_helper_model->get_model_in_fileds("aauth_users", ["store_name", "id !="], [$sql_data['store_name'], $user_id])) {
                    return return_app_json("103", "设置失敗,名字重複", []);
                }
            }
            if ($store_pic && count($store_pic) > 0) {
                $store_pic = array_filter($store_pic);
                $store_pic = implode(",img,", $store_pic);
            } else {
                $store_pic = "";
            }
            $sql_data['store_pic'] = $store_pic;
            $sql_data['updated_at'] = date("Y-m-d H:i:s", time());

            if ($this->Data_helper_model->update_table_in_fileds(
                "aauth_users",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return return_app_json("200", "设置成功", [
                    'store_name' => isset($sql_data['store_name'])?$sql_data['store_name']:$user_model->store_name,
                    'store_introduction' => isset($sql_data['store_introduction'])?$sql_data['store_introduction']:$user_model->store_introduction,
                    'store_logo' => isset($sql_data['store_logo'])?$sql_data['store_logo']:(!empty($user_model->store_logo) ? explode(",img,", $user_model->store_logo)[0] : ""),
                    'store_pic' => isset($store_pic) ? (!empty($store_pic) ? explode(",img,", $store_pic) : []) : [],
                    'store_phone' => isset($sql_data['store_phone'])?$sql_data['store_phone']:$user_model->store_phone,
                    'store_county' => isset($sql_data['store_county'])?$sql_data['store_county']:$user_model->store_county,
                    'store_district' => isset($sql_data['store_district'])?$sql_data['store_district']:$user_model->store_district,
                    'store_address' => isset($sql_data['store_address'])?$sql_data['store_address']:$user_model->store_address,
                    'store_business' => isset($sql_data['store_business'])?$sql_data['store_business']:$user_model->store_business,
                    'category' => isset($sql_data['store_cate_id'])?$sql_data['store_cate_id']:$user_model->store_cate_id,
                ]);
            } else {
                return return_app_json("103", "设置失敗", []);
            }
        } else {
            return return_app_json("103", "设置失敗", []);
        }
    }

    /**
     * 退出用戶
     */
    public function logout()
    {
        $user_id = $this->Data_helper_model->get_app_store_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("aauth_users", $user_id);
        if ($user_model) {
            $sql_data = [
                "app_token" => '',
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "aauth_users",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return return_app_json("200", "退出成功", []);
            } else {
                return return_app_json("104", "退出失敗", []);
            }
        } else {
            return return_app_json("104", "退出失敗", []);
        }
    }

    /**
     * 獲取 商家分類 二級聯動地址資料
     */
    public function get_category_address()
    {
        $categorys = $this->Data_helper_model->get_model_list_in_fileds_orderby("categorys", ["status"], [1], "sort", "ASC", ["id", "name"]);
        $address_list = $this->Data_helper_model->get_model_list_in_fileds_orderby("address", [], [], "sort", "ASC", ["id", "level", "parent", "name"]);
        $data["categorys"] = $categorys;
        $data["address_list"] = $address_list;
        return return_app_json("200", "獲取成功", $data);
    }

    public function test()
    {
        echo time();
        echo "<br/>";
        echo date("Y-m-d", strtotime("-1 day"));
        echo "<br/>";
        echo strtotime(date("Y-m-d", strtotime("-1 day")));
        exit;
        $test = isset($_POST['test']) ? "存在" : "不存在";
        echo $test;
        exit;
        $array_list = isset($_POST['test']) ? $_POST['test'] : [];
        echo json_encode($array_list);
        echo implode(",img,", $array_list);
        exit;
    }

    /**
     * 上傳圖像
     */
    public function file_upload_img()
    {
        $this->load->library("Custom_upload");
        $user_id = $this->Data_helper_model->get_app_store_user_id();
        $path = "updata/store_img/" . date("Y-m", time());
        $up_img_file_name = $this->custom_upload->single_upload("file", date("YmdHis", time()) . "_" . $user_id, ["upload_path" => $path, "allowed_types" => "jpeg|jpg|png|bmp"]);
        if ($up_img_file_name) {
            return return_app_json("200", "上傳成功", [
                'urls' => $path . "/" . $up_img_file_name,
            ]);
        }
        return return_app_json("106", "上傳失敗", []);
    }

    /**
     * 檢測掃碼 code
     */
    public function check_code()
    {
        $activites_receive_id = mb_strlen(trim(isset($_POST['activites_receive_id']) ?: "")) == 0 ? "" : trim($_POST['activites_receive_id']);
        $price = mb_strlen(trim(isset($_POST['price']) ?: "")) == 0 ? "" : trim($_POST['price']);
        //$store_id = mb_strlen(trim(isset($_POST['store_id']) ?: "")) == 0 ? "" : trim($_POST['store_id']);
        $store_id = $this->Data_helper_model->get_app_store_user_id();
        if ($activites_receive_id != "" && $price != "") {
            $activites_receive = $this->Data_helper_model->get_model_in_id("activites_receive", $activites_receive_id);
            if ($activites_receive) {
                if ($activites_receive->status == 1) {
                } else {
                    return return_app_json("107", "不可重複使用", []);
                }

                if (strtotime(date("Y-m-d H:i:s")) > strtotime($activites_receive->use_end)) {
                    return return_app_json("107", "已失效", []);
                }
                $store_ac = $this->Data_helper_model->get_model_in_fileds("activities", ["store_id", "id"], [$store_id, $activites_receive->activitie_id]);
                if ($store_ac) {
                } else {
                    $store_s = $this->Data_helper_model->get_model_in_fileds("activities_join_store", ["store_id", "activities_id"], [$store_id, $activites_receive->activitie_id]);
                    if ($store_s) {
                    } else {
                        return return_app_json("107", "當前商戶未參與當前優惠活動", []);
                    }
                }

                if ($this->Data_helper_model->exchange_coupon($activites_receive, $store_id, $price)) {
                    $member = $this->Data_helper_model->get_model_in_id("members", $activites_receive->member_id);

                    return return_app_json("200", "兌換完成", [
                        "member_name" => !empty($member->nick_name) ? $member->nick_name : "",
                        "user_head" => !empty($member->user_head) ? $member->user_head : "",
                        "price" => $price,
                    ]);
                } else {
                    return return_app_json("107", "使用失敗，請稍後重試", []);
                }
            } else {
                return return_app_json("107", "CODE有誤或優惠券信息有誤", []);
            }
        } else {
            return return_app_json("107", "未獲取相關信息", []);
        }
    }

    /**
     * 獲取被領取，被使用活動信息
     */
    public function get_activities()
    {
        $user_id = $this->Data_helper_model->get_app_store_user_id();

        $where_in_activities_id = [];

        $activities = $this->Data_helper_model->get_model_list_in_fileds("activities", ["store_id"], [$user_id]);
        if ($activities && count($activities) > 0) {
            foreach ($activities as $a_id) {
                if (empty($a_id->id)) {

                } else {
                    $where_in_activities_id[] = $a_id->id;
                }
            }
        }

        $activities_join_store = $this->Data_helper_model->get_model_list_in_fileds("activities_join_store", ["store_id"], [$user_id]);
        if ($activities_join_store && count($activities_join_store) > 0) {
            foreach ($activities_join_store as $a_id) {
                if (empty($a_id->activities_id)) {

                } else {
                    $where_in_activities_id[] = $a_id->activities_id;
                }
            }
        }

        //查詢當前商家被領取優惠卷
        $field = array(
            'activites_receive.*',
            'activities.name activitie_name',
            'activities.pic',
            'activities.use_start',
            'activities.is_forever',
            'activities.created_at',
            'members.nick_name',
            'aauth_users.store_address',
            'transamounts.store_id'
        );
        $this->db->select($field);
        $this->db->where_in('activites_receive.activitie_id', $where_in_activities_id);
        // $this->db->group_start();
        // $this->db->where('activities.is_forever', 1);
        // $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
        // $this->db->group_end();
        $this->db->join("activities", 'activities.id = activites_receive.activitie_id', 'left');
        $this->db->join("members", 'members.id = activites_receive.member_id', 'left');
        $this->db->join("transamounts", 'transamounts.activites_receive_id = activites_receive.id', 'left');
        $this->db->join("aauth_users", 'aauth_users.id = transamounts.store_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $activites_receive = $this->db->get("activites_receive")->result();
        // echo $this->db->last_query();
        // exit;
        $receive_list = [];
        $act_id = [];
        foreach ($activites_receive as $acr) {
            if (in_array($acr->activitie_id, $act_id)) {

            } else {
                $act_id[] = $acr->activitie_id;
                $member_info = [];
                $is_use = "no";
                foreach ($activites_receive as $acr2) {
                    if ($acr2->activitie_id == $acr->activitie_id) {
                        if ($acr2->status == "2") {
                            $is_use = "yes";
                        }
                        $member_info[] = [
                            "name" => $acr2->nick_name,
                            "receive_time" => $acr2->receive_datetime,
                            "status" => $acr2->status,
                            "exchange_datetime" => isset($acr2->exchange_datetime) ? $acr2->exchange_datetime : "",
                        ];
                    }
                }
                $receive_list[] = [
                    "id" => $acr->id,
                    "activitie_id" => $acr->activitie_id,
                    "name" => $acr->activitie_name,
                    "img" => !empty($acr->pic) ? explode(",img,", $acr->pic)[0] : "",
                    "activity_label" => $acr->label_name,
                    "is_forever" => $acr->is_forever,
                    "use_start" => $acr->use_start,
                    "use_end" => $acr->use_end,
                    "is_use" => $is_use,
                    "store_address" => isset($acr->store_address) ? $acr->store_address : "",
                    "member_list" => $member_info,
                ];
            }

        }
        $data["receive_list"] = $receive_list;

        return return_app_json("200", "獲取成功", $data);
        //
        // $field = array(
        //     'transamounts.*',
        //     'activities.id activitie_id',
        //     'activities.name',
        //     'activities.pic',
        //     'activities.use_start',
        //     'activities.use_end',
        //     'activities.is_forever',
        //     'aauth_users.id store_id',
        //     'aauth_users.store_name',
        //     'aauth_users.store_address',
        //     'members.nick_name',
        // );
        // $this->db->select($field);
        // $this->db->where('transamounts.store_id', $user_id);
        // // $this->db->group_start();
        // // $this->db->where('activities.is_forever', 1);
        // // $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
        // // $this->db->group_end();
        // $this->db->join("activities", 'activities.id = transamounts.activites_id', 'left');
        // $this->db->join("aauth_users", 'aauth_users.id = transamounts.store_id', 'left');
        // $this->db->join("members", 'members.id = transamounts.member_id', 'left');
        // $this->db->order_by("created_at", "DESC");
        // $transamounts = $this->db->get("transamounts")->result();
        // // echo $this->db->last_query();
        // // exit;
    }

    /**
     * 獲取消費記錄
     */
    public function get_transamounts()
    {
        $user_id = $this->Data_helper_model->get_app_store_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("aauth_users", $user_id);
        //查詢當前商家被領取優惠卷
        $field = array(
            'transamounts.*',
            'activites_receive.use_end use_end',
            'activities.name activitie_name',
            'activities.pic',
            'activities.use_start',
            'activities.is_forever',
            'members.nick_name',
        );
        $this->db->select($field);
        //$this->db->where('transamounts.store_id', $user_id);
        $this->db->group_start();
        $this->db->where('transamounts.store_id', $user_id);
        $this->db->or_where('transamounts.recommend_store_id', $user_id);
        $this->db->group_end();
        $this->db->join("activites_receive", 'activites_receive.id = transamounts.activites_receive_id', 'left');
        $this->db->join("activities", 'activities.id = transamounts.activites_id', 'left');
        $this->db->join("members", 'members.id = transamounts.member_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $transamounts = $this->db->get("transamounts")->result();
        // echo $this->db->last_query();
        // exit;
        $consume_list = [];
        $recommend_list = [];
        $amount_all = 0;
        $amount_yesterday = 0;
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        foreach ($transamounts as $ts) {
            if ($ts->recommend_store_id == $user_id) {
                $recommend_list[] = [
                    "nick_name" => isset($ts->nick_name) ? $ts->nick_name : "",
                    "amount" => $ts->amount,
                    "activitie_name" => $ts->activitie_name,
                    "use_time" => $ts->created_at,
                ];
            }
            if ($ts->store_id == $user_id) {
                $consume_list[] = [
                    "nick_name" => isset($ts->nick_name) ? $ts->nick_name : "",
                    "amount" => $ts->amount,
                    "activitie_name" => $ts->activitie_name,
                    "use_time" => $ts->created_at,
                ];
                $amount_all = $amount_all + $ts->amount;
                if (strtotime($ts->created_at) > strtotime($yesterday) && strtotime($ts->created_at) < time()) {
                    $amount_yesterday = $amount_yesterday + $ts->amount;
                }
            }
        }
        $data["consume_list"] = $consume_list;
        $data["recommend_list"] = $recommend_list;
        $data["store"] = [
            "points_all" => isset($user_model->points) ? $user_model->points : 0,
            "amount_all" => $amount_all,
            "amount_yesterday" => $amount_yesterday,
        ];
        return return_app_json("200", "獲取成功", $data);

    }

    public function get_home_total()
    {
        $user_id = $this->Data_helper_model->get_app_store_user_id();

        $where_in_activities_id = [];

        $activities = $this->Data_helper_model->get_model_list_in_fileds("activities", ["store_id"], [$user_id]);
        if ($activities && count($activities) > 0) {
            foreach ($activities as $a_id) {
                if (empty($a_id->id)) {

                } else {
                    $where_in_activities_id[] = $a_id->id;
                }
            }
        }

        $activities_join_store = $this->Data_helper_model->get_model_list_in_fileds("activities_join_store", ["store_id"], [$user_id]);
        if ($activities_join_store && count($activities_join_store) > 0) {
            foreach ($activities_join_store as $a_id) {
                if (empty($a_id->activities_id)) {

                } else {
                    $where_in_activities_id[] = $a_id->activities_id;
                }
            }
        }

        //查詢當前商家被領取優惠卷
        $field = array(
            'activities.*',
            'activites_receive.status receive_status'
        );
        $this->db->select($field);
        $this->db->where_in('activities.id', $where_in_activities_id);
        // $this->db->group_start();
        // $this->db->where('activities.is_forever', 1);
        // $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
        // $this->db->group_end();
        $this->db->join("activites_receive", 'activites_receive.activitie_id = activities.id', 'left');
        $this->db->order_by("created_at", "DESC");
        $activites_list = $this->db->get("activities")->result();
        // echo $this->db->last_query();
        // exit;
        $num_use = 0;//被使用
        $num_uncollected = 0;//未領取
        $num_receive = 0;//被領取
        foreach ($activites_list as $ac) {
            if ($ac->is_up_fictitious_up == 1 && isset($ac->fictitious) && $ac->fictitious > 0) {
                $num_uncollected = $num_uncollected + $ac->fictitious;
            }
        }

        //查詢當前商家被領取優惠卷
        $field = array(
            'activites_receive.*',
            'activities.name activitie_name',
            'activities.pic',
            'activities.use_start',
            'activities.is_forever',
            'activities.created_at',
            'members.nick_name',
            'aauth_users.store_address',
            'transamounts.store_id'
        );
        $this->db->select($field);
        $this->db->where_in('activites_receive.activitie_id', $where_in_activities_id);
        // $this->db->group_start();
        // $this->db->where('activities.is_forever', 1);
        // $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
        // $this->db->group_end();
        $this->db->join("activities", 'activities.id = activites_receive.activitie_id', 'left');
        $this->db->join("members", 'members.id = activites_receive.member_id', 'left');
        $this->db->join("transamounts", 'transamounts.activites_receive_id = activites_receive.id', 'left');
        $this->db->join("aauth_users", 'aauth_users.id = transamounts.store_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $activites_receive = $this->db->get("activites_receive")->result();
        foreach ($activites_receive as $acr) {
            if ($acr->status == 1) {
                $num_receive = $num_receive + 1;
            } else if ($acr->status == 2) {
                $num_use = $num_use + 1;
            }
        }
        return return_app_json("200", "獲取成功", [
            "num_use" => $num_use,
            "num_receive" => $num_receive,
            "num_uncollected" => ($num_uncollected - ($num_use + $num_receive)) > 0 ? ($num_uncollected - ($num_use + $num_receive)) : 0
        ]);
    }


}

