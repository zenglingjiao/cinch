<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Goods
 */
class Hot_film extends Admin_Controller
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
    public function hot_film_list()
    {
        if (IS_POST) {
//            return;
            $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
            $state = mb_strlen(trim(isset($_POST['state']) ?: "")) == 0 ? "" : trim($_POST['state']);
            $c_time = mb_strlen(trim(isset($_POST['c_time']) ?: "")) == 0 ? "" : trim($_POST['c_time']);
            $title = mb_strlen(trim(isset($_POST['title']) ?: "")) == 0 ? "" : trim($_POST['title']);
            $field = array(
                'hot_film.id',
                'hot_film.title',
                'hot_film.sort',
                'hot_film.url',
                'hot_film.created_at',
                'hot_film.state',
                'hot_film.updated_at'
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
                $this->db->where('hot_film.created_at >=', $c_time[0]);
                //日期必須小於加一天的。 有時間<=就好，不需要加一天。
                $this->db->where('hot_film.created_at <', date("Y-m-d", strtotime("+1 day", strtotime($c_time[1]))));
            }
            //$this->db->join("aauth_user_to_group", 'aauth_user_to_group.user_id = aauth_users.id and aauth_user_to_group.group_id !=3', 'left');
            //$this->db->join("aauth_groups", 'aauth_user_to_group.group_id = aauth_groups.id and aauth_groups.id !=3', 'left');

            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "hot_film");
            echo json_encode($data);
            //echo $this->db->last_query();
            exit;
        } else {
            $data['title'] = "熱門影音列表";
            $data['open_challenge'] = "open";
            $data['active_hot_film'] = "active";
            $data['h_title'] = "熱門影音管理";
            $data['edit'] = base_url('back/Hot_film/hot_film_edit/');
            $data['api_list'] = base_url('back/Hot_film/hot_film_list');
            $data['api_delete'] = base_url('back/Hot_film/hot_film_delete');
            $data['state'] = base_url('back/Hot_film/hot_film_state');
            $this->load->view("back/Hot_film/hot_film_list", $data);
        }
    }

    /**
     * 狀態標籤編輯
     */
    public function hot_film_edit($id = "")
    {
        if (IS_GET) {
            $data['open_challenge'] = "open";
            $data['active_hot_film'] = "active";
            $data['list'] = base_url('back/Hot_film/hot_film_list');
            $data['edit'] = base_url('back/Hot_film/hot_film_edit/');
            $data['list_title'] = "熱門影音列表";
            if (!empty($id)) {
                $id = (int)$id;
                $data['title'] = "熱門影音編輯";
                $model = $this->Data_helper_model->get_model_in_id("hot_film", $id);
                if (isset($model)) {
                    $data['model'] = [
                        "id" => $model->id,
                        "title" => $model->title,
                        "url" => $model->url,
                        "sort" => $model->sort,
                        "state" => $model->state,
                        "created_at" => (isset($model->created_at)) ? $model->created_at : "",
                    ];
//                    var_dump($data);exit();
                    //$data['model'] = $model;
                    $this->load->view("back/Hot_film/hot_film_edit", $data);
                } else {
                    return_get_msg("信息錯誤", base_url('back/Hot_film/hot_film_list'));
                }
            } else {
                $data['title'] = "新增熱門影音";
                $this->load->view("back/Hot_film/hot_film_edit", $data);
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
            $sort = mb_strlen(trim(isset($api_obj['sort']) ?: "")) == 0 ? "" : trim($api_obj['sort']);
            $state = mb_strlen(trim(isset($api_obj['state']) ?: "")) == 0 ? "" : trim($api_obj['state']);
            $url = mb_strlen(trim(isset($api_obj['url']) ?: "")) == 0 ? "" : trim($api_obj['url']);


            if ($title == "") {
                $errors[] = "標題不可為空";
            }
            if ($url == "") {
                $errors[] = "網址不可為空";
            }
            //上架限制為至多五筆
            if($state){
            	$count=$this->Data_helper_model->get_model_list_in_fileds("hot_film", ['state'], [1]);
	        	if(count($count) >= 5){
	                $errors[] = "上架限制為至多五筆";
	        	}
            }
            if (!empty($id)) {
                //
                if (!empty($errors)) {
                    $error = implode(", ", $errors);
                    return_post_json("err", $error, "", null);
                }
                $sql_data = [
                    "url" => $url,
                    "title" => $title,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0 ,
                    "updated_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->Data_helper_model->update_table_in_fileds(
                    "hot_film",
                    ["id"],
                    [$id],
                    $sql_data
                )) {
                    return_post_json("ok", "修改成功", base_url('back/Hot_film/hot_film_list'), null);
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
                    "url" => $url,
                    "title" => $title,
                    "sort" => $sort,
                    "state" => $state ? 1 : 0,
                    "created_at" => date("Y-m-d H:i:s", time())
                ];
                if ($this->db->insert("hot_film", $sql_data)) {
                    return_post_json("ok", "新增成功", base_url('back/Hot_film/hot_film_list'), null);
                } else {
                    return_post_json("err", "新增失敗", "", null);
                }
            }
        }
    }

    /**
     * 標籤管理狀態
     */
    public function hot_film_state()
    {
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        $field = mb_strlen(trim(isset($_POST['field']) ?: "")) == 0 ? "" : trim($_POST['field']);
        $value = mb_strlen(trim(isset($_POST['set']) ?: "")) == 0 ? "" : trim($_POST['set']);
        if ($id != "" && $field != "") {
        	if(!empty($value)){
	        	$count=$this->Data_helper_model->get_model_list_in_fileds("hot_film", [$field], [$value]);
	        	if(count($count) >= 5){
	                echo 2;
	                return;
	        	}
        	}
            if ($this->Data_helper_model->tabel_status($id, "hot_film", $field, $value)) {
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
    public function hot_film_delete()
    {
        $selectid = mb_strlen(trim(isset($_POST['selectid']) ?: "")) == 0 ? "" : trim($_POST['selectid']);
        if (!empty($selectid)) {
            $id_list = explode(",", $selectid);
            $is_ok = 0;
            $is_err = 0;
            foreach ($id_list as $val) {
                if ($this->Data_helper_model->del_model_in_id('hot_film', $val)) {
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
