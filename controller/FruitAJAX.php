<?php
class FruitAJAX extends CI_Controller
{
    protected $current_round;
    protected $types;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('redis');
        $this->load->model('fruit_model');

        $this->redis->select(1);
        $this->current_round = $this->redis->get('current_round');
        $this->types = ['8'=>'apple','7'=>'orange','6'=>'mongo','5'=>'bells','4'=>'watermelon','3'=>'star','2'=>'seven','1'=>'bar'];
    }

    public function join_coin()
    {
        $token   = $this->input->post('user');
        $type    = $this->input->post('type');
        $num     = $this->input->post('num');

        if ($type < 1 || $type > 8 || $num < 1) {
            exit(json_encode(['error'=>'请求参数异常','code'=>100001]));
        }
        $token = $this->fruit_model->decrypt($token);
        if (empty($token)) {
            exit(json_encode(['error'=>'请求参数异常','code'=>110001]));
        }

        $token = json_decode($token);
        if ($type != $token->type || $num != $token->number){
            exit(json_encode(['error'=>'请求参数异常','code'=>120001]));
        }

        // 开奖中跟已结束开奖不能再押注
        $this->current_round = $this->redis->get('current_round');
        if ($this->current_round != $token->round){
            exit(json_encode(['error'=>'请求参数异常','code'=>130001]));
        }
        $user_id = $this->fruit_model->my_simple_crypt($token->token, 'd');
        if($user_id < 1) {
            exit(json_encode(['error'=>'请求参数异常','code'=>140001]));
        }

        $current_state = $this->redis->hget('round:'.$this->current_round, 'state');
        if ($current_state > 0) {
            exit(json_encode(['error'=>'当前处于开奖状态，押注失效', 'code'=>100002]));
        }
        $current_lottery_time = $this->redis->hget('round:'.$this->current_round, 'lottery_time');
        if ($current_lottery_time < time()) {
            exit(json_encode(['error'=>'押注超时，押注失效', 'code'=>100002]));
        }
        // 屏蔽用户临界押注
        $current_create_time = $this->redis->hGet('round:'.$this->current_round, 'create_time');
        if ($current_create_time + 10 > time()) {
            exit(json_encode(['error'=>'押注时间未到，押注失效', 'code'=>100002]));
        }

        // 同一用户同类型最多押注99
        if(0 === $this->redis->exists('round:'.$this->current_round.':'.$user_id)) {
            $this->redis->hIncrBy('round:'.$this->current_round, 'users', 1);
        }
        if(0 === $this->redis->hExists('round:'.$this->current_round.':'.$user_id, $this->types[$type])) {
            $this->redis->hSet('round:'.$this->current_round.':'.$user_id, $this->types[$type], $num);
        } else {
            if($this->redis->hget('round:'.$this->current_round.':'.$user_id, $this->types[$type]) + $num > 99) {
                exit(json_encode(['error'=>'已押注到最高值', 'code'=>100003]));
            }
            $this->redis->hIncrBy('round:'.$this->current_round.':'.$user_id, $this->types[$type], $num);
        }

        $current_num = $this->redis->hget('round:'.$this->current_round.':'.$user_id, $this->types[$type]);
        $this->redis->hIncrBy('round:'.$this->current_round, 'income', $num);
        $this->redis->hIncrBy('round:'.$this->current_round, $this->types[$type], $num);

        exit(json_encode(['error'=>'', 'code'=>200, 'current_num'=>$current_num]));
    }

    public function cancel_join()
    {
        $token = $this->input->post('user');
        $token = $this->fruit_model->decrypt($token);
        if (empty($token)) {
            exit(json_encode(['error'=>'请求参数异常','code'=>110001]));
        }
        $token = json_decode($token);

        $this->current_round = $this->redis->get('current_round');
        if ($this->current_round != $token->round){
            exit(json_encode(['error'=>'请求参数异常','code'=>130001]));
        }
        $user_id = $this->fruit_model->my_simple_crypt($token->token, 'd');
        if($user_id < 1) exit(json_encode(['code'=>100001, 'error'=>'参数异常']));

        // 开奖中跟已结束开奖不能再押注
        $current_state = $this->redis->hget('round:'.$this->current_round, 'state');
        if ($current_state > 0) {
            exit(json_encode(['error'=>'当前处于开奖状态，操作失效', 'code'=>100002]));
        }
        $current_lottery_time = $this->redis->hget('round:'.$this->current_round, 'lottery_time');
        if ($current_lottery_time < time()) {
            exit(json_encode(['error'=>'取消押注超时，操作失败', 'code'=>100002]));
        }

        if(0 === $this->redis->exists('round:'.$this->current_round.':'.$user_id)){
            exit(json_encode(['error'=>'用户未曾参与押注，操作失败', 'code'=>100003]));
        }

        $this->fruit_model->cancel_user_join($this->current_round, $user_id);

        exit(json_encode(['code'=>200]));
    }

    public function lottery()
    {
        $this->current_round = $this->redis->get('current_round');
        $round_info = $this->fruit_model->get_detail($this->current_round);

        // 待开奖状态
        if($round_info['state'] == 0){
            if($round_info['lottery_time'] + 2 <= time()) {
                print_r('['. date('Y-m-d m:i:s'). '  ' . $this->current_round . "]\n");
                $this->redis->hSet('round:'.$this->current_round, 'state', 1);
                $this->load->service('Fruit_service');
                $this->Fruit_service->lottery($this->current_round);
            }
        }
    }

    public function get_current()
    {
        $this->current_round = $this->redis->get('current_round');
        $current_info = $this->fruit_model->get_detail($this->current_round);
        if($current_info['state'] > 0){
            exit(json_encode(['code'=>'100005', 'msg'=>'已开奖']));
        }
        $current_info['code'] = 200;
        exit(json_encode($current_info));
    }

    public function fetch_result()
    {
        $token   = $this->input->post('user');
        $roundId = $this->input->post('round');

        $token = $this->fruit_model->decrypt($token);
        if (empty($token)) {
            exit(json_encode(['error'=>'请求参数异常','code'=>110001]));
        }
        $token = json_decode($token);
        if ($roundId != $token->round){
            exit(json_encode(['error'=>'请求参数异常','code'=>130001]));
        }
        $user_id = $this->fruit_model->my_simple_crypt($token->token, 'd');
        if($user_id < 1) exit(json_encode(['code'=>100001, 'error'=>'参数异常']));

        if(0 === $this->redis->exists('round:'.$roundId)) exit(json_encode(['code'=>10002]));

        if(2 > $this->redis->hGet('round:'.$roundId, 'state')) exit(json_encode(['code'=>10003, 'state'=>$this->redis->hGet('round:'.$roundId, 'state')]));

        $sql = 'select stop,has_luck,prize_code,prize_name,gold from rq_fruit_machine where round_id = ? limit 1';
        $res = $this->db->query($sql, [$roundId])->row();
        if(empty($res)) exit(json_encode(['code'=>10004]));

        $data['prize_code'] = $res->prize_code;
        $data['prize_name'] = $this->fruit_model->get_prize_name($res->prize_code);
        $data['prize_times'] = $this->fruit_model->get_prize_times($res->prize_code);
        $data['next_start'] = $res->stop;
        $data['position']   = $this->fruit_model->position($res->stop);
        $data['is_luck']    = $res->has_luck;
        $data['gold']       = $res->gold;

        $sql = 'select expend,income from rq_fruit_user_log where user_id = ? and round_id = ? limit 1';
        $res = $this->db->query($sql, [$user_id, $roundId])->row();
        $data['expend'] = !empty($res) ? $res->expend : 0;
        $data['reward'] = !empty($res) ? $res->income : 0;

        $data['code'] = 200;
        $data['current'] = $this->redis->get('current_round');
        $data['leave_seconds'] = $this->redis->hGet( 'round:' . $data['current'], 'lottery_time' ) - time();

        exit(json_encode($data));
    }

    public function lottery_golden()
    {
        do {
            $current_golden = $this->redis->get('current_golden');
        }while($this->redis->hget('gold:'.$current_golden, 'state') > 0);

        $this->redis->hSet('gold:'.$current_golden, 'state', 1);
        $this->fruit_model->reset_golden();

        $coins  = $this->redis->hGet('gold:'.$current_golden, 'coins');
        $users  = $this->redis->hGet('gold:'.$current_golden, 'users');

        $person = 0;
        if($users < 1){
            $lucky =  1000000 + rand(1, 100);
            $this->fruit_model->back_coins($coins);
        } else {
            $lucky  = 1000000 + rand(1, $users);
            $person = $this->fruit_model->get_lucky_person($current_golden, $lucky);
            $this->fruit_model->update_unwithdraw($person, $coins, 65);
        }

        $this->redis->hSet('gold:'.$current_golden, 'state', 2);
        $this->redis->set('last_lucky', $lucky);
        $this->fruit_model->log_golden($current_golden, $users, $lucky, $person, $coins);

        exit(date('Y-m-d H:i:s') . '--' . $current_golden . ' : ' . $lucky . "\n");
    }

    public function fetch_golden_number()
    {
        $token   = $this->input->post('user');
        $gold_id = $this->input->post('gold');

        if(date('H') < 10 || date('H') > 20) {
            exit(json_encode(['error'=>'领取时间未到','code'=>100001]));
        }

        $token = $this->fruit_model->decrypt($token);
        if (empty($token)) {
            exit(json_encode(['error'=>'请求参数异常','code'=>110001]));
        }
        $token = json_decode($token);
        $this->current_round = $this->redis->get('current_round');
        if ($this->current_round != $token->round){
            exit(json_encode(['error'=>'请求参数异常','code'=>130001]));
        }
        $user_id = $this->fruit_model->my_simple_crypt($token->token, 'd');
        if($user_id < 1 || empty(trim($gold_id))) {
            exit(json_encode(['code'=>10001, 'error'=>'参数异常']));
        }

        // 查询用户是否已领取
        if(false === $this->fruit_model->is_allready_exists($user_id, $gold_id) >= 100){
            exit(json_encode(['code'=>10002, 'error'=>'您已领取，请勿重复领取, 谢谢配合！']));
        }

        // 判断用户是否已满足领取条件
        $current_coins = $this->fruit_model->has_condition($user_id);
        if(false === $current_coins >= 100){
            exit(json_encode(['code'=>10003, 'current'=>$current_coins, 'error'=>'当天立即参与未达100夺宝币，请先参与游戏']));
        }

        if(false === $this->fruit_model->join_golden($user_id, $gold_id)){
            exit(json_encode(['code'=>10004, 'error'=>'领取失败']));
        }

        $number = $this->redis->get('gold:'.$gold_id.':'.$user_id);
        exit(json_encode(['code'=>200, 'number'=>$number]));
    }

    public function fetch_golden()
    {
        $gold_id = $this->input->post('gold');

        if($this->redis->hget('gold:'.$gold_id, 'state') < 2){
            exit(json_encode(['code'=>10001, 'error'=>'参数异常']));
        }

        $result = $this->fruit_model->get_lucky_number($gold_id);

        exit(json_encode(['code'=>200, 'lucky'=>$result]));
    }

    public function fetch_top()
    {
        $list = $this->fruit_model->highest_list();
        exit(json_encode($list));
    }

}