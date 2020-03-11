<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Proposition extends Admin_Controller
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
    public function proposition_list()
    {
        if (IS_POST) {
//            return;
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
            $field = array(
                'proposition.id',
                'proposition.title',
                'proposition.sort',
                'proposition.imgs',
                'proposition.type',
                'proposition.created_at',
                'proposition.state',
                'proposition.updated_at'
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
            if ($type != "") {
                $this->db->where('type', $type);
            }
            if ($c_time != "") {
                $c_time = explode("~", $c_time);
                $this->db->where('proposition.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('proposition.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "proposition");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "兌換活動列表";
            $data['open_home'] = "open";
            $data['active_proposition'] = "active";
            $data['h_title'] = "兌換活動管理";
            $data['edit'] = base_url('back/Proposition/proposition_edit/');
            $data['api_list'] = base_url('back/Proposition/proposition_list');
            $data['api_delete'] = base_url('back/Proposition/proposition_delete');
            $data['state'] = base_url('back/Proposition/proposition_state');
            $this->load->view("back/Proposition/proposition_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function proposition_edit($id = "")
    {
        if (IS_GET) {
            $data['open_home'] = "open";
            $data['active_proposition'] = "active";
            $data['list'] = base_url('back/Proposition/proposition_list');
            $data['edit'] = base_url('back/Proposition/proposition_edit/');
            $data['list_title'] = "兌換活動列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "兌換活動編輯";
                $model = $this->Data_helper_model->get_model_in_id("proposition", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "title" => $model->title,
                        "content" => $model->content,
                        "type" => $model->type,
                        "sort" => $model->sort,
                        "imgs" => $model->imgs,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Proposition/proposition_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Proposition/proposition_list'));
                }
            } else {
                $data['title'] = "新增兌換活動";
                $this->load->view("back/Proposition/proposition_edit", $data);
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
            $title = mb_strlen(trim(isset($api_obj['title']) ?: "")) == 0 ? "" : trim($api_obj['title']);
            $content = mb_strlen(trim(isset($api_obj['content']) ?: "")) == 0 ? "" : trim($api_obj['content']);
            $sort = mb_strlen(trim(isset($api_obj['sort']) ?: "")) == 0 ? "" : trim($api_obj['sort']);
            $state = mb_strlen(trim(isset($api_obj['state']) ?: "")) == 0 ? "" : trim($api_obj['state']);
            $type = mb_strlen(trim(isset($api_obj['type']) ?: "")) == 0 ? "" : trim($api_obj['type']);

            if($type==2){
                if ($title == "") {
                    $errors[] = "標題不可為空";
                }
                if ($content == "") {
                    $errors[] = "內容不可為空";
                }
                //狀態不為0時
	            if($state){
	            	$count=$this->Data_helper_model->get_model_list_in_fileds("proposition", ['state','type'], [1,2]);
		        	if(count($count) >= 1){
		                $errors[] = "文字最多上架一筆";
		        	}
	            }
            }else{
            	//狀態不為0時
	            if($state){
	            	$count=$this->Data_helper_model->get_model_list_in_fileds("proposition", ['state','type'], [1,1]);
		        	if(count($count) >= 3){
		                $errors[] = "圖片最多上架三筆";
		        	}
	            }
            }

            $up_img_src = "";
            if (isset($_FILES) && count($_FILES) > 0) {
                $this->load->library("Custom_upload");
                foreach ($_FILES as $k => $file) {
                    if (isset($file['name'])) {
                        $path = "updata/Proposition/" . date("Y-m", time());
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
                    "content" => $content,
                    "title" => $title,
                    "type" => $type,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0 ,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];

                if ($up_img_src != "") {
                    $sql_data["imgs"] = $up_img_src;
                } else if (empty($api_obj['imgs'])) {
                    $sql_data["imgs"] = "";
                }

                if ($this->Data_helper_model->update_table_in_fileds(
                    "proposition",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Proposition/proposition_list'), null);
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
                    "type" => $type,
                    "title" => $title,
                    "imgs" => $up_img_src,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("proposition", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Proposition/proposition_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function proposition_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
        	$model = $this->Data_helper_model->get_model_in_id("proposition", $id);
        	if(!empty($value)){
	        	//1圖片2文字
	        	if($model->type==2){
	        		$count=$this->Data_helper_model->get_model_list_in_fileds("proposition", ['state','type'], [1,2]);
		        	if(count($count) >= 1){
		                echo 2;
                		return;
		        	}
	        	}else{
	        		$count=$this->Data_helper_model->get_model_list_in_fileds("proposition", ['state','type'], [1,1]);
		        	if(count($count) >= 3){
		                echo 3;
                		return;
		        	}
	        	}
	        }
            if ($this->Data_helper_model->tabel_status($id, "proposition", $field, $value)) {
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
    public function proposition_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('proposition', $val)) {
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
