<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Fruit_model extends MY_Model
{
    public $table = 'rq_fruit_machine';

    public $seconds = 43;

    public $prizes;

    public function __construct()
    {
        parent::__construct();

        $this->read_db = $this->load->database('read', true);
        $this->load->library('redis');
        $this->prizes = [
            '0'  => ['name' => '苹果',       'times' => 5],
            '1'  => ['name' => '小苹果',     'times' => 3],
            '2'  => ['name' => '橙子',       'times' => 10],
            '3'  => ['name' => '小橙子',     'times' => 3],
            '4'  => ['name' => '芒果',       'times' => 10],
            '5'  => ['name' => '小芒果',     'times' => 3],
            '6'  => ['name' => '铃铛',       'times' => 10],
            '7'  => ['name' => '小铃铛',     'times' => 3],
            '8'  => ['name' => '西瓜',       'times' => 20],
            '9'  => ['name' => '小西瓜',     'times' => 3],
            '10' => ['name' => '双星',       'times' => 20],
            '11' => ['name' => '小双星',      'times' => 3],
            '12' => ['name' => '双七',       'times' => 20],
            '13' => ['name' => '小双七',      'times' => 3],
            '14' => ['name' => 'BAR',        'times' => 60],
            '15' => ['name' => 'bar',        'times' => 30],
            '18' => ['name' => '大四喜',      'times' => 20],
            '19' => ['name' => '大三元',      'times' => 60],
            '20' => ['name' => '小三元',      'times' => 30],
        ];
    }

    public function init()
    {
        $round_id = 'H' . date('mdHis') . sprintf("%04d", rand(1000, 9999));
        $current_round = 'round:' . $round_id;
        $this->redis->set('current_round', $round_id);
        $this->redis->hset($current_round, 'create_time', time());
        $this->redis->hset($current_round, 'lottery_time', time() + $this->seconds);
        $this->redis->hset($current_round, 'state',  0);
        $this->redis->hset($current_round, 'income', 0);
        $this->redis->hset($current_round, 'expend', 0);
        $this->redis->hset($current_round, 'apple',  0);
        $this->redis->hset($current_round, 'mongo',  0);
        $this->redis->hset($current_round, 'orange', 0);
        $this->redis->hset($current_round, 'bells',  0);
        $this->redis->hset($current_round, 'watermelon', 0);
        $this->redis->hset($current_round, 'star',  0);
        $this->redis->hset($current_round, 'seven', 0);
        $this->redis->hset($current_round, 'bar',   0);
        $this->redis->hset($current_round, 'users', 0);
        $this->redis->hset($current_round, 'begin', 'A1');

        $current_golden = 'G' . date('mdHis') . sprintf("%05d", rand(10000, 99999));
        $this->redis->set('current_golden', $current_golden);
        $this->redis->hSet('gold:' . $current_golden, 'state', 0);
        $this->redis->hSet('gold:' . $current_golden, 'coins', 0);
        $this->redis->hSet('gold:' . $current_golden, 'users', 0);
        $this->redis->set('last_lucky', '1000066');
    }

    public function latest_records()
    {
        $init_records = [3, 1, 5, 2, 1, 7];
        $records = $this->fetch_lists('prize_code', '', ['id' => 'desc'], 'rq_fruit_machine', 6);
        if (empty($records)) {
            $records = $init_records;
        } else {
            $records = array_column($records, 'prize_code');
        }

        return $records;
    }

    public function get_detail($round_id)
    {
        $key = 'round:' . $round_id;
        if (0 === $this->redis->exists($key)) {
            return false;
        }
        $round_info = [
            'create_time' => $this->redis->hget($key, 'create_time'),
            'state'  => $this->redis->hget($key, 'state'),
            'income' => $this->redis->hget($key, 'income'),
            'expend' => $this->redis->hget($key, 'expend'),
            'apple'  => $this->redis->hget($key, 'apple'),
            'orange' => $this->redis->hget($key, 'orange'),
            'mongo'  => $this->redis->hget($key, 'mongo'),
            'bells'  => $this->redis->hget($key, 'bells'),
            'watermelon' => $this->redis->hget($key, 'watermelon'),
            'star'  => $this->redis->hget($key, 'star'),
            'seven' => $this->redis->hget($key, 'seven'),
            'bar'   => $this->redis->hget($key, 'bar'),
            'users' => $this->redis->hget($key, 'users'),
            'lottery_time' => $this->redis->hget($key, 'lottery_time'),
            'begin' => $this->redis->hget($key, 'begin'),
        ];

        return $round_info;
    }

    public function get_user_detail($round_id, $user_id)
    {
        $key = 'round:' . $round_id . ':' . $user_id;
        if ($user_id < 1 || 0 === $this->redis->exists($key)) {
            return [
                'apple'      => 0,
                'orange'     => 0,
                'mongo'      => 0,
                'bells'      => 0,
                'watermelon' => 0,
                'star'       => 0,
                'seven'      => 0,
                'bar'        => 0,
            ];
        } else {
            return [
                'apple'      => 0 !== $this->redis->hExists($key, 'apple')  ? $this->redis->hget($key, 'apple')  : 0,
                'orange'     => 0 !== $this->redis->hExists($key, 'orange') ? $this->redis->hget($key, 'orange') : 0,
                'mongo'      => 0 !== $this->redis->hExists($key, 'mongo')  ? $this->redis->hget($key, 'mongo')  : 0,
                'bells'      => 0 !== $this->redis->hExists($key, 'bells')  ? $this->redis->hget($key, 'bells')  : 0,
                'watermelon' => 0 !== $this->redis->hExists($key, 'watermelon') ? $this->redis->hget($key, 'watermelon') : 0,
                'star'       => 0 !== $this->redis->hExists($key, 'star')  ? $this->redis->hget($key, 'star')  : 0,
                'seven'      => 0 !== $this->redis->hExists($key, 'seven') ? $this->redis->hget($key, 'seven') : 0,
                'bar'        => 0 !== $this->redis->hExists($key, 'bar')   ? $this->redis->hget($key, 'bar')   : 0,
            ];
        }
    }

    public function cancel_user_join($round_id, $user_id)
    {
        $key = 'round:' . $round_id . ':' . $user_id;
        if (0 === $this->redis->exists($key)) {
            return false;
        } else {
            $array = ['apple', 'orange', 'mongo', 'bells', 'watermelon', 'star', 'seven', 'bar'];
            foreach($array as $v){
                $m = 0 !== $this->redis->hExists($key, $v)  ? $this->redis->hget($key, $v)  : 0;
                $this->redis->hIncrBy('round:' . $round_id, $v, -$m);
                $this->redis->hIncrBy('round:' . $round_id, 'income', -$m);
                $this->redis->hset($key, $v, 0);
            }
        }
    }

    public function get_detail_info($round_id)
    {
        $key = 'round:' . $round_id;
        if (0 === $this->redis->exists($key)) {
            return false;
        }

        $keys = $this->redis->keys($key . ':*');

        $list = [];
        foreach ($keys as $val) {
            $user_id = str_replace($key . ':', '', $val);
            $total = 0;
            $result = $this->redis->hGetAll($val);
            for ($i = 0, $len = sizeof($result); $i < $len; $i += 2) {
                $item = $result[$i];
                $list[$user_id][$item] = $result[$i + 1];
                $total += $result[$i + 1];
            }
            $list[$user_id]['expend'] = $total;
        }

        return $list;
    }

    public function check_balance($user_id, $expend)
    {
        if ($user_id < 1) return false;
        if ($expend < 1) return false;

        $sql = 'select unwithdraw_money, balance, unwithdraw_money + balance total from rq_app_user_info where id = ? limit 1';
        $user_info = $this->db->query($sql, [$user_id])->row();

        if ($user_info->total < $expend) {
            return false;
        } else {
            return $this->update_balance($user_id, $expend, $user_info->unwithdraw_money, $user_info->balance);
        }
    }

    public function update_balance($user_id, $expend, $unwithdraw_money, $balance)
    {
        // 添加水果机游戏扣款日志、并扣款
        if ($unwithdraw_money >= $expend) {
            $record = [
                'userid'                => $user_id,
                'unwithdraw_money'      => $expend,
                'last_unwithdraw_money' => $unwithdraw_money - $expend,
                'money_type'            => 0,
                'trade_type'            => 63,
                'notes'                 => '参与水果机消耗' . $expend . '夺宝币',
                'trade_time'            => time(),
                'trade_date'            => date('Y-m-d'),
            ];
            $flag = $this->db->insert('rq_app_detail_' . date('Ym'), $record);

            $sql = 'update rq_app_user_info set unwithdraw_money = unwithdraw_money - ' . $expend . ' where id = ? limit 1';
            $flag = $flag && $this->db->query($sql, [$user_id]);

        } elseif ($unwithdraw_money > 0) {
            $record = [
                'userid'                => $user_id,
                'unwithdraw_money'      => $unwithdraw_money,
                'last_unwithdraw_money' => 0,
                'money_type'            => 0,
                'trade_type'            => 63,
                'notes'                 => '参与水果机消耗' . $unwithdraw_money . '夺宝币',
                'trade_time'            => time(),
                'trade_date'            => date('Y-m-d'),
            ];
            $flag = $this->db->insert('rq_app_detail_' . date('Ym'), $record);

            $record = [
                'userid'           => $user_id,
                'trade_money'      => $expend - $unwithdraw_money,
                'last_trade_money' => $balance - $expend + $unwithdraw_money,
                'money_type'       => 0,
                'trade_type'       => 63,
                'notes'            => '参与水果机消耗' . ($expend - $unwithdraw_money) . '金币',
                'trade_time'       => time(),
                'trade_date'       => date('Y-m-d'),
            ];
            $flag = $flag && $this->db->insert('rq_app_detail_' . date('Ym'), $record);

            $sql = 'update rq_app_user_info set unwithdraw_money = 0, balance = balance - ' . ($expend - $unwithdraw_money) . ' where id = ? limit 1';
            $flag = $flag && $this->db->query($sql, [$user_id]);

        } else {
            $record = [
                'userid'           => $user_id,
                'trade_money'      => $expend,
                'last_trade_money' => $balance - $expend,
                'money_type'       => 0,
                'trade_type'       => 63,
                'notes'            => '参与水果机消耗' . $expend . '金币',
                'trade_time'       => time(),
                'trade_date'       => date('Y-m-d'),
            ];
            $flag = $this->db->insert('rq_app_detail_' . date('Ym'), $record);

            $sql = 'update rq_app_user_info set balance = balance - ' . $expend . ' where id = ? limit 1';
            $flag = $flag && $this->db->query($sql, [$user_id]);
        }

        return $flag;
    }

    public function get_current_statistic($id = 1)
    {
        $sql = 'select income,expend,profit from rq_fruit_statistics where id = ? limit 1';
        $result = $this->db->query($sql, [$id])->row();
        if (empty($result)) {
            $this->db->query('insert into rq_fruit_statistics(income,expend,id) value(0,0,?)', [$id]);
            $result = $this->db->query($sql, [$id])->row();
        }
        return $result;
    }

    public function keep_fruit_record($info, $detail)
    {
        $common = [
            'apple' => $info['apple'], 'orange' => $info['orange'], 'mongo' => $info['mongo'], 'bells' => $info['bells'],
            'watermelon' => $info['watermelon'], 'star' => $info['star'], 'seven' => $info['seven'], 'bar' => $info['bar']
        ];

        $data = [
            'round_id'     => $info['round_id'],
            'income'       => $info['income'],
            'expend'       => $info['expend'],
            'users'        => $info['users'],
            'begin'        => $info['begin'],
            'stop'         => $info['position'],
            'has_luck'     => $info['has_luck'],
            'prize_code'   => $info['prize_code'],
            'prize_name'   => $info['prize_name'],
            'create_time'  => date('Y-m-d H:i:s', $info['create_time']),
            'lottery_time' => date('Y-m-d H:i:s', $info['lottery_time']),
            'log_time'     => date('Y-m-d H:i:s'),
            'profit'       => sprintf("%.2f", ($info['income'] - $info['expend'] - $info['gold']) / $info['income']),
            'common'       => json_encode($common),
            'detail'       => json_encode($detail),
            'gold'         => $info['gold']
        ];

        return $this->db->insert('rq_fruit_machine', $data);
    }

    public function give_prize($round_id, $detail, $prize_id)
    {
        $prizes = [
            '0'  => ['name' => 'APPLE',      'times' => 5],
            '1'  => ['name' => 'apple',      'times' => 3],
            '2'  => ['name' => 'ORANGE',     'times' => 10],
            '3'  => ['name' => 'orange',     'times' => 3],
            '4'  => ['name' => 'MONGO',      'times' => 10],
            '5'  => ['name' => 'mongo',      'times' => 3],
            '6'  => ['name' => 'BELLS',      'times' => 10],
            '7'  => ['name' => 'bells',      'times' => 3],
            '8'  => ['name' => 'WATERMELON', 'times' => 20],
            '9'  => ['name' => 'watermelon', 'times' => 3],
            '10' => ['name' => 'STAR',       'times' => 20],
            '11' => ['name' => 'star',       'times' => 3],
            '12' => ['name' => 'SEVEN',      'times' => 20],
            '13' => ['name' => 'seven',      'times' => 3],
            '14' => ['name' => 'BAR',        'times' => 60],
            '15' => ['name' => 'bar',        'times' => 30],
            '18' => ['name' => 'FOUR',       'times' => 20],
            '19' => ['name' => 'THREE',      'times' => 20],
            '20' => ['name' => 'three',      'times' => 10],
        ];

        $times = $prizes[$prize_id]['times'];

        // 无人参与直接返回true
        if (empty($detail)) {
            return true;
        } else {
            $datas = [];
            foreach ($detail as $user => $value) {
                switch ($prize_id) {
                    case 18 :
                        $number = $value['apple'] ? $value['apple'] : 0;
                        $income = $number * $times;
                        break;
                    case 19 :
                        $number1 = $value['seven'] ? $value['seven'] : 0;
                        $number2 = $value['star'] ? $value['star'] : 0;
                        $number3 = $value['watermelon'] ? $value['watermelon'] : 0;
                        $income  = ($number1 + $number2 + $number3) * $times;
                        break;
                    case 20 :
                        $number1 = $value['bells'] ? $value['bells'] : 0;
                        $number2 = $value['mongo'] ? $value['mongo'] : 0;
                        $number3 = $value['orange'] ? $value['orange'] : 0;
                        $income  = ($number1 + $number2 + $number3) * $times;
                        break;
                    default :
                        $fruit  = strtolower($prizes[$prize_id]['name']);
                        $number = $value[$fruit] ? $value[$fruit] : 0;
                        $income = $number * $times;
                        break;
                }
                $value['income'] = $income;

                // 给用户账户余额添加金币
                $this->update_unwithdraw($user, $income);

                $datas[] = [
                    'round_id' => $round_id,
                    'user_id'  => $user,
                    'expend'   => $value['expend'],
                    'income'   => $income,
                    'detail'   => json_encode($value),
                    'date'     => date('Ymd'),
                    'is_win'   => $value['expend'] < $income ? 1 : 0,
                    'prize'    => $prize_id
                ];
            }

            // 添加玩家参与游戏日志记录
            return $this->db->insert_batch('rq_fruit_user_log', $datas);
        }
    }

    public function update_unwithdraw($user_id, $amount, $trade_type = 64)
    {
        if ($user_id < 1) return false;
        if ($amount < 1) return false;

        $sql = 'select unwithdraw_money from rq_app_user_info where id = ? limit 1';
        $unwithdraw_money = $this->db->query($sql, [$user_id])->row()->unwithdraw_money;
        $notes = '水果机游戏押中' . $amount . '夺宝币';
        if ($trade_type == 65) $notes = '水果机游戏中彩金' . $amount;

        // 添加交易记录
        $record = [
            'userid'                => $user_id,
            'unwithdraw_money'      => $amount,
            'last_unwithdraw_money' => $amount + $unwithdraw_money,
            'money_type'            => 1,
            'trade_type'            => $trade_type,
            'notes'                 => $notes,
            'trade_time'            => time(),
            'trade_date'            => date('Y-m-d'),
        ];
        $flag = $this->db->insert('rq_app_detail_' . date('Ym'), $record);

        // 变更账户夺宝币数
        $sql = 'update rq_app_user_info set unwithdraw_money = unwithdraw_money + ? where id = ? limit 1';
        $flag && $this->db->query($sql, [$amount, $user_id]);
    }

    public function update_statistics($income, $expend, $golden, $id = 1)
    {
        $sql = 'update rq_fruit_statistics set income = income + ?, expend = expend + ?, golden = golden + ? where id = ? limit 1';
        return $this->db->query($sql, [$income, $expend, $golden, $id]);
    }

    public function finish_round($round_id)
    {
        $current_round = $this->redis->get('current_round');
        if ($round_id != $current_round) return false;

        $result = $this->redis->hSet('round:' . $current_round, 'state', 2);
        return $result === 0;
    }

    public function new_round($position)
    {
        $current_round = $this->redis->get('current_round');
        $state = $this->redis->hGet('round:' . $current_round, 'state');
        if ($state != 2) return false;

        $round_id = 'H' . date('mdHis') . sprintf("%04d", rand(1000, 9999));
        $current_round = 'round:' . $round_id;
        $this->redis->set('current_round', $round_id);
        $this->redis->hset($current_round, 'create_time', time());
        $this->redis->hset($current_round, 'lottery_time', time() + $this->seconds);
        $this->redis->hset($current_round, 'state',  0);
        $this->redis->hset($current_round, 'income', 0);
        $this->redis->hset($current_round, 'expend', 0);
        $this->redis->hset($current_round, 'apple',  0);
        $this->redis->hset($current_round, 'mongo',  0);
        $this->redis->hset($current_round, 'orange', 0);
        $this->redis->hset($current_round, 'bells',  0);
        $this->redis->hset($current_round, 'watermelon', 0);
        $this->redis->hset($current_round, 'star',  0);
        $this->redis->hset($current_round, 'seven', 0);
        $this->redis->hset($current_round, 'bar',   0);
        $this->redis->hset($current_round, 'users', 0);
        $this->redis->hset($current_round, 'begin', $position);
    }

    public function position($fruit_code)
    {
        $positions = [
            'A1' => 7,  'A2' => 8,  'A3' => 9,  'A4' => 10, 'A5' => 11, 'A6' => 12, 'A7' => 13,
            'B1' => 18, 'B2' => 17, 'B3' => 16, 'B4' => 15, 'B5' => 14,
            'C1' => 1,  'C2' => 24, 'C3' => 23, 'C4' => 22, 'C5' => 21, 'C6' => 20, 'C7' => 19,
            'D1' => 2,  'D2' => 3,  'D3' => 4,  'D4' => 5,  'D5' => 6
        ];

        return $positions[$fruit_code];
    }

    public function user_info($user_id)
    {
        if ($user_id < 1) return null;
        $sql = 'select id, unwithdraw_money, balance from rq_app_user_info where id = ? limit 1';
        $result = $this->db->query($sql, [$user_id])->row();
        if (empty($result)) return null;

        return ['id' => $this->my_simple_crypt($result->id), 'balance' => $result->balance + $result->unwithdraw_money];
    }

    public function adjust_golden($number)
    {
        do {
            $current_golden = $this->redis->get('current_golden');
        } while ($this->redis->hget('gold:' . $current_golden, 'state') > 0);

        $this->redis->hIncrBy('gold:' . $current_golden, 'coins', intval($number));

        return true;
    }

    public function is_allready_exists($user_id, $gold_id)
    {
        return $this->redis->exists('gold:'. $gold_id.':'.$user_id) < 1;
    }

    public function get_user_gold($user_id, $gold_id)
    {
        return $this->redis->get('gold:'.$gold_id.':'.$user_id);
    }

    public function has_condition($user_id)
    {
        $divider = strtotime(date('Y-m-d 20:00:00'));
        if(time() < $divider){
            $start_time = date('Y-m-d 20:00:00', $divider - 3600 *24);
        } else {
            $start_time = date('Y-m-d 20:00:00', $divider);
        }

        $sql = 'select sum(expend) expend from rq_fruit_user_log where user_id = ? and create_time > ? limit 1';
        $result = $this->db->query($sql, [$user_id, $start_time])->row()->expend;
        $result = !empty($result) ? $result->expend : 0;

        return $result;
    }

    public function join_golden($user_id, $gold_id)
    {
        $this->redis->hIncrBy('gold:' . $gold_id, 'users', 1);
        $number = 1000000 + $this->redis->hGet('gold:' . $gold_id, 'users');
        $this->redis->set('gold:' . $gold_id . ':' . $user_id, $number);

        return true;
    }

    public function get_lucky_number($gold_id)
    {
        $sql = 'select lucky from rq_fruit_golden where gold_id = ? and user_id <> 0 limit 1';
        $res = $this->db->query($sql, [$gold_id])->row();

        return empty($res) ? 1000000 + rand(1, 100) : $res->lucky;
    }

    public function get_lucky_person($gold_id, $lucky)
    {
        if($this->redis->hGet('gold:'.$gold_id, 'state') < 1) return false;
        $result = $this->redis->keys('gold:'.$gold_id.':*');
        if(empty($result)){
            return false;
        }
        $person = 0;
        foreach($result as $v){
            if($lucky == $this->redis->get($v)) {
                $person = str_replace('gold:'.$gold_id.':', '', $v);
            }
        }

        return $person;
    }

    public function reset_golden()
    {
        $current_golden = 'G' . date('mdHis') . sprintf("%05d", rand(10000, 99999));
        $this->redis->set('current_golden', $current_golden);
        $this->redis->hGet('gold:'.$current_golden, 'state', 0);
        $this->redis->hGet('gold:'.$current_golden, 'coins', 0);
        $this->redis->hGet('gold:'.$current_golden, 'users', 0);
    }

    public function back_coins($coins, $id = 1)
    {
        $sql = 'update rq_fruit_statistics set income = income + ?, golden = golden - ? where id = ? limit 1';
        $this->db->query($sql, [$coins, $coins, $id]);
        $this->redis->set('current_golden', 'state', 3);
    }

    public function log_golden($gold_id, $users, $lucky, $user_id, $coins)
    {
        $phone = $this->read_db->query('select phone_num from rq_app_user_info where id = ? limit 1', [$user_id])->row()->phone_num;

        $sql = 'insert into rq_fruit_golden(gold_id, users, lucky, user_id, coins, phone) value(?, ?, ?, ?, ?, ?)';
        $this->db->query($sql, [$gold_id, $users, $lucky, $user_id, $coins, $phone]);
    }

    public function gold_info()
    {
        $current_gold = $this->redis->get('current_golden');
        $sql = 'SELECT lucky,coins,phone FROM rq_fruit_golden WHERE users > 0 ORDER BY id DESC LIMIT 1';
        $res = $this->read_db->query($sql)->row();
        if(empty($res)) {
            $res->coins = rand(200, 500);
            $res->lucky = rand(1000001, 1000200);
            $res->phone = '136****9356';
        } else {
            $res->phone = substr_replace($res->phone, '****', 3, 4);
        }

        return [
            'golden' => $current_gold,
            'lucky'  => $res,
            'coins'  => str_pad($this->redis->hGet('gold:'.$current_gold, 'coins'), 6, '0', STR_PAD_LEFT)
        ];
    }

    public function highest_list()
    {
        $sql = 'SELECT SUM(income) income, user_id FROM rq_fruit_user_log GROUP BY user_id  HAVING income > 0 ORDER BY income DESC limit 10';
        $result = $this->db->query($sql)->result();
        if(!empty($result)){
            foreach ($result as $key=>$value){
                $phone = $this->db->query('select phone_num from rq_app_user_info where id = ? limit 1', [$value->user_id])->row()->phone_num;
                $result[$key]->phone = substr_replace($phone, '****', 3, 4);
            }
        }

        return $result;
    }

    public function decrypt($token)
    {
        $key  = '4c2a8fe7eaf24721cc7a9f0175115bd4';
        $iv   = '1234567812345678';
        $v = base64_decode(str_replace(' ', '+', $token));
        $v = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $v, MCRYPT_MODE_CBC, $iv);

        return rtrim($v, "\0");
    }

    public function my_simple_crypt( $string, $action = 'e' )
    {
        $secret_key = 'my_simple_secret_key';
        $secret_iv  = 'my_simple_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv  = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        } else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }

    public function get_least_records($user_id)
    {
        $sql = 'select `date`,prize,income,expend from rq_fruit_user_log where user_id = ? order by id desc limit 30';
        $res = $this->read_db->query($sql, [$user_id])->result();
        if(empty($res)) {
            return null;
        } else {
            foreach($res as $key=>$value){
                $res[$key]->date = date('Y.m.d', strtotime($value->date));
                $id = $value->prize;
                $res[$key]->prize = $this->prizes["$id"]['name'];
                $res[$key]->times = $this->prizes["$id"]['times'];
            }

            return $res;
        }
    }

    public function get_prize_name($prize_id)
    {
        return $this->prizes[$prize_id]['name'];
    }

    public function get_prize_times($prize_id)
    {
        return $this->prizes[$prize_id]['times'];
    }

}