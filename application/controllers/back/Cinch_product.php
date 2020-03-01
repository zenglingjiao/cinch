<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Cinch_product extends Admin_Controller
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
    public function cinch_product_list()
    {
        if (IS_POST) {
//            return;
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field = array(
                'cinch_product.id',
                'cinch_product.sort',
                'cinch_product.imgs',
                'cinch_product.classify',
                'cinch_product.product_name',
                'cinch_product.created_at',
                'cinch_product.state',
                'cinch_product.updated_at'
            );

            $this->db->select($field);
            if ($title != "") {
                $this->db->group_start();
                $this->db->like('title', $title);
                $this->db->group_end();


            }
            if ($state != "") {
                $this->db->where('state', $state);
            }

            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('cinch_product.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('cinch_product.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "cinch_product");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "纖奇產品列表";
            $data['open_cinch_product'] = "open";
            $data['active_cinch_product'] = "active";
            $data['h_title'] = "纖奇產品管理";
            $data['edit'] = base_url('back/Cinch_product/cinch_product_edit/');
            $data['api_list'] = base_url('back/Cinch_product/cinch_product_list');
            $data['api_delete'] = base_url('back/Cinch_product/cinch_product_delete');
            $data['state'] = base_url('back/Cinch_product/cinch_product_state');
            $this->load->view("back/Cinch_product/cinch_product_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function cinch_product_edit($id = "")
    {
        if (IS_GET) {
            $data['open_cinch_product'] = "open";
            $data['active_cinch_product'] = "active";
            $data['list'] = base_url('back/Cinch_product/cinch_product_list');
            $data['edit'] = base_url('back/Cinch_product/cinch_product_edit/');
            $data['list_title'] = "纖奇產品列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "纖奇產品編輯";
                $model = $this->Data_helper_model->get_model_in_id("cinch_product", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "classify" => $model->classify,
                        "product_name" => $model->product_name,
                        "subhead" => $model->subhead,
                        "crosshead1" => $model->crosshead1,
                        "content1" => $model->content1,
                        "crosshead2" => $model->crosshead2,
                        "content2" => $model->content2,
                        "crosshead3" => $model->crosshead3,
                        "content3" => $model->content3,
                        "product_url" => $model->product_url,
                        "shop_url" => $model->shop_url,
                        "sort" => $model->sort,
                        "imgs" => $model->imgs,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Cinch_product/cinch_product_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Cinch_product/cinch_product_list'));
                }
            } else {
                $data['title'] = "新增纖奇產品";
                $this->load->view("back/Cinch_product/cinch_product_edit", $data);
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
            $product_name = mb_strlen(trim(isset($api_obj['product_name']) ?: "")) == 0 ? "" : trim($api_obj['product_name']);
            $subhead = mb_strlen(trim(isset($api_obj['subhead']) ?: "")) == 0 ? "" : trim($api_obj['subhead']);
            $crosshead1 = mb_strlen(trim(isset($api_obj['crosshead1']) ?: "")) == 0 ? "" : trim($api_obj['crosshead1']);
            $content1 = mb_strlen(trim(isset($api_obj['content1']) ?: "")) == 0 ? "" : trim($api_obj['content1']);
            $crosshead2 = mb_strlen(trim(isset($api_obj['crosshead2']) ?: "")) == 0 ? "" : trim($api_obj['crosshead2']);
            $content2 = mb_strlen(trim(isset($api_obj['content2']) ?: "")) == 0 ? "" : trim($api_obj['content2']);
            $crosshead3 = mb_strlen(trim(isset($api_obj['crosshead3']) ?: "")) == 0 ? "" : trim($api_obj['crosshead3']);
            $content3 = mb_strlen(trim(isset($api_obj['content3']) ?: "")) == 0 ? "" : trim($api_obj['content3']);
            $sort = mb_strlen(trim(isset($api_obj['sort']) ?: "")) == 0 ? "" : trim($api_obj['sort']);
            $product_url = mb_strlen(trim(isset($api_obj['product_url']) ?: "")) == 0 ? "" : trim($api_obj['product_url']);
            $shop_url = mb_strlen(trim(isset($api_obj['shop_url']) ?: "")) == 0 ? "" : trim($api_obj['shop_url']);
            $state = mb_strlen(trim(isset($api_obj['state']) ?: "")) == 0 ? "" : trim($api_obj['state']);
            $classify = mb_strlen(trim(isset($api_obj['classify']) ?: "")) == 0 ? "" : trim($api_obj['classify']);


            // if ($title == "") {
            //     $errors[] = "標題不可為空";
            // }
            // if ($content == "") {
            //     $errors[] = "內容不可為空";
            // }
            // if ($integral == "") {
            //     $errors[] = "積分不可為空";
            // }
            // if ($activities_time == "") {
            //     $errors[] = "活動時間不可為空";
            // }
            $up_img_src = "";
            if (isset($_FILES) && count($_FILES) > 0) {
                $this->load->library("Custom_upload");
                foreach ($_FILES as $k => $file) {
                    if (isset($file['name'])) {
                        $path = "updata/Cinch_product/" . date("Y-m", time());
                        $up_img_file_name = $this->custom_upload->single_upload($k, date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "jpeg|jpg|gif|png"]);
                        if ($up_img_file_name) {
                            $up_img_src = $path . "/" . $up_img_file_name;
                        }
                    }
                }
            }
            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "classify" => $classify,
                    "product_name" => $product_name,
                    "subhead" => $subhead,
                    "crosshead1" => $crosshead1,
                    "content1" => $content1,
                    "crosshead2" => $crosshead2,
                    "content2" => $content2,
                    "crosshead3" => $crosshead3,
                    "content3" => $content3,
                    "sort" => $sort,
                    "product_url" => $product_url,
                    "shop_url" => $shop_url,
                    "state" => $state ? 1 : 0 ,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($up_img_src != "") {
                    $sql_data["imgs"] = $up_img_src;
                } else if (empty($api_obj['imgs'])) {
                    $sql_data["imgs"] = "";
                }
                if ($this->Data_helper_model->update_table_in_fileds(
                    "cinch_product",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Cinch_product/cinch_product_list'), null);
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
                    "classify" => $classify,
                    "product_name" => $product_name,
                    "subhead" => $subhead,
                    "crosshead1" => $crosshead1,
                    "content1" => $content1,
                    "crosshead2" => $crosshead2,
                    "content2" => $content2,
                    "crosshead3" => $crosshead3,
                    "content3" => $content3,
                    "sort" => $sort,
                    "product_url" => $product_url,
                    "shop_url" => $shop_url,
                    "imgs" => $up_img_src,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("cinch_product", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Cinch_product/cinch_product_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function cinch_product_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
            if ($this->Data_helper_model->tabel_status($id, "cinch_product", $field, $value)) {
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
    public function cinch_product_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('cinch_product', $val)) {
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