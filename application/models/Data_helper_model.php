<?php

class Data_helper_model extends CI_Model
{
    /**
     * @param $db 數據庫操作對象
     * @param $post POST參數數據
     * @param $table 表名
     * @return array 返回bs table數據
     */

    function __construct()
    {
        parent::__construct();
        $this->load->library("Uuid");
    }

    /**
     * 通用方法
     * 獲取bootstrap table 列表數據
     * @param $db
     * @param $post
     * @param $table
     * @return array
     */
    public function get_tabel_list($db, $post, $table, $is_many_sort = false)
    {
        $offset = mb_strlen(trim(isset($post['offset']) ?: "")) == 0 ? 0 : (int)trim($post['offset']);
        $sort = mb_strlen(trim(isset($post['sort']) ?: "")) == 0 ? "id" : trim($post['sort']);
        $order = mb_strlen(trim(isset($post['order']) ?: "")) == 0 ? "DESC" : trim($post['order']);
        $order = strtoupper($order);
        $sort = $table . "." . $sort;
        // 每页行数
        $limit = mb_strlen(trim(isset($post['limit']) ?: "")) == 0 ? 10 : (int)trim($post['limit']);
        //$search = mb_strlen(trim($_POST['search'])) == 0?"":trim($_POST['search']);

        $db->from($table);
        if ($is_many_sort) {
            $db->order_by("create_id", "DESC");
        }
        $db->order_by($sort, $order);

        $db_count = clone($db);
        $total = $db_count->count_all_results();

        $db->limit($limit);
        $db->offset($offset);

        $query = $db->get();
        $data = $query->result_array();
        // echo json_encode(array('total' => $total, 'rows' => $data));
        // exit;
        return array('total' => $total, 'rows' => $data);
    }

    /**
     * 通用方法
     * 更新表格單個字段 主鍵名為id
     * @param $id
     * @param $tabel
     * @param $field
     * @param $value
     * @return bool
     */
    public function tabel_status($id, $tabel, $field, $value)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();

        $this->db->where('id', $id);
        $result = $this->db->get($tabel)->row_array();

        //$this->json("ok",$this->db->last_query(),"",null); exit;
        if ($result) {
            $result[$field] = $value;
            if (array_key_exists("updated_at", $result)) {
                $result["updated_at"] = date("Y-m-d H:i:s", time());
            }
            $this->db->where('id', $id);
            if ($this->db->update($tabel, $result)) {
                $this->db = $clone_db;
                return TRUE;
            } else {
                $this->db = $clone_db;
                return FALSE;
            }
        } else {
            $this->db = $clone_db;
            return FALSE;
        }
    }

    /**
     * 通用方法 aauth_users
     * 獲取管理員資料
     * @param $id
     * @return mixed
     */
    public function get_admin($id)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('aauth_users');
        $this->db = $clone_db;
        return $query->row_array();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $id
     * @return mixed
     */
    public function get_model_in_id($tabel, $id)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where('id', $id);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->row();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @return mixed
     */
    public function get_model_in_filed($tabel, $filed, $value)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where($filed, $value);
        $this->db->limit(1);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->row();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @return mixed
     */
    public function get_model_in_filed_orderby($tabel, $filed, $value, $orderby = "id", $is_asc = "ASC")
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where($filed, $value);
        $this->db->order_by($orderby, $is_asc);
        $this->db->limit(1);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->row();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @return mixed
     */
    public function get_model_in_fileds($tabel, $filed, $value)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $num = count($filed);
        for ($i = 0; $i < $num; ++$i) {
            $this->db->where($filed[$i], $value[$i]);
        }
        //$this->db->where($filed, $value);
        $this->db->limit(1);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->row();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @param string $orderby
     * @param string $is_asc
     * @return mixed
     */
    public function get_model_in_fileds_orderby($tabel, $filed, $value, $orderby = "id", $is_asc = "ASC")
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $num = count($filed);
        for ($i = 0; $i < $num; ++$i) {
            $this->db->where($filed[$i], $value[$i]);
        }
        //$this->db->where($filed, $value);
        $this->db->order_by($orderby, $is_asc);
        $this->db->limit(1);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->row();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @return mixed
     */
    public function get_model_list_in_fileds($tabel, $filed, $value)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $num = count($filed);
        for ($i = 0; $i < $num; ++$i) {
            $this->db->where($filed[$i], $value[$i]);
        }
        //$this->db->where($filed, $value);
        //$this->db->limit(1);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @param string $orderby
     * @param string $is_asc
     * @return mixed
     */
    public function get_model_list_in_filed_orderby($tabel, $filed, $value, $orderby = "id", $is_asc = "ASC")
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where($filed, $value);
        $this->db->order_by($orderby, $is_asc);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @param $limit
     * @param string $orderby
     * @param string $is_asc
     * @return mixed
     */
    public function get_model_list_in_filed_limit_orderby($tabel, $filed, $value, $limit, $orderby = "id", $is_asc = "ASC")
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where($filed, $value);
        $this->db->order_by($orderby, $is_asc);
        $this->db->limit($limit);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @param string $orderby
     * @param string $is_asc
     * @param array $select_filed
     * @return mixed
     */
    public function get_model_list_in_fileds_orderby($tabel, $filed, $value, $orderby = "id", $is_asc = "ASC", $select_filed = [])
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();

        if (count($select_filed) > 0) {
            $this->db->select($select_filed);
        }

        $num = count($filed);
        for ($i = 0; $i < $num; ++$i) {
            $this->db->where($filed[$i], $value[$i]);
        }
        $this->db->order_by($orderby, $is_asc);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->result();
    }

    public function get_model_list_in_fileds_limit_orderby($tabel, $filed, $value, $limit, $orderby = "id", $is_asc = "ASC", $select_filed = [])
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();

        if (count($select_filed) > 0) {
            $this->db->select($select_filed);
        }

        $num = count($filed);
        for ($i = 0; $i < $num; ++$i) {
            $this->db->where($filed[$i], $value[$i]);
        }
        $this->db->order_by($orderby, $is_asc);
        $this->db->limit($limit);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $table
     * @param $id
     * @return mixed
     */
    public function del_model_in_id($table, $id)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where('id', $id);
        $query = $this->db->delete($table);
        $this->db = $clone_db;
        return $query;
    }

    /**
     * 通用方法
     * @param $table
     * @return mixed
     */
    public function get_model_list($table)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $query = $this->db->get($table);
        //return $query->result_array();//關聯數組
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $table
     * @return mixed
     */
    public function get_model_list_orderby($table, $orderby = "id", $is_asc = "ASC")
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->order_by($orderby, $is_asc);
        $query = $this->db->get($table);
        //return $query->result_array();//關聯數組
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed
     * @param $value
     * @return mixed
     */
    public function get_model_list_in_filed($tabel, $filed, $value)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();
        $this->db->where($filed, $value);
        //$this->db->where($filed, $value);
        //$this->db->limit(1);
        $query = $this->db->get($tabel);
        $this->db = $clone_db;
        return $query->result();
    }

    /**
     * 通用方法
     * @param $array
     * @param $id
     * @return bool
     */
    public function get_model_in_result($array, $id)
    {
        foreach ($array as $model) {
            if ($model->id == $id) {
                return $model;
            }
        }
        return FALSE;
    }

    /**
     * +----------------------------------------------------------
     * 功能：计算两个日期相差 年 月 日
     * +----------------------------------------------------------
     * @param  date $date1 起始日期
     * @param  date $date2 截止日期日期
     * +----------------------------------------------------------
     * @return array
     * +----------------------------------------------------------
     */
    public function DiffDate($date1, $date2)
    {
        $date1 = Date("Y-m-d", strtotime($date1));
        $date2 = Date("Y-m-d", strtotime($date2));
        if (strtotime($date1) > strtotime($date2)) {
            $ymd = $date2;
            $date2 = $date1;
            $date1 = $ymd;
        }
        list($y1, $m1, $d1) = explode('-', $date1);
        list($y2, $m2, $d2) = explode('-', $date2);
        $y = $m = $d = $_m = 0;
        $math = ($y2 - $y1) * 12 + $m2 - $m1;
        $y = round($math / 12);
        $m = intval($math % 12);
        $d = (mktime(0, 0, 0, $m2, $d2, $y2) - mktime(0, 0, 0, $m2, $d1, $y2)) / 86400;
        if ($d < 0) {
            $m -= 1;
            $d += date('j', mktime(0, 0, 0, $m2, 0, $y2));
        }
        $m < 0 && $y -= 1;
        return array($y, $m, $d);
    }

    /**
     * 通用方法
     * @param $tabel
     * @param $filed_where
     * @param $value_where
     * @param $obj_arr
     * @return bool
     */
    public function update_table_in_fileds($tabel, $filed_where, $value_where, $obj_arr)
    {
        $clone_db = clone($this->db);
        $this->db->reset_query();

        // $sql_data = [];
        // $num = count($filed);
        // for ($i = 0; $i < $num; ++$i) {
        //     $sql_data[$filed[$i]] = $value[$i];
        // }
        //
        $num_where = count($filed_where);
        for ($i = 0; $i < $num_where; ++$i) {
            $this->db->where($filed_where[$i], $value_where[$i]);
        }

        $this->db->update($tabel, $obj_arr);
        if ($this->db->affected_rows() > 0) {
            $this->db = $clone_db;
            return true;
        } else {
            $this->db = $clone_db;
            return false;
        }
    }




    //------------------------------------------------------------------------------------------------------------------
    //-----------------項目專屬--------------------------------------------
    //------------------------------------------------------------------------------------------------------------------

    /**
     * 第三方登入
     * @param $platform
     * @param $platform_id
     * @return bool
     */
    public function third_login($platform, $platform_id, $store_id = "")
    {
        $model = $this->get_model_in_fileds("member_join_third", ["third_name", "hash_key"], [$platform, $platform_id]);
        if ($model) {
            $user_model = $this->get_model_in_fileds("members", ["id"], [$model->member_id]);
            if ($user_model) {
                $token = jwt_helper::create($user_model->id);
                $sql_data = [
                    "token" => $token,
                    "last_login" => date("Y-m-d H:i:s", time())
                ];
                $this->db->where("id", $user_model->id);
                if ($this->db->update("members", $sql_data)) {
                    return $token;
                } else {
                    $this->logs->log("第三方登入失敗，token無法保存資料庫：" . date("Y-m-d H:i:s", time()));
                    return false;
                }
            } else {
                $this->logs->log("第三方登入失敗，存在第三方憑證，但用戶表資料無信息 third_name：" . $platform . " hash_key:" . $platform_id . " member_join_third:" . json_encode($model, JSON_UNESCAPED_UNICODE));
                return false;
            }
        } else {
            //開啟事務
            $this->db->trans_start();
            //創建會員
            $sql_data = [
                "created_at" => date("Y-m-d H:i:s", time())
            ];
            $this->db->insert("members", $sql_data);
            $user_id = $this->db->insert_id();
            $token = jwt_helper::create($user_id);
            //更新會員token
            $sql_data = [
                "token" => $token,
                "store_id" => $store_id,
                "last_login" => date("Y-m-d H:i:s", time())
            ];
            $this->db->where("id", $user_id);
            $this->db->update("members", $sql_data);
            //創建第三方登入資料
            $sql_data = [
                "third_name" => $platform,
                "hash_key" => $platform_id,
                "member_id" => $user_id
            ];
            $this->db->insert("member_join_third", $sql_data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {

                return false;
                // generate an error... or use the log_message() function to log your error
            } else {
                return $token;
            }

        }
    }

    /**
     * 更新token
     * @param $token
     * @return bool
     */
    public function update_token($token)
    {
        $jwt = jwt_helper::decode($token);
        if ($jwt) {
            if (isset($jwt->userId)) {
                $token = jwt_helper::create($jwt->userId);
                $sql_data = [
                    "token" => $token,
                    //"last_login" => date("Y-m-d H:i:s", time())
                ];
                $this->db->where("id", $jwt->userId);
                if ($this->db->update("members", $sql_data)) {
                    return $token;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        return false;
    }

    /**
     * app登入驗證
     * @param $token
     * @return bool
     */
    public function check_token_login($token)
    {
        if (jwt_helper::validate($token)) {
            $jwt = jwt_helper::decode($token);
            if ($jwt) {
                if (isset($jwt->userId)) {
                    if ($this->get_model_in_fileds("members", ["token"], [$token])) {
                        $this->session->set_flashdata('app_user_id', $jwt->userId);
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            $jwt = jwt_helper::decode($token);
            if ($jwt) {
                if (isset($jwt->userId)) {
                    if ($this->get_model_in_fileds("members", ["token"], [$token])) {
                        return "updata_token";
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 拿取app用戶id 必須配合check_token_login使用
     * @return mixed
     */
    public function get_app_user_id()
    {
        $user_id = $this->session->flashdata('app_user_id');
        return $user_id;
    }

    public function get_coupon($activites_id)
    {
        $user_id = $this->get_app_user_id();
        $coupon = [
            "status" => false,
            "msg" => "",
            "activites_receive" => null
        ];
        $activite = $this->get_model_in_id("activities", $activites_id);
        if ($activite) {
        } else {
            $coupon["msg"] = "活動已不存在";
            return $coupon;
        }

        if ($activite->is_forever == 1) {
        } else {
            if (strtotime(date("Y-m-d H:i:s")) > strtotime($activite->use_end)) {
                $coupon["msg"] = "活動有效期已過";
                return $coupon;
            }
        }

        if ($activite->mode == 0) {
            if ($this->get_model_in_fileds("activites_receive", ["member_id", "activitie_id", "status !="], [$user_id, $activite->id, 3])) {
                if ($activite->is_re == 1) {

                } else {
                    $coupon["msg"] = "不可重複領取";
                    return $coupon;
                }
            }
        } else {
            $this->db->from("activites_receive");
            $this->db->where("activitie_id", $activites_id);
            $this->db->where("status !=", 3);
            $receive_number = $this->db->count_all_results();

            $fictitious_num = 0;
            if (isset($activite->is_up_fictitious_up) && $activite->is_up_fictitious_up == 1) {
                $this->db->from("activities_fictitious_code");
                $this->db->where("activitie_id", $activite->id);
                $fictitious_num = $this->db->count_all_results();
            } else {
                $fictitious_num = $activite->fictitious;
            }

            if ($fictitious_num > $receive_number) {
                if ($this->get_model_in_fileds("activites_receive", ["member_id", "activitie_id", "status !="], [$user_id, $activite->id, 3])) {
                    if ($activite->is_re == 1) {

                    } else {
                        $coupon["msg"] = "不可重複領取";
                        return $coupon;
                    }
                }
            } else {
                $coupon["msg"] = "數量不足已領取";
                return $coupon;
            }
        }

        $activities_fictitious_code_id = "";
        if (isset($activite->is_up_fictitious_up) && $activite->is_up_fictitious_up == 1) {
            $activities_fictitious = $this->get_model_in_fileds("activities_fictitious_code", ["status", "activitie_id"], ["1", $activite->id]);
            if ($activities_fictitious) {
                $activities_fictitious_code_id = $activities_fictitious->id;

                $sql_data = [
                    "status" => 2,
                ];
                $this->db->where("id", $activities_fictitious_code_id);
                $this->db->update("activities_fictitious_code", $sql_data);
            } else {
                $coupon["msg"] = "序號不足";
                return $coupon;
            }
        }

        //開啟事務
        $this->db->trans_start();

        $a_receive_id = $this->uuid->v4();
        $sql_data = [
            "id" => $a_receive_id,
            "activitie_id" => $activites_id,
            "member_id" => $user_id,
            "activities_fictitious_code_id" => $activities_fictitious_code_id,
            "status" => 1,
            "receive_datetime" => date("Y-m-d H:i:s", time()),
            "use_end" => $activite->use_end
        ];
        $this->db->insert("activites_receive", $sql_data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $coupon["msg"] = "領取失敗，請稍後重試";
            return $coupon;
        } else {
            $coupon = [
                "status" => true,
                "msg" => "領取成功",
                "activites_receive" => $sql_data
            ];
            return $coupon;
        }
    }

    public function store_login($username, $password)
    {
        $login_status = [
            "status" => false,
            "msg" => "",
            "token" => "",
        ];
        if ($this->aauth->store_login($username, $password)) {

        } else {
            $errors = $this->aauth->get_errors_array();
            $login_status["msg"] = $errors;
            return $login_status;
        }

        if ($this->session->userdata('is_store') == 1) {
        } else {
            $login_status["msg"] = "身份錯誤";
            return $login_status;
        }
        $store_id = $this->session->userdata('id');

        $token = jwt_helper::create($store_id);
        $sql_data = [
            "app_token" => $token,
            "app_last_login" => date("Y-m-d H:i:s", time())
        ];
        $this->db->where("id", $store_id);
        if ($this->db->update("aauth_users", $sql_data)) {
            $login_status["status"] = true;
            $login_status["msg"] = "登入成功";
            $login_status["token"] = $token;
            return $login_status;
        } else {
            $login_status["msg"] = "無法存儲憑證";
            return $login_status;
        }
    }

    /**
     * app store登入驗證
     * @param $token
     * @return bool
     */
    public function check_token_store_login($token)
    {
        if (jwt_helper::validate($token)) {
            $jwt = jwt_helper::decode($token);
            if ($jwt) {
                if (isset($jwt->userId)) {
                    if ($this->get_model_in_fileds("aauth_users", ["app_token"], [$token])) {
                        $this->session->set_flashdata('app_store_user_id', $jwt->userId);
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            $jwt = jwt_helper::decode($token);
            if ($jwt) {
                if (isset($jwt->userId)) {
                    if ($this->get_model_in_fileds("aauth_users", ["app_token"], [$token])) {
                        return "updata_store_token";
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 拿取app store用戶id 必須配合check_token_login使用
     * @return mixed
     */
    public function get_app_store_user_id()
    {
        $user_id = $this->session->flashdata('app_store_user_id');
        return $user_id;
    }

    /**
     * 更新store token
     * @param $token
     * @return bool
     */
    public function update_store_token($token)
    {
        $jwt = jwt_helper::decode($token);
        if ($jwt) {
            if (isset($jwt->userId)) {
                $token = jwt_helper::create($jwt->userId);
                $sql_data = [
                    "app_token" => $token,
                    //"last_login" => date("Y-m-d H:i:s", time())
                ];
                $this->db->where("id", $jwt->userId);
                if ($this->db->update("aauth_users", $sql_data)) {
                    return $token;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        return false;
    }

    public function exchange_coupon($activites_receive, $store_id, $price)
    {
        //開啟事務
        $this->db->trans_start();

        $members = $this->get_model_in_id("members", $activites_receive->member_id);

        $sql_data = [
            "member_id" => $activites_receive->member_id,
            "activites_receive_id" => $activites_receive->id,
            "activites_id" => $activites_receive->activitie_id,
            "store_id" => $store_id,
            "amount" => $price,
            "created_at" => date("Y-m-d H:i:s", time()),
            "member_points" => ($price * 0.04),
            "status" => 1,
        ];
        if (isset($members) && isset($members->store_id)) {
            $sql_data["recommend_store_id"] = $members->store_id;
            $sql_data["store_points"] = ($price * 0.01);
        }
        $this->db->insert("transamounts", $sql_data);

        //反會員4%點數
        $this->db->set('points', 'points+' . ($price * 0.04), FALSE);
        $this->db->where("id", $activites_receive->member_id);
        $this->db->update("members");

        if ($members && isset($members->store_id) && $members->store_id > 0) {
            //反介紹商家1%點數
            $this->db->set('points', 'points+' . ($price * 0.01), FALSE);
            $this->db->where("id", $members->store_id);
            $this->db->update("aauth_users");
        }

        //更新我的優惠券使用狀態
        $sql_data = [
            "status" => 2,
            "exchange_datetime" => date("Y-m-d H:i:s", time())
            //"last_login" => date("Y-m-d H:i:s", time())
        ];
        $this->db->where("id", $activites_receive->id);
        $this->db->update("activites_receive", $sql_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function close_coupon($tran_model)
    {
        //開啟事務
        $this->db->trans_start();

        $sql_data = [
            "status" => 4,
            "updated_at" => date("Y-m-d H:i:s", time())
        ];
        if ($this->Data_helper_model->update_table_in_fileds(
            "transamounts",
            ["id"],
            [$tran_model->id],
            $sql_data
        )) {
            $members = $this->get_model_in_id("members", $tran_model->member_id);
            //反會員4%點數
            $this->db->set('points', 'points-' . $tran_model->member_points, FALSE);
            $this->db->where("id", $tran_model->member_id);
            $this->db->update("members");

            if ($members && isset($members->store_id) && $members->store_id > 0) {
                //反介紹商家1%點數
                $this->db->set('points', 'points-' . $tran_model->store_points, FALSE);
                $this->db->where("id", $members->store_id);
                $this->db->update("aauth_users");
            }
        } else {
            return false;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }
    /*
     * app登入
     */
    public function app_login($account,$password)
    {

        $this->db->group_start();
        $this->db->where('email', $account);
        $this->db->or_where('phone', $account);
        $this->db->group_end();
        $this->db->where('userpassword',md5($password));
        $query=$this->db->get('members');
        $res=$query->row();
//        var_dump($res);exit();
        if(!$res){
            return false;
        }else{
//            return $res;
            $token = jwt_helper::create($res->id);
            $sql_data = [
                "token" => $token,
                "last_login" => date("Y-m-d H:i:s", time())
            ];
            $this->db->where("id", $res->id);
            if ($this->db->update("members", $sql_data)) {
                $this->session->set_userdata(['id'=>$res->id]);
                return $res->id;
            } else {
                $this->logs->log("登入失敗，token無法保存資料庫：" . date("Y-m-d H:i:s", time()));
                return false;
            }
        }
    }

}