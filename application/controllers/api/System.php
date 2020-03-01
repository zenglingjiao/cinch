<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class System
 */
class System extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code 請查看core/my_controller.php 配置
        $this->load->library("Uuid");
        $this->load->library("logs");
        $this->load->library("Jpush");

    }

    /**
     * 上傳圖像
     */
    public function file_upload_user_head()
    {
        $this->load->library("Custom_upload");
        $user_id = $this->Data_helper_model->get_app_user_id();
        $path = "updata/user_head/" . date("Y-m", time());
        $up_img_file_name = $this->custom_upload->single_upload("file", date("YmdHis", time()) . "_" . $user_id, ["upload_path" => $path, "allowed_types" => "jpeg|jpg|png|bmp"]);
        if ($up_img_file_name) {
            $sql_data = [
                "user_head" => $path . "/" . $up_img_file_name,
                "updated_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->Data_helper_model->update_table_in_fileds(
                "members",
                ["id"],
                [$user_id],
                $sql_data
            )) {
                return return_app_json("200", "上傳成功", [
                    'urls' => $path . "/" . $up_img_file_name,
                ]);
            } else {
                return return_app_json("118", "上傳失敗", []);
            }
        }
        return return_app_json("118", "上傳失敗", []);
    }

    /*
     * 上傳文件
     * $type 上傳類別
     * $file_name 上傳參數名
     */
    private function file_upload($type, $file_name)
    {
        $this->load->library("Custom_upload");
        $path = "updata/" . $type . "/" . date("Y-m", time());
        $up_img_file_name = $this->custom_upload->single_upload($file_name, date("YmdHis", time()), ["upload_path" => $path, "allowed_types" => "jpeg|jpg|png|bmp"]);
        if ($up_img_file_name) {
            return $path . "/" . $up_img_file_name;
        } else {
            return false;
        }

    }

    //上傳圖片
    public function upload_picture()
    {
        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        if (empty($type)) {
            return_app_json('104', '參數錯誤', []);
        }

        $res = $this->file_upload($type, 'file');
        if ($res) {
            return_app_json('200', '上傳成功', ['path' => $res]);
        } else {
            return_app_json("118", '上傳失敗', []);
        }
    }

    //常見問題
    public function get_faq()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        if ($user_model) {
            $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('faq', ['type', 'state'], [$type, 1], 'sort', 'desc');
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //兌換活動
    public function get_activities()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('exchange_activities', ['activities_time_end >', 'state'], [date('Y-m-d H:i:s'), 1], 'sort', 'desc');
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //提交評價
    public function sub_evaluate()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        $matter = mb_strlen(trim(isset($_POST['matter']) ?: "")) == 0 ? "" : trim($_POST['matter']);
        $content = mb_strlen(trim(isset($_POST['content']) ?: "")) == 0 ? "" : trim($_POST['content']);
        if ($user_model) {
            $res=$this->Data_helper_model->get_model_in_fileds('orders',['goods_id'],[$goods_id]);
//            var_dump($res);exit();
            if(!$res){
                return_app_json("104", "查無此訂單", []);
            }
            $sql_data = [
                "order_id" => $res->id,
                "matter" => $matter,
                "content" => $content,
                "created_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->db->insert("evaluate", $sql_data)) {
                return_app_json("200", "提交成功", []);
            } else {
                return_app_json("104", "提交失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //提交檢舉
    public function sub_impeach()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        $content = mb_strlen(trim(isset($_POST['content']) ?: "")) == 0 ? "" : trim($_POST['content']);
        $submit_at = mb_strlen(trim(isset($_POST['submit_at']) ?: "")) == 0 ? "" : trim($_POST['submit_at']);
        $imgs = mb_strlen(trim(isset($_POST['imgs']) ?: "")) == 0 ? "" : trim($_POST['imgs']);
        if ($user_model) {
            $res=$this->Data_helper_model->get_model_in_fileds('orders',['goods_id'],[$goods_id]);
//            var_dump($res);exit();
            if(!$res){
                return_app_json("104", "查無此訂單", []);
            }
            $sql_data = [
                "order_id" => $res->id,
                "content" => $content,
                "type" => $type,
                "imgs" => $imgs,
                "submit_at" => $submit_at,
                "created_at" => date("Y-m-d H:i:s", time())
            ];
            if ($this->db->insert("impeach", $sql_data)) {
                return_app_json("200", "提交成功", []);
            } else {
                return_app_json("104", "提交失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //获取大分类
    public function get_class()
    {
        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        if(empty($type)){
            return return_app_json("104", "參數錯誤", []);
        }
        $data = $this->Data_helper_model->get_model_list_in_fileds('goods_class', ['class_type', 'state'], [$type, 1]);
        if ($data) {
            return return_app_json('200', '獲取成功', $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }

    }
    //獲取全部分類
    public function get_all_class()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $data = $this->Data_helper_model->get_model_list_in_fileds('goods_class', ['state'], [1]);

            $res=$this->tree($data);
            return return_app_json("200", "獲取成功", $res);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //拼裝分類樹
    public function tree($arr)
    {
        $tree=[];
        $clb=[];
        foreach ($arr as $key => $value){
            if($value->class_type==1){
                $tree[]=$value;
            }else{
                $clb[]=$value;
            }
        }
        foreach ($tree as $key=>$value)
        {
            $_child=[];
            foreach ($clb as $k=>$v){
                if($v->parent_id == $value->id){
                    $_child[]=$v;
                }
            }
            $tree[$key]->_child=$_child;
        }
        return $tree;
    }

    //獲取用戶評級
    public function get_user_ratings()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
//        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        if ($user_model) {
            $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('user_ratings', ['state'], [1], 'sort', 'desc');
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //獲取物品列表
    public function get_goods_list()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $name = mb_strlen(trim(isset($_POST['name']) ?: "")) == 0 ? "" : trim($_POST['name']);
        if ($user_model) {
            $data = $this->Data_helper_model->get_model_list_in_fileds_orderby('goods', ['status','name like','up_user !='], [1,'%'.$name.'%',$user_model->phone], 'id', 'desc');
            foreach ($data as $key =>$value){
                $count= $this->Data_helper_model->get_model_list_in_fileds('collect',['goods_id'],[$value->id]);
                $data[$key]->collection_num=count($count);
            }
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //獲取物品詳情
    public function get_goods_one()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        //物品id
        $id = mb_strlen(trim(isset($_POST['id']) ?: "")) == 0 ? "" : trim($_POST['id']);
        if ($user_model) {
            $data = $this->Data_helper_model->get_model_in_id("goods", $id);
            //上傳人的信息
            $user_info=$this->Data_helper_model->get_model_in_fileds('members',['phone'],[$data->up_user]);
            if($user_info){
                //已獲得的
                $res= $this->Data_helper_model->get_model_list_in_fileds('orders',['member_account'],[$user_info->phone]);
                $user_info->acquire_sum=count($res);

                //已上架的
                $res= $this->Data_helper_model->get_model_list_in_fileds('goods',['up_user'],[$user_info->phone]);
                $user_info->putaway=count($res);
                //等级名称
                $user_ratings=$this->Data_helper_model->get_model_in_id("user_ratings", $user_info->lev);
                if($user_ratings){
                    $user_info->title=$user_ratings->title;
                    $user_info->imgs=$user_ratings->imgs;
                }else{
                    $user_info->title='';
                    $user_info->imgs='';
                }
                $data->user_info=$user_info;

            }else{
                return return_app_json("104", "獲取失敗,無上傳者的信息", $data);
            }
            //物品是否存在订单
            $is_orders=$this->Data_helper_model->get_model_in_fileds('orders',['goods_id'],[$id]);
            if($is_orders){
                $data->order_state=$is_orders->state;//訂單狀態1待出貨2已出貨3已完成
            }else{
                $data->order_state='0';//為0無此訂單
            }

            //是否收藏
            $is_collect=$this->Data_helper_model->get_model_in_fileds('collect',['user_id','goods_id'],[$user_id,$data->id]);
            if($is_collect){
                $data->is_collect=1;
            }else{
                $data->is_collect=0;
            }
            //是否已检举
            $is_orders=$this->Data_helper_model->get_model_in_fileds('orders',['member_account','goods_id'],[$user_model->phone,$id]);

            $is_impeach=$this->Data_helper_model->get_model_in_fileds('impeach',['order_id'],[$is_orders->id]);
            if($is_impeach){
                $data->is_impeach=1;
            }else{
                $data->is_impeach=0;
            }
            //是否已评价
            $is_evaluate=$this->Data_helper_model->get_model_in_fileds('evaluate',['order_id'],[$is_orders->id]);
            if($is_evaluate){
                $data->is_evaluate=1;
            }else{
                $data->is_evaluate=0;
            }

            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }

    //随机获取一个物品
    public function get_goods_rand()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $res=$this->Data_helper_model->get_model_list_in_fileds('goods',['status','up_user !='],[1,$user_model->phone]);
            $count=count($res);
            if($count>0) {
                $rand = rand(1, $count);
                $sql = 'SELECT *  FROM goods where status=1 and up_user !=? ORDER BY id  LIMIT ?,1';
                $query = $this->db->query($sql, [$user_model->phone, $rand - 1]);
                $data = $query->row_array();
                //是否收藏
                $is_collect = $this->Data_helper_model->get_model_in_fileds('collect', ['user_id', 'goods_id'], [$user_id, $data['id']]);
                if ($is_collect) {
                    $data['is_collect'] = 1;
                } else {
                    $data['is_collect'] = 0;
                }
            }else{
                $data=[];
            }
            if($data){
                return return_app_json("200", "獲取成功", $data);
            }else{
                return return_app_json("104", "獲取失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //获取收藏和已获得的物品
    public function get_possess_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        if ($user_model) {
            $field = array(
                'goods.id',
                'goods.name',
                'goods.up_user',
                'goods.pic',
                'goods.goods_type_id',
                'goods.purchase_way',
                'goods.m_place',
                'goods.use_number',
                'goods.storage_titme',
                'goods.storage_titme_units',
                'goods.state_label',
                'goods.custom_label',
                'goods.freight',
                'goods.freight_pt',
                'goods.status',
//                'orders.created_at',
            );

            if($type==1){
                //收藏
//                $res= $this->Data_helper_model->get_model_list_in_fileds('collect',['user_id'],[$user_id]);
                $this->db->join("collect", 'collect.goods_id = goods.id', 'RIGHT');
                $this->db->where('user_id', $user_id);
                $this->db->order_by('collect.created_at','desc');
                $field[]='collect.created_at';
            }else{
                //已获得
//                $res= $this->Data_helper_model->get_model_list_in_fileds('orders',['member_account'],[$user_model->phone]);
                $this->db->join("orders", 'orders.goods_id = goods.id', 'RIGHT');
                $this->db->where('member_account', $user_model->phone);
                $this->db->order_by('orders.created_at','desc');
                $field[]='orders.created_at';
            }
            $this->db->select($field);

//            $goods_id=array();
//            foreach ($res as $key =>$value){
//                $goods_id[]=$value->goods_id;
//            }
////            var_dump($goods_id);exit();
//
//            if(empty($goods_id)){
//                $this->db->where('id', 0);
//            }else{
//                $this->db->where_in('id', $goods_id);
//            }
//            $this->db->where('status', 1);
            $data = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "goods");
//            var_dump($this->db->last_query());exit();
            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //获取上架的物品品
    public function get_added_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
//        $type = mb_strlen(trim(isset($_POST['type']) ?: "")) == 0 ? "" : trim($_POST['type']);
        if ($user_model) {

            $this->db->where('up_user',$user_model->phone);
//            $this->db->where('status',1);
            $res = $this->Data_helper_model->get_tabel_list($this->db, $_POST, "goods");
            foreach ($res as $key =>$value){
                $count= $this->Data_helper_model->get_model_list_in_fileds('collect',['goods_id'],[$value->id]);
                $res[$key]->collection_num=count($count);
            }
            return return_app_json("200", "獲取成功", $res);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //移除收藏物品
    public function del_collect_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        if ($user_model) {
            if(empty($goods_id)){
                return return_app_json("104", "参数错误", []);
            }
            $this->db->where('user_id', $user_id);
            $this->db->where('goods_id', $goods_id);
            $query = $this->db->delete('collect');
            if($query){
                return return_app_json("200", "移除成功", []);
            }else{
                return return_app_json("104", "移除失败", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //添加收藏物品
    public function add_collect_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        if ($user_model) {
            if(empty($goods_id)){
                return return_app_json("104", "参数错误", []);
            }
            $is_collect=$this->Data_helper_model->get_model_in_fileds('collect',['user_id','goods_id'],[$user_id,$goods_id]);
            if($is_collect){
                return return_app_json("104", "您已經收藏過了", []);
            }
            $sql=[
                'user_id'  => $user_id,
                'goods_id' => $goods_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            if($this->db->insert('collect',$sql)){
                return return_app_json("200", "添加成功", []);
            }else{
                return return_app_json("104", "添加失败", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //获取标签
    public function get_status_label()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $res= $this->Data_helper_model->get_model_list_in_fileds('status_label',['state'],[1]);
            return return_app_json("200", "獲取成功", $res);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //留言板
    public function get_guestbook()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        if ($user_model) {
            $arr=array();
            //获取关系表
            $sql='SELECT * FROM relationship where user_id=?';
            $aa= $this->db->query($sql,[$user_id]);
            $data=$aa->result_array();
            foreach ($data as $value){
                $arr[]=$value['chat_user'];
            }
            //没得关系为空
            if(empty($arr)){
                return return_app_json("200", "獲取成功", []);
            }
            //跟哪些人有记录
            $this->db->where_in('id',$arr);
            $aa=$this->db->get('members');
            $res=$aa->result_array();
            foreach ($res as $key=>$value){
                $sql='select * from guestbook where (sender=? or receiver=?) and (sender=? or receiver=?) GROUP BY created_at desc';
                $aa= $this->db->query($sql,[$user_id,$user_id,$value['id'],$value['id']]);
                $data=$aa->result_array();
                $res[$key]['order_by_time']=$data[0]['created_at'];
                $res[$key]['content']=$data[0]['content'];
//                $res[$key]['guestbook']=$data;
            }
            //根据order_by_time倒序
            usort($res, array($this, "my_sort"));
            return return_app_json("200", "獲取成功", $res);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //排序
    function my_sort($a,$b)
    {
        if ($a['order_by_time']==$b['order_by_time']) return 0;
        return ($a['order_by_time'] > $b['order_by_time'])?-1:1;
    }
    //留言
    public function leave_word()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $receiver = mb_strlen(trim(isset($_POST['receiver']) ?: "")) == 0 ? "" : trim($_POST['receiver']);
        $content = mb_strlen(trim(isset($_POST['content']) ?: "")) == 0 ? "" : trim($_POST['content']);
        if ($user_model) {
            if(empty($receiver)){
                return return_app_json("104", "參數錯誤！", []);
            }
            $res=$this->Data_helper_model->get_model_in_fileds('members',['phone'],[$receiver]);
            if(!$res){
                return return_app_json("104", "參數錯誤！", []);
            }
            $receiver=$res->id;
            $sql=[
                'user_id'=> $user_id,
                'chat_user'=> $receiver,
                'created_at'  =>date('Y-m-d H:i:s')
            ];
            $this->db->replace('relationship',$sql);
            $sql=[
                'user_id'=> $receiver,
                'chat_user'=> $user_id,
                'created_at'  =>date('Y-m-d H:i:s')
            ];
            $this->db->replace('relationship',$sql);
            $sql=[
                'sender'  => $user_id,
                'receiver'  => $receiver,
                'content'  => $content,
                'created_at'  =>date('Y-m-d H:i:s'),
                'created_date'  =>date('Y-m-d'),
            ];
            if($this->db->insert('guestbook',$sql)){
                //给物品主人发送一条推播（極光推送）
                $this->jpush->push($content,'有人給你發了一條消息',array(
                    "registration_id" => array($res->registration_id)//指定registration_id用户
                ));
                return return_app_json("200", "留言成功", []);
            }else{
                return return_app_json("104", "留言失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //留言记录
    public function guestbook_list()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $chat_user = mb_strlen(trim(isset($_POST['chat_user']) ?: "")) == 0 ? "" : trim($_POST['chat_user']);
        if ($user_model) {
            //
            $chat=$this->Data_helper_model->get_model_in_fileds('members',['phone'],[$chat_user]);
            if(!$chat){
                return return_app_json("104", "查無此人", []);
            }
            $chat_user=$chat->id;
            if($user_id==$chat_user){
                return return_app_json("104", "myself", []);
            }
            $sql='select created_date from guestbook where (sender=? or receiver=?) and (sender=? or receiver=?)  GROUP BY  created_date';
            $aa= $this->db->query($sql,[$user_id,$user_id,$chat_user,$chat_user]);
            $data=$aa->result_array();
//            return return_app_json("200", "獲取成功", $data);
            foreach ($data as $key=>$value){
                $sql='select * from guestbook where (sender=? or receiver=?) and (sender=? or receiver=?) and created_date=? ORDER BY created_at';
                $aa= $this->db->query($sql,[$user_id,$user_id,$chat_user,$chat_user,$value['created_date']]);
                $res=$aa->result_array();
                $data[$key]['data']=$res;
            }

            return return_app_json("200", "獲取成功", $data);
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //删除上架物品
    public function del_upload_goods()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        if ($user_model) {
            $res=$this->Data_helper_model->get_model_in_fileds('goods',['id','up_user'],[$goods_id,$user_model->phone]);
            //只能删除当前账号上传的物品
            if(!$res){
                return return_app_json("104", "删除失败", []);
            }
            if ($this->Data_helper_model->del_model_in_id('goods', $goods_id)) {
                return return_app_json("200", "删除成功", []);
            } else {
                return return_app_json("104", "删除失败", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //新增訂單
    public function add_orders()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        if ($user_model) {
            $goods = $this->Data_helper_model->get_model_in_fileds("goods",['id','status'],[$goods_id,1]);
            $orderby_noid=$this->Data_helper_model->get_model_in_fileds_orderby('orders',[],[],'id','desc');
            $up_members=$this->Data_helper_model->get_model_in_fileds('members',['phone'],[$goods->up_user]);
//            var_dump($up_members->registration_id);exit();
            if(!$goods){
                return return_app_json("104", "查無此物品", []);
            }
            //不能買自己的
            if($goods->up_user==$user_model->phone){
                return return_app_json("104", "不能購買自己上傳的", []);
            }
            //积分不够10不能购买
            if($user_model->integral < 10){
                return return_app_json("104", "積分不足", []);
            }
            $sql=[
                'order_no'  => $orderby_noid->order_no+1,
                'member_account'  => $user_model->phone,
                'goods_id'  => $goods_id,
                'goods_type'  => $goods->goods_type_id,
                'goods_name'  =>$goods->name,
                'created_at'  =>date('Y-m-d H:i:s'),
                'donor_account'  =>$goods->up_user,
                'state'  =>2,
            ];
            if($this->db->insert('orders',$sql)){
                //下架物品，其他人不能購買
                $this->Data_helper_model->update_table_in_fileds(
                    "goods",
                    ["id"],
                    [$goods_id],
                    ['status'=>0]
                );
                //删除收藏
                $this->db->where('user_id',$user_id);
                $this->db->where('goods_id',$goods_id);
                $this->db->delete('collect');
                //获得物品，积分减十
                $this->db->set('integral','integral-10',false);
                $this->db->where('phone',$user_model->phone);
                $this->db->update('members');

                //给物品主人发送一条推播（極光推送）
                $this->jpush->push('您上传的"'.$goods->name.'"已被买走','',array(
                    "registration_id" => array($up_members->registration_id)//指定registration_id用户
                ));
                return return_app_json("200", "申請成功", []);
            }else{
                return return_app_json("104", "申請失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //寄出物品
    public function shipments()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        if ($user_model) {
            if(empty($goods_id)){
                return return_app_json("102", "物品id為空", []);
            }
            //發貨
            if($this->Data_helper_model->update_table_in_fileds(
                "orders",
                ["goods_id"],
                [$goods_id],
                ['state'=>2]
            )){
                return return_app_json("200", "寄出成功", []);
            }else{
                return return_app_json("104", "寄出失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
    //取得物品
    public function picking()
    {
        $user_id = $this->Data_helper_model->get_app_user_id();
        $user_model = $this->Data_helper_model->get_model_in_id("members", $user_id);
        $goods_id = mb_strlen(trim(isset($_POST['goods_id']) ?: "")) == 0 ? "" : trim($_POST['goods_id']);
        if ($user_model) {
            if(empty($goods_id)){
                return return_app_json("102", "物品id為空", []);
            }
            //發貨
            if($this->Data_helper_model->update_table_in_fileds(
                "orders",
                ["goods_id"],
                [$goods_id],
                ['state'=>3]
            )){
                return return_app_json("200", "取貨成功", []);
            }else{
                return return_app_json("104", "取貨失敗", []);
            }
        } else {
            return return_app_json("102", "獲取失敗", []);
        }
    }
}

