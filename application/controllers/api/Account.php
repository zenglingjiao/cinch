<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Account
 */
class Account extends App_Controller
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
            $platform = mb_strlen(trim(isset($_POST['platform']) ?: "")) == 0 ? "" : trim($_POST['platform']);
            $platform_id = mb_strlen(trim(isset($_POST['platform_id']) ?: "")) == 0 ? "" : trim($_POST['platform_id']);
            $store_id = mb_strlen(trim(isset($_POST['store_id']) ?: "")) == 0 ? "" : trim($_POST['store_id']);
            if ($platform != "" && $platform_id != "") {
                $token = $this->Data_helper_model->third_login($platform, $platform_id, $store_id);
                if ($token == false) {
                    return_app_json("101", "登入失敗，無法創建憑證", []);
                } else {
                    return_app_json("200", "登入成功", $token);
                }
            } else {
                return_app_json("101", "登入失敗，未獲取到相關憑證參數", []);
            }
        } else {
            return_get_msg("Get", "");
        }
    }

    //登入
    public function login_new()
    {

        if (IS_POST) {
            $account = mb_strlen(trim(isset($_POST['account']) ?: "")) == 0 ? "" : trim($_POST['account']);
            $password = mb_strlen(trim(isset($_POST['password']) ?: "")) == 0 ? "" : trim($_POST['password']);
            if ($account != "" && $password != "") {
                $is_true=0;
                //驗證電話號碼
                $pattern='/^[0][9]\d{8}$/';
                if(preg_match($pattern, $account)){
                    $is_true=1;
                }
                //驗證郵箱
                if(preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $account)){
                    $is_true=1;
                }
                //驗證是否通過
                if($is_true==0){
                    return_app_json("104", "手機號碼無法登入，應為09開頭的十碼數字", []);
                }
                //提示
                $this->db->group_start();
                $this->db->where('email', $account);
                $this->db->or_where('phone', $account);
                $this->db->group_end();
                $query=$this->db->get('members');
                $res1=$query->row();
                if(!$res1){
                    return_app_json("104", '請輸入正確的帳號', []);
                }
                if($res1->userpassword != md5($password)){
                    return_app_json("104", '密碼錯誤', []);
                }

                $res = $this->Data_helper_model->app_login($account, $password);
                if ($res == false) {
                    return_app_json("101", '登入失敗，無法創建憑證', []);
                } else {

                    //返回个人信息
                    $field = array(
                        'members.id',
                        'members.third_login',
                        'members.hash_key',
                        'members.nick_name',
                        'members.user_head',
                        'members.registration_id',
                        'members.push',
                        'members.lev',
                        'members.created_at',
                        'members.last_login',
                        'members.deleted_at',
                        'members.updated_at',
                        'members.token',
                        'members.sex',
                        'members.phone',
                        'members.birthday',
                        'members.email',
                        'members.address',
                        'members.integral',
                        'members.userpassword',
                        'members.hobby',
                        'user_ratings.title',
                        'user_ratings.content',
                        'user_ratings.imgs',
                    );
                    $this->db->select($field);
                    $this->db->join("user_ratings", 'members.lev=user_ratings.id', 'left');
                    $this->db->where('members.id',$res);
                    $query=$this->db->get('members');
                    $data=$query->row();
//                    $data = $this->Data_helper_model->get_model_in_id('members', $res);
                    return_app_json("200", '登入成功', $data);
                }
            } else {
                return_app_json("101", "登入失敗，未獲取到相關憑證參數", []);
            }
        } else {
            return_get_msg("Get", "");
        }

    }
    //设置RegistrationID
    public function set_regid()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $regId = mb_strlen(trim(isset($_POST['regId']) ?: "")) == 0 ? "" : trim($_POST['regId']);
        if ($user_model) {
            $this->Data_helper_model->update_table_in_fileds(
                "members",
                ["registration_id"],
                [$regId],
                ['registration_id'=>'']
            );
            $sql_data=[
                'registration_id'=>$regId,
            ];

            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return_app_json("200", "修改成功", []);
            } else {
                return_app_json("104", "失敗或資料未變動", []);
            }

        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //驗證
    public function verify()
    {

        if (IS_POST) {
            $phone = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
            $code = mb_strlen(trim(isset($_POST['code']) ?: "")) == 0 ? "" : trim($_POST['code']);

            if ($phone != "" && $code != "") {
                $phone+=0;
                $phone='0'.$phone;
                $res = $this->Data_helper_model->get_model_in_filed_orderby("verify", "phone", $phone, 'id', 'desc');
                if ($res->code != $code) {
                    return_app_json("104", "驗證碼錯誤", []);
                }
                if ($res->stale_time < date('Y-m-d H:i:s')) {
                    return_app_json("104", "驗證碼過期，請重新發送", []);
                }
                return_app_json("200", "驗證成功", ['token' => $res->token]);
            } else {
                return_app_json("101", "註冊失敗，未獲取到相關憑證參數", []);
            }
        } else {
            return_get_msg("Get", "");
        }

    }

    //發送驗證碼
    public function send_code()
    {
        if (IS_POST) {
            $phone = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
            $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
            
            if ($phone != "" && $type != "") {

                //转成整数去掉前面的0
                $phone+=0;
                //验证格式
                $pattern='/^[9]\d{8}$/';
                if(preg_match($pattern, $phone)){

                }else{
                    return_app_json("104", "電話號碼格式錯誤", []);
                }
                //通过验证后在前面加个0
                $phone='0'.$phone;
                if ($type == 'register') {
                    if ($this->Data_helper_model->get_model_in_fileds("members", ["phone"], [$phone])) {
                        return_app_json("104", "電話號碼已被註冊", []);
                    }
                } else {
                    if ($this->Data_helper_model->get_model_in_fileds("members", ["phone"], [$phone])) {
                    } else {
                        return_app_json("104", "電話號碼未註冊，請先註冊", []);
                    }
                }
                $code = rand(1000, 9999);

                $sql_data = [
                    'code' => $code,
                    'phone' => $phone,
                    'token' => jwt_helper::create($phone),
                    'stale_time' => date('Y-m-d H:i:s', time() + 600)
                ];
                if ($this->db->insert('verify', $sql_data)) {
                    return_app_json("200", "發送成功，請立即收取手機驗證碼進行下一步", ['code' => $code]);
                } else {
                    return_app_json("104", "發送失敗", []);
                }
            } else {
                return_app_json("101", "發送失敗，未獲取到相關憑證參數", []);
            }
        } else {
            return_get_msg("Get", "");
        }

    }

    //註冊
    public function register()
    {

        if (IS_POST) {
            //驗證token
            $token = $this->input->get_request_header('token', true);
            $phone = '';
            if (jwt_helper::validate($token)) {
                $jwt = jwt_helper::decode($token);
                if ($jwt) {
                    if (isset($jwt->userId)) {
                        $phone = $jwt->userId;
                    }
                }
            } else {
            }
            $email = mb_strlen(trim(isset($_POST['email']) ?: "")) == 0 ? "" : trim($_POST['email']);
            $nick_name = mb_strlen(trim(isset($_POST['nick_name']) ?: "")) == 0 ? "" : trim($_POST['nick_name']);
            $user_head = mb_strlen(trim(isset($_POST['user_head']) ?: "")) == 0 ? "" : trim($_POST['user_head']);
            $password = mb_strlen(trim(isset($_POST['password']) ?: "")) == 0 ? "" : trim($_POST['password']);
            $repassword = mb_strlen(trim(isset($_POST['repassword']) ?: "")) == 0 ? "" : trim($_POST['repassword']);
            $hobby = mb_strlen(trim(isset($_POST['hobby']) ?: "")) == 0 ? "" : trim($_POST['hobby']);
            if (empty($email) || empty($nick_name) || empty($user_head) || empty($password) || empty($repassword)
                || empty($hobby) || empty($phone)) {
                return_app_json("104", "未獲取到相關憑證參數", []);
            }
            if ($password != $repassword) {
                return_app_json("104", "兩次密碼不一致", []);
            }
            $pattern='/^[0][9]\d{8}$/';
            if(preg_match($pattern, $phone)){

            }else{
                return_app_json("104", "電話號碼格式錯誤", []);
            }
            if ($this->Data_helper_model->get_model_in_fileds("members", ["phone"], [$phone])) {
                return_app_json("104", "電話號碼已被註冊", []);
            }
            if ($this->Data_helper_model->get_model_in_fileds("members", ["email"], [$email])) {
                return_app_json("104", "郵箱已被註冊", []);
            }
            $sql_data = [
                'email' => $email,
                'nick_name' => $nick_name,
                'user_head' => $user_head,
                'userpassword' => md5($password),
                'hobby' => $hobby,
                'phone' => $phone,
                'created_at' => date('Y-m-d H:i:s', time()),

            ];
            if ($this->db->insert("members", $sql_data)) {
                return_app_json("200", "註冊成功", []);
            } else {
                return_app_json("104", "註冊失敗", []);
            }

        } else {
            return_get_msg("Get", "");
        }

    }

    //修改密碼
    public function update_password()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $oldpassword = mb_strlen(trim(isset($_POST['oldpassword']) ?: "")) == 0 ? "" : trim($_POST['oldpassword']);
        $password = mb_strlen(trim(isset($_POST['password']) ?: "")) == 0 ? "" : trim($_POST['password']);
        $repassword = mb_strlen(trim(isset($_POST['repassword']) ?: "")) == 0 ? "" : trim($_POST['repassword']);
        if (empty($password) || empty($repassword) || empty($oldpassword)) {
            return_app_json("104", "資料輸入有誤請重新輸入", []);
        }
        if ($password != $repassword) {
            return_app_json("104", "兩次密碼不一致", []);
        }
        if ($user_model->userpassword != md5($oldpassword)) {
            return_app_json("104", "資料輸入有誤請重新輸入", []);
        }
        if ($user_model) {
            $sql_data = [
                'userpassword' => md5($password),
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return_app_json("200", "修改成功", []);
            } else {
                return_app_json("104", "失敗或資料未變動", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //找回密碼
    public function retrieve_password()
    {
        //驗證token
        $token = $this->input->get_request_header('token', true);
        $phone = '';
        if (jwt_helper::validate($token)) {
            $jwt = jwt_helper::decode($token);
            if ($jwt) {
                if (isset($jwt->userId)) {
                    $phone = $jwt->userId;
                }
            }
        } else {
        }
        $user_model = $this->Data_helper_model->get_model_in_fileds("members", ["phone"], [$phone]);
        $password = mb_strlen(trim(isset($_POST['password']) ?: "")) == 0 ? "" : trim($_POST['password']);
        $repassword = mb_strlen(trim(isset($_POST['repassword']) ?: "")) == 0 ? "" : trim($_POST['repassword']);
        if (empty($password) || empty($repassword)) {
            return_app_json("104", "資料輸入有誤請重新輸入", []);
        }
        if ($password != $repassword) {
            return_app_json("104", "兩次密碼不一致", []);
        }
        if ($user_model) {
            $sql_data = [
                'userpassword' => md5($password),
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_model->id],
                $sql_data
            )) {
                return_app_json("200", "修改成功", []);
            } else {
                return_app_json("104", "失敗或資料未變動", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    /**
     * 獲取會員信息
     */
    public function get_user_info()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $field = array(
                'members.id',
                'members.nick_name',
                'members.user_head',
                'members.lev',
                'members.created_at',
                'members.token',
                'members.phone',
                'members.email',
                'members.address',
                'members.integral',
                'members.hobby',
                'user_ratings.imgs',
                'user_ratings.title',
                'user_ratings.content',
            );
            $this->db->select($field);
            $this->db->join("user_ratings", 'user_ratings.id = members.lev', 'left');
            $this->db->where('members.id',$user_id);
            $query=$this->db->get('members');
            $data=$query->row_array();
            //積分記錄是1得到扣除2上傳增加
            $sql='select if(a.created_at<b.created_at,b.created_at,a.created_at) as maxcread,IF(up_user=?,2,1)as trade_type  from 
            goods a LEFT JOIN orders b on a.id=b.goods_id where up_user=? or member_account=? ORDER BY maxcread desc';
            $query=$this->db->query($sql,array($data['phone'],$data['phone'],$data['phone']));
//            var_dump($this->db->last_query());exit();
            $data['trade_record']=$query->result_array();
            $data['next_lev']=$this->Data_helper_model->get_model_in_fileds('user_ratings',['id'],[$data['lev']+1]);
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    /**
     * 設置用戶信息
     */
    public function set_user_info()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $email = mb_strlen(trim(isset($_POST['email']) ?: "")) == 0 ? "" : trim($_POST['email']);
        $address = mb_strlen(trim(isset($_POST['address']) ?: "")) == 0 ? "" : trim($_POST['address']);
        $phone = mb_strlen(trim(isset($_POST['phone']) ?: "")) == 0 ? "" : trim($_POST['phone']);
        $user_head = mb_strlen(trim(isset($_POST['user_head']) ?: "")) == 0 ? "" : trim($_POST['user_head']);
        if (empty($email)) {
            return return_app_json("104", "E-mail空白或錯誤請檢查@或重新輸入", []);
        }
        if (empty($phone)) {
            return return_app_json("104", "聯絡電話空白或錯誤請檢查並重新輸入", []);
        }
        if (empty($address)) {
            return return_app_json("104", "通訊地址錯誤請檢查並重新輸入", []);
        }
        if ($this->Data_helper_model->get_model_in_fileds("members", ["phone",'id !='], [$phone,$user_id])) {
            return_app_json("104", "電話號碼已存在", []);
        }
        if ($this->Data_helper_model->get_model_in_fileds("members", ["email","id !="], [$email,$user_id])) {
            return_app_json("104", "郵箱已存在", []);
        }
        if ($user_model) {
            $sql_data = [
                "email" => $email,
                "address" => $address,
                "phone" => $phone,
                "user_head" => $user_head,
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return return_app_json("200", "设置成功", []);
            } else {
                return return_app_json("104", "设置失敗", []);
            }

        } else {
            return return_app_json("102", "设置失敗", []);
        }
    }

    /**
     * 編輯分類
     */
    public function set_hobby()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $hobby = mb_strlen(trim(isset($_POST['hobby']) ?: "")) == 0 ? "" : trim($_POST['hobby']);
        if (empty($hobby)) {
            return return_app_json("104", "必須選擇一項", []);
        }
        if ($user_model) {
            $sql_data = [
                "hobby" => $hobby,
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return return_app_json("200", "设置成功", []);
            } else {
                return return_app_json("104", "设置失敗", []);
            }

        } else {
            return return_app_json("102", "设置失敗", []);
        }
    }

    /**
     * 退出用戶
     */
    public function logout()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $sql_data = [
                "token" => '',
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
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

    //上传物品
    public function upload_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        $pic = mb_strlen(trim(isset($_POST['pic']) ?: "")) == 0 ? "" : trim($_POST['pic']);
        $goods_type_id = mb_strlen(trim(isset($_POST['goods_type_id']) ?: "")) == 0 ? "" : trim($_POST['goods_type_id']);
        $purchase_way = mb_strlen(trim(isset($_POST['purchase_way']) ?: "")) == 0 ? "" : trim($_POST['purchase_way']);
        $m_place = mb_strlen(trim(isset($_POST['m_place']) ?: "")) == 0 ? "" : trim($_POST['m_place']);
        $use_number = mb_strlen(trim(isset($_POST['use_number']) ?: "")) == 0 ? "" : trim($_POST['use_number']);
        $storage_titme = mb_strlen(trim(isset($_POST['storage_titme']) ?: "")) == 0 ? "" : trim($_POST['storage_titme']);
        $storage_titme_units = mb_strlen(trim(isset($_POST['storage_titme_units']) ?: "")) == 0 ? "" : trim($_POST['storage_titme_units']);
        $state_label = mb_strlen(trim(isset($_POST['state_label']) ?: "")) == 0 ? "" : trim($_POST['state_label']);
        $custom_label = mb_strlen(trim(isset($_POST['custom_label']) ?: "")) == 0 ? "" : trim($_POST['custom_label']);
        $freight_pt = mb_strlen(trim(isset($_POST['freight_pt']) ?: "")) == 0 ? "" : trim($_POST['freight_pt']);
        $freight = mb_strlen(trim(isset($_POST['freight']) ?: "")) == 0 ? "" : trim($_POST['freight']);
        if (empty($freight_pt)) {
            return return_app_json("104", "必須選擇一項", []);
        }
        if($this->Data_helper_model->get_model_in_fileds('goods',['name'],[$name])){
            return return_app_json("104", "物品名已存在", []);
        }
        if ($user_model) {
            $sql_data = [
                "name" => $name,
                'up_user'=>$user_model->phone,
                "pic" => $pic,
                "goods_type_id" => $goods_type_id,
                "purchase_way" => $purchase_way,
                "m_place" => $m_place,
                "use_number" => $use_number,
                "storage_titme" => $storage_titme,
                "storage_titme_units" => $storage_titme_units,
                "state_label" => $state_label,
                "custom_label" => $custom_label,
                "freight" => $freight,
                "freight_pt" => $freight_pt,
                "status" => 1,
                "created_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->db->insert("goods", $sql_data)) {
                //上传成功，积分加十
                $this->db->set('integral','integral+10',false);
                $this->db->where('phone',$user_model->phone);
                $this->db->update('members');
                return_app_json("200", "上傳成功", []);
            } else {
                return_app_json("104", "上傳失敗", []);
            }


        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //修改上架物品
    public function update_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        $pic = mb_strlen(trim(isset($_POST['pic']) ?: "")) == 0 ? "" : trim($_POST['pic']);
        $goods_type_id = mb_strlen(trim(isset($_POST['goods_type_id']) ?: "")) == 0 ? "" : trim($_POST['goods_type_id']);
        $purchase_way = mb_strlen(trim(isset($_POST['purchase_way']) ?: "")) == 0 ? "" : trim($_POST['purchase_way']);
        $m_place = mb_strlen(trim(isset($_POST['m_place']) ?: "")) == 0 ? "" : trim($_POST['m_place']);
        $use_number = mb_strlen(trim(isset($_POST['use_number']) ?: "")) == 0 ? "" : trim($_POST['use_number']);
        $storage_titme = mb_strlen(trim(isset($_POST['storage_titme']) ?: "")) == 0 ? "" : trim($_POST['storage_titme']);
        $storage_titme_units = mb_strlen(trim(isset($_POST['storage_titme_units']) ?: "")) == 0 ? "" : trim($_POST['storage_titme_units']);
        $state_label = mb_strlen(trim(isset($_POST['state_label']) ?: "")) == 0 ? "" : trim($_POST['state_label']);
        $custom_label = mb_strlen(trim(isset($_POST['custom_label']) ?: "")) == 0 ? "" : trim($_POST['custom_label']);
        $freight_pt = mb_strlen(trim(isset($_POST['freight_pt']) ?: "")) == 0 ? "" : trim($_POST['freight_pt']);
        $freight = mb_strlen(trim(isset($_POST['freight']) ?: "")) == 0 ? "" : trim($_POST['freight']);
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);

        if (empty($freight_pt)) {
            return return_app_json("104", "必須選擇一項", []);
        }
        if($this->Data_helper_model->get_model_in_fileds('goods',['name','id !='],[$name,$id])){
            return return_app_json("104", "物品名已存在", []);
        }
        if ($user_model) {
            if(!$this->Data_helper_model->get_model_in_fileds('goods',['up_user','id'],[$user_model->phone,$id])){
                return return_app_json("104", "用戶信息錯誤！", []);
            }
            $sql_data = [
                "name" => $name,
                'up_user'=>$user_model->phone,
                "pic" => $pic,
                "goods_type_id" => $goods_type_id,
                "purchase_way" => $purchase_way,
                "m_place" => $m_place,
                "use_number" => $use_number,
                "storage_titme" => $storage_titme,
                "storage_titme_units" => $storage_titme_units,
                "state_label" => $state_label,
                "custom_label" => $custom_label,
                "freight" => $freight,
                "freight_pt" => $freight_pt,
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "goods",
                ["id"],
                [$id],
                $sql_data
            )) {
                return_app_json("200", "修改成功", []);

            } else {
                return_app_json("104", "修改失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //发送短信
    /*
     * $received接收人手机号码
     * $smsbody发送内容
     */
    public function sendSMS($received,$smsbody='')
    {
        $username = '82310587';
        $password = 'gift_economy000';
//        $smbody = "收到请回复";
        $smbody = mb_convert_encoding($smsbody, "BIG5", "UTF-8");

        $Data = array(
            "username" =>$username, //三竹帳號
            "password" => $password, //三竹密碼
            "dstaddr" => $received, //客戶手機
            "DestName" => '客戶', //對客戶的稱謂 於三竹後台看的時候用的
            "smbody" =>$smbody, //簡訊內容

        );
        $dataString = http_build_query($Data);
        $url = "http://smexpress.mitake.com.tw:9600/SmSendGet.asp?".$dataString;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function testfs()
    {
        $data=$this->sendSMS('0987303820','验证短信，不用管');
//        $data= preg_split('/[\r\n]+/s', $data);
        return return_app_json("102", "獲取失敗", $data);

    }
    public function test()
    {
        //var_dump(jwt_helper::create("fffff"));
//exit;

        $token = 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiJmZmZmZiIsImlzc3VlZEF0IjoiMjAxOS0xMC0wOVQxMjowMzo0MSswODAwIiwidHRsIjo0MzIwMDB9.Utnv0aswzaDeyfMkcL5tbSbuFxmSI2wEa0nh_iDdk0U';
        var_dump(jwt_helper::decode($token));

        echo "--------------------";

        var_dump(jwt_helper::validate($token));
        exit;
    }

    public function test2()
    {
        echo $this->Data_helper_model->get_app_user_id();
    }
}