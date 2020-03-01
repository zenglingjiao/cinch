<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Members
 */
class Versions extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
    }



    /**
     * 版本編輯
     */
    public function versions_edit($id = 1)
    {
        if (IS_GET) {
            $data['open_versions'] = "open";
            $data['active_versions'] = "active";
//            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "版本資訊管理";
                $model = $this->Data_helper_model->get_model_in_id("version", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "version_number" => $model->version_number,
                        "create_date" => (isset($model->create_date)) ? $model->create_date : "",
                    ];
                    //$data['model'] = $model;
                    $this->load->view("back/Versions/versions_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Admin/index'));
                }
//            } else {
//                $data['title'] = "會員新增";
//                $this->load->view("back/Versions/versions_edit", $data);
//            }
        }
        if (IS_POST) {
            $errors = [];
            $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
            $version_number = mb_strlen(trim(isset($_POST['version_number']) ?: "")) == 0 ? "" : trim($_POST['version_number']);

            if ($version_number == "") {
                $errors[] = "版本編號不可為空";
            }
            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "version_number" => $version_number,
                    "create_date" => date("Y-m-d H:i:s", time())
                ];
                if ($this->Data_helper_model->update_table_in_fileds(
                    "version",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Versions/versions_edit'), null);
                } else {
                    get_csrf_nonce_keep();
                    return_post_json("err", "修改失敗或資料未變動", '', null);
                }
            } else {
                return_post_json("err", "參數錯誤", '', null);
            }
        }
    }


}