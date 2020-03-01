<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Server
 */
class Server extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }

    /**
     * 獲取搜索記錄
     */
    public function get_search_recommend_history()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $search_name = mb_strlen(trim(isset($_POST['search_name']) ?: "")) == 0 ? "" : trim($_POST['search_name']);
        $delete = mb_strlen(trim(isset($_POST['delete']) ?: "")) == 0 ? "" : trim($_POST['delete']);
        if ($search_name != "" && $delete != "" && $delete == "delete") {
            //刪除歷史記錄
            $this->db->where('member_id', $user_id);
            if ($search_name == "all") {
            } else {
                $this->db->where('name', $search_name);
            }
            $this->db->delete('searchhistory');
        }
        $my_search = $this->Data_helper_model->get_model_list_in_filed_orderby("searchhistory", "member_id", $user_id, "created_at", "DESC");
        $hot_search = $this->Data_helper_model->get_model_list_in_fileds_limit_orderby("searchhistory", ["member_id"], [0], 10, "hot", "DESC");
        $data["my_search"] = $my_search;
        $data["hot_search"] = $hot_search;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 搜索
     */
    public function get_search_result()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $search_name = mb_strlen(trim(isset($_POST['search_name']) ?: "")) == 0 ? "" : trim($_POST['search_name']);
        $longitude = mb_strlen(trim(isset($_POST['longitude']) ?: "")) == 0 ? "" : trim($_POST['longitude']);
        $latitude = mb_strlen(trim(isset($_POST['latitude']) ?: "")) == 0 ? "" : trim($_POST['latitude']);

        if ($search_name != "") {
            $list = [];
            $field = array(
                'activities.*',
                'aauth_users.store_name',
                'aauth_users.store_address',
                'aauth_users.store_cate_id',
                'aauth_users.latitude',
                'aauth_users.longitude',
                'preferentials.name preferential_name',
            );
            $this->db->select($field);
            $this->db->like('activities.name', $search_name, 'both');
            $this->db->or_like('activities.preferential_content', $search_name, 'both');
            $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
            $this->db->join("preferentials", 'preferentials.id = activities.preferential_id', 'left');
            $this->db->where('activities.status', 1);
            $this->db->order_by("activities.created_at", "DESC");
            $activities = $this->db->get("activities")->result();
            if ($activities && count($activities) > 0) {
                foreach ($activities as $act) {
                    $is_collection = $this->Data_helper_model->get_model_in_fileds_orderby("activities_collection", ["member_id", "activitie_id"], [$user_id, $act->id]);
                    if ($is_collection) {
                        $is_collection = "yes";
                    } else {
                        $is_collection = "no";
                    }

                    $received = "no";
                    $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $act->id]);
                    if ($activites_receive) {
                        $received = "yes";
                    }

                    $distance = 0;
                    if (!empty($act->latitude) && !empty($act->longitude)) {
                        $distance = distance($latitude, $longitude, $act->latitude, $act->longitude);
                        if ($distance > 0) {
                            $distance = round($distance * 1000);
                        }
                    }
                    $this->db->from("activites_receive");
                    $this->db->where("activitie_id", $act->id);
                    $receive_number = $this->db->count_all_results();
                    $list[] = [
                        "id" => $act->id,
                        "name" => $act->name,
                        "use_start" => $act->use_start,
                        "effective_time" => $act->use_end,
                        "coupon_address" => $act->store_address,
                        "img" => !empty($act->pic) ? compress_img(explode(",img,", $act->pic)[0],1280) : "",
                        "received" => $received,
                        "received_id" => isset($activites_receive) ? $activites_receive->id : "",
                        "repeat" => (isset($act->is_re) && $act->is_re == 1) ? "yes" : "no",
                        "store_id" => $act->store_id,
                        "receive_number" => $receive_number,//領取人數
                        "is_collection" => $is_collection,
                        "preferential_name" => $act->preferential_name,
                        "distance" => $distance,
                        "latitude" => $act->latitude,
                        "longitude" => $act->longitude,
                    ];
                }
                if ($list && count($list) > 0) {
                    //非本人搜索歷史
                    $searchhistory = $this->Data_helper_model->get_model_in_fileds_orderby("searchhistory", ["name", "member_id"], [$search_name, 0]);
                    if ($searchhistory) {
                        $sql_data = [
                            "hot" => $searchhistory->hot + 1,
                        ];
                        $this->Data_helper_model->update_table_in_fileds(
                            "searchhistory",
                            ["id"],
                            [$searchhistory->id],
                            $sql_data
                        );
                    } else {
                        $sql_data = [
                            "name" => $search_name,
                            "member_id" => 0,
                            "hot" => 1,
                            "created_at" => date("Y-m-d H:i:s", time())
                        ];
                        $this->db->insert("searchhistory", $sql_data);
                    }
                }
            }

            //本人搜索歷史
            $searchhistory = $this->Data_helper_model->get_model_list_in_fileds_orderby("searchhistory", ["member_id"], [$user_id], "created_at", "ASC");
            $is_insert = true;
            if ($searchhistory && count($searchhistory) > 0) {
                foreach ($searchhistory as $se) {
                    if ($se->name == $search_name) {
                        $sql_data = [
                            "created_at" => date("Y-m-d H:i:s", time()),
                        ];
                        $this->Data_helper_model->update_table_in_fileds(
                            "searchhistory",
                            ["id"],
                            [$se->id],
                            $sql_data
                        );
                        $is_insert = false;
                    }
                }
            }
            if ($is_insert) {
                if ($searchhistory && count($searchhistory) >= 10) {
                    foreach ($searchhistory as $se) {
                        $sql_data = [
                            "name" => $search_name,
                            "created_at" => date("Y-m-d H:i:s", time()),
                        ];
                        $this->Data_helper_model->update_table_in_fileds(
                            "searchhistory",
                            ["id"],
                            [$se->id],
                            $sql_data
                        );
                        break;
                    }
                } else {
                    $sql_data = [
                        "name" => $search_name,
                        "member_id" => $user_id,
                        "hot" => 1,
                        "created_at" => date("Y-m-d H:i:s", time())
                    ];
                    $this->db->insert("searchhistory", $sql_data);
                }
            }
            $data["list"] = $list;
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("106", "獲取失敗，請輸入搜索名稱", []);
        }
    }

    /**
     * 發現  獲取商家
     */
    public function get_business_list()
    {
        $longitude = mb_strlen(trim(isset($_POST['longitude']) ?: "")) == 0 ? "" : trim($_POST['longitude']);
        $latitude = mb_strlen(trim(isset($_POST['latitude']) ?: "")) == 0 ? "" : trim($_POST['latitude']);

        $field = array(
            'aauth_users.id',
            'aauth_users.store_name',
            'aauth_users.store_pic',
            'aauth_users.latitude',
            'aauth_users.longitude',
            'categorys.name type',
        );
        $this->db->select($field);
        $this->db->where('status', 1);
        $this->db->join("categorys", 'categorys.id = aauth_users.store_cate_id', 'left');
        $this->db->order_by("date_created", "DESC");
        $store_list = $this->db->get("aauth_users")->result();

        $field = array(
            'categorys.id',
            'categorys.name',
            'categorys.pic'
        );
        $this->db->select($field);
        $this->db->where('status', 1);
        $this->db->order_by("sort", "ASC");
        $categorys = $this->db->get("categorys")->result();

        $list = [];
        if ($store_list && count($store_list) > 0) {
            foreach ($store_list as $store) {
                $distance = 0;
                if (!empty($store->latitude) && !empty($store->longitude)) {
                    $distance = distance($latitude, $longitude, $store->latitude, $store->longitude);
                    if ($distance > 0) {
                        $distance = round($distance * 1000);
                    }
                }

                $list[] = [
                    "id" => $store->id,
                    "type" => $store->type,
                    "img" => !empty($store->store_pic) ? compress_img(explode(",img,", $store->store_pic)[0],1280) : "",
                    "name" => $store->store_name,
                    "distance" => $distance
                ];
            }
        }
        $data["categorys"] = $categorys;
        $data["list"] = $list;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 獲取優惠分類
     */
    public function get_categorys_preferential()
    {
        $categorys = $this->Data_helper_model->get_model_list_in_fileds_orderby("categorys", ["status"], [1], "created_at", "DESC");
        $preferentials = $this->Data_helper_model->get_model_list_in_fileds_orderby("preferentials", ["status"], [1], "created_at", "DESC");
        $categorys_list = [];
        $preferentials_list = [];
        if ($categorys && count($categorys) > 0) {
            foreach ($categorys as $cat) {
                $categorys_list[] = [
                    "id" => $cat->id,
                    "name" => $cat->name
                ];
            }
        }
        if ($preferentials && count($preferentials) > 0) {
            foreach ($preferentials as $pre) {
                $preferentials_list[] = [
                    "id" => $pre->id,
                    "name" => $pre->name
                ];
            }
        }
        $data["categorys_list"] = $categorys_list;
        $data["preferentials_list"] = $preferentials_list;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 獲取優惠券
     */
    public function get_activities()
    {
        $preferential_id = mb_strlen(trim(isset($_POST['preferential_id']) ?: "")) == 0 ? "" : trim($_POST['preferential_id']);
        $categorys_id = mb_strlen(trim(isset($_POST['categorys_id']) ?: "")) == 0 ? "" : trim($_POST['categorys_id']);
        $user_id = $this->Data_helper_model->get_app_user_id();
        $field = array(
            'activities.id',
            'activities.name',
            'activities.pic',
            'activities.use_end',
            'activities.is_re',
            'aauth_users.store_name',
            'aauth_users.store_address',
            'aauth_users.store_cate_id',
        );
        $this->db->select($field);
        if ($preferential_id != "") {
            $this->db->where('activities.preferential_id', $preferential_id);
        }
        if ($categorys_id != "") {
            $this->db->where('aauth_users.store_cate_id', $categorys_id);
        }
        $this->db->where('activities.status', 1);

        $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $activities = $this->db->get("activities")->result();
        $list = [];
        if ($activities && count($activities) > 0) {
            foreach ($activities as $act) {
                $received = "no";
                $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $act->id]);
                if ($activites_receive) {
                    $received = "yes";
                }

                $list[] = [
                    "id" => $act->id,
                    "name" => $act->name,
                    "effective_time" => $act->use_end,
                    "coupon_address" => $act->store_address,
                    "img" => !empty($act->pic) ? compress_img(explode(",img,", $act->pic)[0],1280): "",
                    "received" => $received,
                    "received_id" => isset($activites_receive) ? $activites_receive->id : "",
                    "repeat" => (isset($act->is_re) && $act->is_re == 1) ? "yes" : "no",
                ];
            }
        }
        $data["list"] = $list;
        return return_app_json("200", "獲取成功", $data);
    }

    public function test()
    {
        echo date("Y-m-d H:i:s", time());


        $this->load->driver('lock', array('adapter' => 'file', 'key_prefix' => ''));
        $this->lock->lock('test');

        $this->logs->log("測試：" . date("Y-m-d H:i:s", time()));
        echo " " . date("Y-m-d H:i:s", time());

        //echo 1/0;
        $this->lock->unlock('test');
    }

    /**
     * 領取優惠券
     */
    public function receive_coupon()
    {
        $coupon_id = mb_strlen(trim(isset($_POST['coupon_id']) ?: "")) == 0 ? "" : trim($_POST['coupon_id']);

        if ($coupon_id != "") {
            $this->load->driver('lock', array('adapter' => 'file', 'key_prefix' => ''));
            $this->lock->lock('test');
            try {
                $coupon = $this->Data_helper_model->get_coupon($coupon_id);
                if ($coupon && $coupon["status"]) {
                    return return_app_json("200", $coupon["msg"], []);
                } else {
                    return return_app_json("110", $coupon["msg"], []);
                }
            } catch (Exception $ex) {
                $this->lock->unlock('test');
            }
            $this->lock->unlock('test');
            return return_app_json("110", "領取失敗", []);
        } else {
            return return_app_json("110", "活動信息未獲取", []);
        }
    }

    /**
     * 獲取我的優惠券
     */
    public function get_my_conpon_list()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $longitude = mb_strlen(trim(isset($_POST['longitude']) ?: "")) == 0 ? "" : trim($_POST['longitude']);
        $latitude = mb_strlen(trim(isset($_POST['latitude']) ?: "")) == 0 ? "" : trim($_POST['latitude']);

        $field = array(
            'activites_receive.*',
            'activities.store_id',
            'activities.id activitie_id',
            'activities.pic',
            'activities.name activitie_name',
            'aauth_users.store_name',
            'aauth_users.store_logo',
            'aauth_users.longitude',
            'aauth_users.latitude'
        );
        $this->db->select($field);
        $this->db->where('activites_receive.member_id', $user_id);
        $this->db->join("activities", 'activities.id = activites_receive.activitie_id', 'left');
        $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
        $this->db->order_by("receive_datetime", "DESC");
        $my_a_receive = $this->db->get("activites_receive")->result();

        $coupon_all = [];
        $coupon_fu_jin = [];
        $coupon_guo_qi = [];
        $coupon_use = [];
        $coupon_zhuan_rang = [];

        $longitude_jia = $longitude + 0.007;
        $longitude_jian = $longitude - 0.007;
        $latitude_jia = $latitude + 0.007;
        $latitude_jian = $latitude - 0.007;

        foreach ($my_a_receive as $receive) {
            //全部
            $coupon_all[] = [
                "type" => "all",
                "store_name" => $receive->store_name,
                "activitie_name" => $receive->activitie_name,
                "use_end" => $receive->use_end,
                "pic" => !empty($receive->pic) ? compress_img(explode(",img,", $receive->pic)[0],1280) : "",
                "id" => $receive->id,
                "img" => !empty($receive->store_logo) ? compress_img(explode(",img,", $receive->store_logo)[0],1280) : "",
                "activitie_id" => $receive->activitie_id,
            ];
            //附近的
            if (!empty($receive->longitude) && !empty($receive->latitude)) {
                if ($receive->longitude < $longitude_jia && $receive->longitude > $longitude_jian && $receive->latitude < $latitude_jia && $receive->latitude > $latitude_jian) {
                    $coupon_fu_jin[] = [
                        "type" => "nearby",
                        "store_name" => $receive->store_name,
                        "activitie_name" => $receive->activitie_name,
                        "use_end" => $receive->use_end,
                        "pic" => !empty($receive->pic) ? compress_img(explode(",img,", $receive->pic)[0],1280) : "",
                        "id" => $receive->id,
                        "img" => !empty($receive->store_logo) ? compress_img(explode(",img,", $receive->store_logo)[0],1280) : "",
                        "activitie_id" => $receive->activitie_id,
                    ];
                }
            }
            //快過期
            if (isset($receive->use_end) && !empty($receive->use_end)) {
                if (strpos($receive->use_end, '0000') !== false) {

                } else {
                    if ((strtotime($receive->use_end) > time()) && $this->Data_helper_model->DiffDate(date("Y-m-d H:i:s", time()), $receive->use_end)[2] < 5) {
                        $coupon_guo_qi[] = [
                            "type" => "overdue",
                            "store_name" => $receive->store_name,
                            "activitie_name" => $receive->activitie_name,
                            "use_end" => $receive->use_end,
                            "pic" => !empty($receive->pic) ? compress_img(explode(",img,", $receive->pic)[0],1280) : "",
                            "id" => $receive->id,
                            "img" => !empty($receive->store_logo) ? compress_img(explode(",img,", $receive->store_logo)[0],1280) : "",
                            "activitie_id" => $receive->activitie_id,
                        ];
                    }
                }
            }
            //已使用
            if ($receive->status == 2) {
                $coupon_use[] = [
                    "type" => "use",
                    "store_name" => $receive->store_name,
                    "activitie_name" => $receive->activitie_name,
                    "use_end" => $receive->use_end,
                    "pic" => !empty($receive->pic) ? compress_img(explode(",img,", $receive->pic)[0],1280) : "",
                    "id" => $receive->id,
                    "img" => !empty($receive->store_logo) ? compress_img(explode(",img,", $receive->store_logo)[0],1280) : "",
                    "activitie_id" => $receive->activitie_id,
                ];
            }
            //已轉讓
            if ($receive->status == 3) {
                $coupon_zhuan_rang[] = [
                    "type" => "transfer",
                    "store_name" => $receive->store_name,
                    "activitie_name" => $receive->activitie_name,
                    "use_end" => $receive->use_end,
                    "pic" => !empty($receive->pic) ? compress_img(explode(",img,", $receive->pic)[0],1280) : "",
                    "id" => $receive->id,
                    "img" => !empty($receive->store_logo) ? compress_img(explode(",img,", $receive->store_logo)[0],1280) : "",
                    "activitie_id" => $receive->activitie_id,
                ];
            }
        }
        $data["list"] = [
            [
                "type" => "all",
                "name" => "全部",
                "list" => $coupon_all
            ],
            [
                "type" => "nearby",
                "name" => "附近",
                "list" => $coupon_fu_jin
            ],
            [
                "type" => "overdue",
                "name" => "快過期",
                "list" => $coupon_guo_qi
            ],
            [
                "type" => "use",
                "name" => "已使用",
                "list" => $coupon_use
            ],
            [
                "type" => "transfer",
                "name" => "已轉讓",
                "list" => $coupon_zhuan_rang
            ],
        ];

        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 獲取我的優惠券
     */
    public function get_nearby_store()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $longitude = mb_strlen(trim(isset($_POST['longitude']) ?: "")) == 0 ? "" : trim($_POST['longitude']);
        $latitude = mb_strlen(trim(isset($_POST['latitude']) ?: "")) == 0 ? "" : trim($_POST['latitude']);

        if ($longitude == "" || $latitude == "") {
            return return_app_json("120", "獲取失敗，未獲取到當前位置信息", []);
        }

        $longitude_jia = $longitude + 0.05;
        $longitude_jian = $longitude - 0.05;
        $latitude_jia = $latitude + 0.05;
        $latitude_jian = $latitude - 0.05;

        $field = array(
            'aauth_users.*',
            'categorys.name cate_name',
        );
        $this->db->select($field);
        $this->db->where('aauth_users.is_ok', 1);
        $this->db->group_start();
        $this->db->where('aauth_users.longitude <', $longitude_jia);
        $this->db->where('aauth_users.longitude >', $longitude_jian);
        $this->db->where('aauth_users.latitude <', $latitude_jia);
        $this->db->where('aauth_users.latitude >', $latitude_jian);
        $this->db->group_end();
        $this->db->join("categorys", 'categorys.id = aauth_users.store_cate_id', 'left');
        $this->db->order_by("aauth_users.id", "DESC");
        $store_list = $this->db->get("aauth_users")->result();

        $nearby_store = [];
        foreach ($store_list as $store) {
            $distance = 0;
            if (!empty($store->latitude) && !empty($store->longitude)) {
                $distance = distance($latitude, $longitude, $store->latitude, $store->longitude);
                if ($distance > 0) {
                    $distance = round($distance * 1000);
                }
            }
            $nearby_store[] = [
                "id" => $store->id,
                "name" => $store->store_name,
                "latitude" => $store->latitude,
                "longitude" => $store->longitude,
                "img" => !empty($store->store_pic) ? compress_img(explode(",img,", $store->store_pic)[0],1280) : "",
                "tag" => $store->cate_name,
                "distance" => $distance,
                "address" => $store->store_address,
                "phone" => $store->store_phone
            ];

        }
        $data["nearby_store"] = $nearby_store;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 獲取優惠券詳情
     */
    public function get_coupon_details()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $coupon_id = mb_strlen(trim(isset($_POST['coupon_id']) ?: "")) == 0 ? "" : trim($_POST['coupon_id']);
        if ($coupon_id != "") {
            $coupon = $this->Data_helper_model->get_model_in_id("activities", $coupon_id);
            $is_collection = $this->Data_helper_model->get_model_in_fileds("activities_collection", ["member_id", "activitie_id"], [$user_id, $coupon_id]);
            if ($coupon) {
                $store = $this->Data_helper_model->get_model_in_id("aauth_users", $coupon->store_id);
                $received = "no";
                $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $coupon_id]);
                if ($activites_receive) {
                    $received = "yes";
                }
                $data["coupon"] = [
                    "title" => $coupon->name,
                    "use_start" => $coupon->use_start,
                    "use_end" => $coupon->use_end,
                    "is_forever" => $coupon->is_forever,
                    "notes" => $coupon->points,
                    "introduction" => $coupon->preferential_content,
                    "is_collection" => $is_collection ? "yes" : "no",
                    "store_img" => isset($store) ? (!empty($store->store_pic) ? compress_img(explode(",img,", $store->store_pic)[0],1280) : "") : "",
                    "share" => "/Front/share/" . $coupon->id,
                    "received" => $received,
                    "received_id" => isset($activites_receive) ? $activites_receive->id : "",
                    "repeat" => (isset($coupon->is_re) && $coupon->is_re == 1) ? "yes" : "no",
                ];
                return return_app_json("200", "獲取成功", $data);
            } else {
                return return_app_json("112", "獲取失敗，資料有誤", []);
            }
        } else {
            return return_app_json("112", "獲取失敗，為獲取到優惠券資料", []);
        }
    }

    /**
     * 使用優惠券
     */
    public function use_coupon()
    {
        // $user_id = $this->Data_helper_model->get_app_user_id();
        // $coupon_id = mb_strlen(trim(isset($_POST['coupon_id']) ?: "")) == 0 ? "" : trim($_POST['coupon_id']);
        // if ($coupon_id != "") {
        // } else {
        //     return return_app_json("113", "獲取失敗，為獲取到優惠券資料", []);
        // }
        //
        // $coupon = $this->Data_helper_model->get_model_in_id("activities", $coupon_id);
        // if ($coupon) {
        // } else {
        //     return return_app_json("113", "獲取失敗，資料有誤", []);
        // }
        //
        // $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $coupon_id]);
        // if ($activites_receive) {
        // } else {
        //     return return_app_json("113", "執行失敗，未領取當前優惠券", []);
        // }
        //
        // if ($activites_receive->status == 1) {
        // } else {
        //     return return_app_json("113", "執行失敗，優惠券狀態有誤", []);
        // }
        //
        // if (strtotime($activites_receive->use_end) > strtotime(date("Y-m-d H:i:s", time()))) {
        // } else {
        //     return return_app_json("113", "執行失敗，優惠券已失效", []);
        // }
        // //標記使用
        // $sql_data = [
        //     "exchange_datetime" => date("Y-m-d H:i:s", time()),
        //     "status" => 2,
        // ];
        // $this->db->where('id', $activites_receive->id);
        // $this->db->update('activites_receive', $sql_data);
        // if ($this->db->affected_rows() > 0) {
        //     return return_app_json("200", "執行成功", []);
        // } else {
        //     return return_app_json("113", "執行失敗，資料無法存儲", []);
        // }

    }

    /**
     * 收藏或取消收藏優惠券
     */
    public function collection_or_cancel()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $coupon_id = mb_strlen(trim(isset($_POST['coupon_id']) ?: "")) == 0 ? "" : trim($_POST['coupon_id']);
        $collection = mb_strlen(trim(isset($_POST['collection']) ?: "")) == 0 ? "" : trim($_POST['collection']);
        if ($coupon_id != "" && $collection != "") {
        } else {
            return return_app_json("114", "操作失敗，為獲取到相關資料", []);
        }

        $coupon = $this->Data_helper_model->get_model_in_id("activities", $coupon_id);
        if ($coupon) {
        } else {
            return return_app_json("114", "操作失敗，資料有誤", []);
        }

        if ($collection == "cancel") {
            $this->db->where('member_id', $user_id);
            $this->db->where('activitie_id', $coupon_id);
            $this->db->delete('activities_collection');
            return return_app_json("200", "取消收藏成功", []);
        }
        if ($collection == "collection") {
            $activites_receive = $this->Data_helper_model->get_model_in_fileds("activities_collection", ["member_id", "activitie_id"], [$user_id, $coupon_id]);
            if ($activites_receive) {
                return return_app_json("200", "收藏成功", []);
            } else {
                $activities_collection_id = $this->uuid->v4();
                $sql_data = [
                    "id" => $activities_collection_id,
                    "activitie_id" => $coupon_id,
                    "member_id" => $user_id,
                    "collection_datetime" => date("Y-m-d H:i:s", time()),
                ];
                if ($this->db->insert("activities_collection", $sql_data)) {
                    return return_app_json("200", "收藏成功", []);
                } else {
                    return return_app_json("114", "收藏失敗，資料無法存儲", []);
                }
            }
        }
        return return_app_json("114", "操作失敗", []);
    }

    /**
     * 獲取我的收藏 優惠券列表
     */
    public function collection_receive()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $field = array(
            'activities_collection.*',
            'activities.id activitie_id',
            'activities.store_id',
            'activities.pic activities_pic',
            'activities.name activitie_name',
            'activities.is_forever',
            'activities.use_start',
            'activities.use_end',
            'activities.is_re',
            'aauth_users.store_address',
            'aauth_users.store_name',
            'aauth_users.store_logo',
        );
        $this->db->select($field);
        $this->db->where('activities_collection.member_id', $user_id);
        $this->db->join("activities", 'activities.id = activities_collection.activitie_id', 'left');
        $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
        $this->db->order_by("collection_datetime", "DESC");
        $my_collection_list = $this->db->get("activities_collection")->result();
        $collection = [];
        foreach ($my_collection_list as $my_collection) {
            $received = "no";
            $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $my_collection->activitie_id]);
            if ($activites_receive) {
                $received = "yes";
            }
            $collection[] = [
                "id" => $my_collection->id,
                "activitie_id" => $my_collection->activitie_id,
                "head" => !empty($my_collection->store_logo) ? compress_img(explode(",img,", $my_collection->store_logo)[0],1280) : "",
                "business_address" => $my_collection->store_address,
                "coupon_name" => $my_collection->activitie_name,
                "is_forever" => $my_collection->is_forever,
                "use_start" => $my_collection->use_start,
                "use_end" => $my_collection->use_end,
                "img" => !empty($my_collection->activities_pic) ? compress_img(explode(",img,", $my_collection->activities_pic)[0],1280) : "",
                "received" => $received,
                "received_id" => isset($activites_receive) ? $activites_receive->id : "",
            ];
        }
        $data["collection"] = $collection;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 轉讓優惠券
     */
    public function transfer_counpon()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $coupon_id = mb_strlen(trim(isset($_POST['coupon_id']) ?: "")) == 0 ? "" : trim($_POST['coupon_id']);
        if ($coupon_id != "") {
        } else {
            return return_app_json("116", "操作失敗，為獲取到相關資料", []);
        }

        $coupon = $this->Data_helper_model->get_model_in_id("activities", $coupon_id);
        if ($coupon) {
        } else {
            return return_app_json("116", "操作失敗，資料有誤", []);
        }

        $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $coupon_id]);
        if ($activites_receive) {
        } else {
            return return_app_json("116", "執行失敗，未領取當前優惠券", []);
        }

        if ($activites_receive->status == 1) {
        } else {
            return return_app_json("116", "執行失敗，優惠券狀態有誤", []);
        }

        if (strtotime($activites_receive->use_end) > strtotime(date("Y-m-d H:i:s", time()))) {
        } else {
            return return_app_json("116", "執行失敗，優惠券已失效", []);
        }

        //標記使用
        $sql_data = [
            "status" => 3,
        ];
        $this->db->where('id', $activites_receive->id);
        $this->db->update('activites_receive', $sql_data);

        if ($this->db->affected_rows() > 0) {
            if (isset($activites_receive->activities_fictitious_code_id) && !empty($activites_receive->activities_fictitious_code_id)) {
                $sql_data = [
                    "status" => 1,
                ];
                $this->db->where("id", $activites_receive->activities_fictitious_code_id);
                $this->db->update("activities_fictitious_code", $sql_data);
            }

            return return_app_json("200", "執行成功", []);
        } else {
            return return_app_json("116", "執行失敗，資料無法存儲", []);
        }
    }

    /**
     * 獲取主頁信息
     */
    public function get_home_coupon_List()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();

        $longitude = mb_strlen(trim(isset($_POST['longitude']) ?: "")) == 0 ? "" : trim($_POST['longitude']);
        $latitude = mb_strlen(trim(isset($_POST['latitude']) ?: "")) == 0 ? "" : trim($_POST['latitude']);

        //獲取附近優惠
        if ($longitude != "" && $latitude != "") {
            $longitude_jia = $longitude + 0.007;
            $longitude_jian = $longitude - 0.007;
            $latitude_jia = $latitude + 0.007;
            $latitude_jian = $latitude - 0.007;
        }

        $field = array(
            'activities.id',
            'activities.store_id',
            'activities.pic',
            'activities.name',
            'activities.use_start',
            'activities.use_end',
            'activities.is_forever',
            'activities.created_at',
            'preferentials.name label_name',
            'aauth_users.store_name',
            'aauth_users.longitude',
            'aauth_users.latitude'
        );
        $this->db->select($field);

        if ($longitude != "" && $latitude != "") {
            $this->db->where('aauth_users.longitude <', $longitude_jia);
            $this->db->where('aauth_users.longitude >', $longitude_jian);
            $this->db->where('aauth_users.latitude <', $latitude_jia);
            $this->db->where('aauth_users.latitude >', $latitude_jian);
        }
        $this->db->where('activities.status', 1);
        $this->db->group_start();
        $this->db->where('activities.is_forever', 1);
        $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
        $this->db->group_end();
        $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
        $this->db->join("preferentials", 'preferentials.id = activities.preferential_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $activities_list = $this->db->get("activities")->result();
        // echo $this->db->last_query();
        // exit;
        $nearby_list = [];
        foreach ($activities_list as $act) {
            $this->db->from("searchhistory");
            $this->db->like("name", $act->name);
            $hot = $this->db->count_all_results();
            $nearby_list[] = [
                "id" => $act->id,
                "name" => $act->name,
                "img" => !empty($act->pic) ? compress_img(explode(",img,", $act->pic)[0],1280) : "",
                "activity_label" => $act->label_name,
                "is_forever" => $act->is_forever,
                "use_start" => $act->use_start,
                "use_end" => $act->use_end,
                "hot" => $hot > 0 ? 1 : 0,
            ];
        }
        $data["nearby"] = $nearby_list;

        //獲取推薦優惠
        //$activities_list = $this->Data_helper_model->get_model_list_in_fileds_limit_orderby("activities", ["status"], [1], 10, "created_at", "DESC", ["id", "pic", "name"]);
        $field = array(
            'activities.id',
            'activities.store_id',
            'activities.pic',
            'activities.name',
            'activities.use_start',
            'activities.use_end',
            'activities.is_forever',
            'activities.created_at',
            'preferentials.name label_name',
            'aauth_users.store_name',
            'aauth_users.longitude',
            'aauth_users.latitude'
        );
        $this->db->select($field);
        $this->db->where('activities.status', 1);
        $this->db->group_start();
        $this->db->where('activities.is_forever', 1);
        $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
        $this->db->group_end();
        $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
        $this->db->join("preferentials", 'preferentials.id = activities.preferential_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $this->db->limit(10);
        $activities_list = $this->db->get("activities")->result();


        $recommend = [];
        foreach ($activities_list as $activities) {
            $distance = 0;
            if (!empty($activities->longitude) && !empty($activities->latitude) && $longitude != "" && $latitude != "") {
                $distance = distance($latitude, $longitude, $activities->latitude, $activities->longitude);
                if ($distance > 0) {
                    $distance = round($distance * 1000);
                }
            }
            $recommend[] = [
                "id" => $activities->id,
                "img" => !empty($activities->pic) ? compress_img(explode(",img,", $activities->pic)[0],1280) : "",
                "name" => $activities->name,
                "distance" => $distance,
                "type" => $activities->label_name
            ];
        }
        $data["recommend"] = $recommend;

        //獲取我的領取優惠券
        $field = array(
            'activites_receive.*',
            'activities.store_id',
            'activities.use_start',
            'activities.pic',
            'activities.name activitie_name',
            'aauth_users.store_name',
            'aauth_users.store_logo',
        );
        $this->db->select($field);
        $this->db->where('activites_receive.member_id', $user_id);
        $this->db->where('activites_receive.status', 1);
        $this->db->join("activities", 'activities.id = activites_receive.activitie_id', 'left');
        $this->db->join("aauth_users", 'aauth_users.id = activities.store_id', 'left');
        $this->db->order_by("receive_datetime", "DESC");
        $my_a_receive = $this->db->get("activites_receive")->result();
        $my_coupon = [];
        foreach ($my_a_receive as $my_c) {
            $my_coupon[] = [
                "id" => $my_c->id,
                "activitie_id" => $my_c->activitie_id,
                "pic" => !empty($my_c->pic) ? compress_img(explode(",img,", $my_c->pic)[0],1280) : "",
                "img" => !empty($my_c->store_logo) ? compress_img(explode(",img,", $my_c->store_logo)[0],1280) : "",
                "store_name" => $my_c->store_name,
                "activitie_name" => $my_c->activitie_name,
                "use_start" => $my_c->use_start,
                "use_end" => $my_c->use_end,
            ];
        }
        $data["my_coupon"] = $my_coupon;

        //獲取首頁輪播 廣告
        $field = array(
            'advertisements.id',
            'advertisements.name',
            'advertisements.banner',
            'advertisements.type',
            'advertisements.store_id',
            'advertisements.activitie_id',
            'advertisements.link',
        );
        $this->db->select($field);
        $this->db->where('advertisements.status', 1);
        $this->db->where('advertisements.startshelf_at <', date("Y-m-d H:i:s", time()));
        $this->db->where('advertisements.endshelf_at >', date("Y-m-d H:i:s", time()));
        $this->db->order_by("created_at", "DESC");
        $banner_list = $this->db->get("advertisements")->result();
        $banner = [];
        foreach ($banner_list as $b) {
            $banner[] = [
                "id" => $b->id,
                "name" => $b->name,
                "picture" => !empty($b->banner) ? compress_img(explode(",img,", $b->banner)[0],1280) : "",
                "type" => $b->type,
                "store_id" => $b->store_id,
                "activitie_id" => $b->activitie_id,
                "link" => $b->link,
            ];
        }
        $data["banner"] = $banner;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 檢測優惠卷是否使用成功
     */
    public function check_counpon()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $coupon_id = mb_strlen(trim(isset($_POST['coupon_id']) ?: "")) == 0 ? "" : trim($_POST['coupon_id']);
        if ($coupon_id != "") {
        } else {
            return return_app_json("118", "獲取失敗，為獲取到相關資料", []);
        }

        $coupon = $this->Data_helper_model->get_model_in_id("activites_receive", $coupon_id);
        if ($coupon) {
            return return_app_json("200", "獲取成功", [
                "status" => $coupon->status == 2 ? "yes" : "no"
            ]);
        } else {
            return return_app_json("118", "獲取失敗，資料有誤", []);
        }
    }

    /**
     * 獲取商家詳情
     */
    public function get_business_details()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $store_id = mb_strlen(trim(isset($_POST['store_id']) ?: "")) == 0 ? "" : trim($_POST['store_id']);
        if ($store_id != "") {
            $store = $this->Data_helper_model->get_model_in_id("aauth_users", $store_id);
            if ($store) {
            } else {
                return return_app_json("119", "獲取失敗，未獲取到商家資料", []);
            }

            $data["business"] = [
                "business_img" => !empty($store->store_pic) ? compress_img(explode(",img,", $store->store_pic)[0],1280) : "",
                "business_name" => $store->store_name,
                "business_address" => $store->store_address,
                "business_phone" => $store->store_phone,
            ];

            $where_in_activities_id = [];

            $activities = $this->Data_helper_model->get_model_list_in_fileds("activities", ["store_id"], [$store_id]);
            if ($activities && count($activities) > 0) {
                foreach ($activities as $a_id) {
                    if (empty($a_id->id)) {

                    } else {
                        $where_in_activities_id[] = $a_id->id;
                    }
                }
            }

            $activities_join_store = $this->Data_helper_model->get_model_list_in_fileds("activities_join_store", ["store_id"], [$store_id]);
            if ($activities_join_store && count($activities_join_store) > 0) {
                foreach ($activities_join_store as $a_id) {
                    if (empty($a_id->activities_id)) {

                    } else {
                        $where_in_activities_id[] = $a_id->activities_id;
                    }
                }
            }

            if ($where_in_activities_id && count($where_in_activities_id) > 0) {


                $field = array(
                    'activities.id',
                    'activities.name',
                    'activities.pic',
                    'activities.use_start',
                    'activities.use_end',
                    'activities.is_forever',
                    'activities.is_re'
                );
                $this->db->select($field);
                $this->db->where_in('activities.id', $where_in_activities_id);
                $this->db->where('activities.status', 1);
                $this->db->group_start();
                $this->db->where('activities.is_forever', 1);
                $this->db->or_where('activities.use_end >', date("Y-m-d H:i:s", time()));
                $this->db->group_end();
                $this->db->order_by("id", "DESC");
                $store_receive = $this->db->get("activities")->result();

                $coupons = [];
                if ($store_receive && count($store_receive) > 0) {
                    foreach ($store_receive as $re) {
                        $is_collection = $this->Data_helper_model->get_model_in_fileds("activities_collection", ["member_id", "activitie_id"], [$user_id, $re->id]);
                        $this->db->from("activites_receive");
                        $this->db->where("activitie_id", $re->id);
                        $receive_number = $this->db->count_all_results();

                        $received = "no";
                        $activites_receive = $this->Data_helper_model->get_model_in_fileds("activites_receive", ["member_id", "activitie_id"], [$user_id, $re->id]);
                        if ($activites_receive) {
                            $received = "yes";
                        }

                        $coupons[] = [
                            "name" => $re->name,
                            "img" => !empty($re->pic) ? compress_img(explode(",img,", $re->pic)[0],1280) : "",
                            "use_start" => $re->use_start,
                            "use_end" => $re->use_end,
                            "is_forever" => $re->is_forever,
                            "is_collection" => $is_collection ? "yes" : "no",
                            "id" => $re->id,
                            "receive_number" => $receive_number,
                            "received" => $received,
                            "received_id" => isset($activites_receive) ? $activites_receive->id : "",
                            "repeat" => (isset($re->is_re) && $re->is_re == 1) ? "yes" : "no",
                        ];
                    }
                }
            } else {
                $coupons = [];
            }
            $data["coupon"] = $coupons;
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("119", "獲取失敗，為獲取到優惠券資料", []);
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

    /**
     * 獲取消費記錄
     */
    public function get_transamounts()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        //查詢當前商家被領取優惠卷
        $field = array(
            'transamounts.*',
            'activites_receive.use_end use_end',
            'activities.name activitie_name',
            'activities.pic',
            'activities.use_start',
            'activities.is_forever',
            'members.nick_name',
            'aauth_users.id store_id',
            'aauth_users.store_name',
            'aauth_users.store_address',
            'aauth_users.store_logo',
        );
        $this->db->select($field);
        //$this->db->where('transamounts.store_id', $user_id);
        $this->db->group_start();
        $this->db->where('transamounts.member_id', $user_id);
        $this->db->group_end();
        $this->db->join("activites_receive", 'activites_receive.id = transamounts.activites_receive_id', 'left');
        $this->db->join("activities", 'activities.id = transamounts.activites_id', 'left');
        $this->db->join("members", 'members.id = transamounts.member_id', 'left');
        $this->db->join("aauth_users", 'aauth_users.id = transamounts.store_id', 'left');
        $this->db->order_by("created_at", "DESC");
        $transamounts = $this->db->get("transamounts")->result();
        // echo $this->db->last_query();
        // exit;
        $order_list = [];
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        foreach ($transamounts as $ts) {
            $order_list[] = [
                "nick_name" => isset($ts->nick_name) ? $ts->nick_name : "",
                "amount" => $ts->amount,
                "activitie_name" => $ts->activitie_name,
                "use_time" => $ts->created_at,
                "store_id" => $ts->store_id,
                "store_name" => $ts->store_name,
                "store_address" => $ts->store_address,
                "activitie_pic" => !empty($ts->pic) ? compress_img(explode(",img,", $ts->pic)[0],1280) : "",
                "store_logo" => !empty($ts->store_logo) ? compress_img(explode(",img,", $ts->store_logo)[0],1280) : "",
            ];
        }
        $data["order_list"] = $order_list;
        return return_app_json("200", "獲取成功", $data);
    }

    /**
     * 獲取 服務條款
     */
    public function get_terms()
    {
        $term = $this->Data_helper_model->get_model_in_filed("terms", "id", 1);
        if ($term) {
            if (IS_POST) {
                return return_app_json("200", "獲取成功", $term->content);
            }
            if (IS_GET) {
                $data["html"] = $term->content;
                $this->load->view("Front/terms", $data);
            }
        } else {
            return return_app_json("120", "獲取失敗", null);
        }
    }

}

