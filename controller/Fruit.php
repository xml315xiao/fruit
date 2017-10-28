<?php
//header('Content-type:text/plain;charset=utf-8');
class Fruit extends MY_Controller
{
    protected $current_round;
    protected $current_golden;
    protected $types;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('redis');
        $this->redis->select(1);
        $this->load->model('fruit_model');
        $this->load->helper('url');

        if(empty($this->session->userdata['userinfo'])) {
            $this->load->helper('url');
            redirect('login');
        }
        if(0 === $this->redis->exists('current_round')) {
            $this->fruit_model->init();
        }
        $this->current_round  = $this->redis->get('current_round');
        $this->current_golden = $this->redis->get('current_golden');
        $this->types = ['8'=>'apple','7'=>'orange','6'=>'mongo','5'=>'bells','4'=>'watermelon','3'=>'star','2'=>'seven','1'=>'bar'];
    }

    public function index()
    {
        $current_info   = $this->fruit_model->get_detail($this->current_round);
        $data['round']  = $this->current_round;
        $data['info']   = $current_info;
        $data['gold']   = $this->fruit_model->gold_info();

        $lottery_seconds = $current_info['lottery_time'] - time();
        $is_running = false;
        if($lottery_seconds < 0) {
            $lottery_seconds = 0;
            $is_running = true;
        }
        $data['is_running']    = $is_running;
        $data['leave_seconds'] = $lottery_seconds;

        $data['history'] = $this->fruit_model->latest_records();
        $data['random_users'] = sprintf("%02d", rand(80,99));

        $user_id = $this->session->userdata('userinfo')['user_id'];
        $data['user_info']   = $this->fruit_model->user_info($user_id);
        $data['user_round']  = $this->fruit_model->get_user_detail($this->current_round, $user_id);
        $data['user_golden']['is_exist'] = $this->fruit_model->is_allready_exists($user_id, $this->current_golden);
        if($data['user_golden']['is_exist'] === false){
            $data['user_golden']['number'] = $this->fruit_model->get_user_gold($user_id, $this->current_golden);
        }

        $data['user_history']= $this->fruit_model->get_least_records($user_id);
        if(array_sum($data['user_round']) > 0) {
            $data['user_info']['balance'] = $data['user_info']['balance'] - array_sum($data['user_round']);
            if ($data['user_info']['balance'] < 0) $data['user_info']['balance'] = 0;
        }
        $data['user_info']['back_balance'] = $data['user_info']['balance'] + array_sum($data['user_round']);
        $data['user_info']['history'] = sizeof($data['user_history']);

        $data['highest'] = $this->fruit_model->highest_list();

        $this->load->view('fulishe/fruit', $data);
    }
}