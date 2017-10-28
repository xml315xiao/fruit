<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>水果机</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Content-Type" charset="utf-8">
    <link rel="shortcut icon" href="/static/icon/favicaon.ico" />
    <link href="/static/css/common_reset.css?v=<?=time()?>" rel="stylesheet">
    <link href="/static/css/cash_out.css?v=<?=time()?>" rel="stylesheet">
</head>
<body>
<?php $this->load->view('header');?>
<div class="wrap">
    <div class="back back1"></div>
    <div class="back back2"></div>
    <div class="back back3"></div>
    <div class="back back4"></div>
    <div class="back back5"></div>
    <div class="back back6"></div>
    <div class="back back7"></div>
    <div class="back back8"></div>
    <div class="back back9"></div>
    <div class="back back10"></div>
    <div class="back back11"></div>
    <div class="back back12"></div>
    <div class="back back13"></div>
    <div class="back back14"></div>
    <div class="back back15"></div>
    <div class="back back16"></div>
    <div class="back back17"></div>
    <div class="back back18"></div>
    <div class="back back19"></div>
    <div class="back back20"></div>
    <!-- 顶部 -->
    <div class="tops_div">
        <div class="currency_left">
            <div class="currency_num">
                <img src="/static/images/fulishe/cash_out/top1.fw.png">
                <div class="num_div">
                    <span>夺宝币:</span>
                    <span id="totalGold"><?=$user_info['balance']?></span>
                </div>
            </div>
            <a class="recharge_ospan" href="<?=site_url('user/recharge')?>">充值</a>
        </div>
        <div class="currency_auto">
            <div class="title_div">
                <p class="title_name">当前奖池夺宝币数:</p>
                <p class="title_num" id="coins"><?=$gold['coins']?></p>
            </div>
            <div class="draw_div">
                <p class="draw_title">奖池夺宝币会进行数字号码抽奖(一人只可领取一次)</p>
                <a href="javascript:;" class="fetchGold" id="fetchGold">点击领取</a>
            </div>
        </div>
        <div class="currency_right">
            <div class="currency_num">
                <img src="/static/images/fulishe/cash_out/top2.fw.png">
                <div class="num_div">
                    <span>当前在线人数:</span>
                    <span id="users"><?=$random_users;?>人</span>
                </div>
            </div>
        </div>
    </div>
    <!-- 中部 -->
    <div class="main_div">
        <div class="game_center_left">
            <div class="win_game_left">
                <div class="guide" id="guide"></div>
                <div class="win_div">
                    <div class="win_div_left">
                        <ul class="win_div_list">
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize0.png">
                                <p id="apple"><?=$info['apple']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize2.png">
                                <p id="orange"><?=$info['orange']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize6.png">
                                <p id="bells"><?=$info['bells']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize4.png">
                                <p id="mongo"><?=$info['mongo']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize10.png">
                                <p id="star"><?=$info['star']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize8.png">
                                <p id="watermelon"><?=$info['watermelon']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize12.png">
                                <p id="seven"><?=$info['seven']?></p>
                            </li>
                            <li>
                                <img src="/static/images/fulishe/cash_out/prize14.png">
                                <p id="bar"><?=$info['bar']?></p>
                            </li>
                        </ul>
                    </div>
                    <div class="win_div_right">
                        <p class="win_move">
                            <span>中奖走势</span>
                        </p>
                        <img src="/static/images/fulishe/cash_out/new.png" class="new_img">
                        <?php foreach($history as $value): ?>
                            <p class="win_move_img">
                                <img src="/static/images/fulishe/cash_out/prize<?=$value?>.png">
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <div class="win_div_right">

                    </div>
                </div>
            </div>
            <div class="cast_currency">
                <div class="select_div">
                    <img src="/static/images/fulishe/cash_out/left10.fw.png">
                </div>
                <ul class="cast_currency_list">
                    <li data-num="1">
                        <div class="active">
                            <p>1</p>
                            <p>夺宝币</p>
                        </div>
                    </li>
                    <li data-num="5">
                        <div>
                            <p>5</p>
                            <p>夺宝币</p>
                        </div>
                    </li>
                    <li data-num="10">
                        <div>
                            <p>10</p>
                            <p>夺宝币</p>
                        </div>
                    </li>
                    <li data-num="20">
                        <div>
                            <p>20</p>
                            <p>夺宝币</p>
                        </div>
                    </li>
                    <li data-num="50">
                        <div>
                            <p>50</p>
                            <p>夺宝币</p>
                        </div>
                    </li>
                    <li data-num="99">
                        <div>
                            <p>99</p>
                            <p>夺宝币</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="game_center_auto">
            <div class="game_center_main">
                <div class="wins_div win_big_bar">
                    <img src="/static/images/fulishe/cash_out/11.gif">
                </div>
                <div class="wins_div win_big_san other">
                    <img src="/static/images/fulishe/cash_out/12.gif">
                </div>
                <div class="wins_div win_simall_san other">
                    <img src="/static/images/fulishe/cash_out/13.gif">
                </div>
                <div class="wins_div win_good_luck other">
                    <img src="/static/images/fulishe/cash_out/14.gif">
                </div>
                <div class="wins_div win_simall_bar other">
                    <img src="/static/images/fulishe/cash_out/15.gif">
                </div>
                <div class="wins_div win_big_xi other">
                    <img src="/static/images/fulishe/cash_out/16.gif">
                </div>
            </div>
            <!-- 跑马灯 -->
            <div class="marquee">
                <ul class="marquee_list">
                    <?php for($i=0;$i<90;$i++):?>
                        <li></li>
                    <?php endfor; ?>
                </ul>
            </div>
            <div class="game_main">
                <ul class="game_main_list">
                    <li id="C1" data-num="1" class="gift gift1 THREE1"></li>
                    <li id="D1" data-num="2" class="gift gift2 THREE1"></li>
                    <li id="D2" data-num="3" class="gift gift3"></li>
                    <li id="D3" data-num="4" class="gift gift4" ></li>
                    <li id="D4" data-num="5" class="gift gift5" ></li>
                    <li id="D5" data-num="6" class="gift gift6  APPLE" ></li>
                    <li id="A1" data-num="7" class="gift gift7  THREE1" ></li>
                    <li id="A2" data-num="8" class="gift gift8 BIG" ></li>
                    <li id="A3" data-num="9" class="gift gift9" ></li>
                    <li id="A4" data-num="10" class="gift gift10 LUCK"></li>
                    <li id="A4" data-num="10" class="gift gift11 APPLE"></li>
                    <li id="A6" data-num="12" class="gift gift12"></li>
                    <li id="A7" data-num="13" class="gift gift13 THREE2"></li>
                    <li id="B5" data-num="14" class="gift gift14 THREE2"></li>
                    <li id="B4" data-num="15" class="gift gift15"></li>
                    <li id="B3" data-num="16" class="gift gift16 BIG"></li>
                    <li id="B2" data-num="17" class="gift gift17 APPLE"></li>
                    <li id="B1" data-num="18" class="gift gift18"></li>
                    <li id="C7" data-num="19" class="gift gift19 THREE2"></li>
                    <li id="C6" data-num="20" class="gift gift20 BIG"></li>
                    <li id="C5" data-num="21" class="gift gift21"></li>
                    <li id="C4" data-num="22" class="gift gift22 LUCK"></li>
                    <li id="C3" data-num="23" class="gift gift23 APPLE"></li>
                    <li id="C2" data-num="24" class="gift gift24"></li>
                </ul>
            </div>
            <div class="number" id="score">0</div>
            <!-- <div class="score"  id="lucky_number"><?=$gold['lucky']?></div> -->
            <div class="score"  id="lucky_number">
                <div class="winning_show">
                    <ul class="score_list">
                        <li>系统：恭喜玩家 <?=$gold['lucky']->phone?> 获得全彩池奖金 <?=$gold['lucky']->coins?> 夺宝币, 中奖号码为 <?=$gold['lucky']->lucky?> </li>
                    </ul>
                </div>
            </div>
            <ul class="control_list">
                <li class="return_note" id="refund"></li>
                <li class="times" id="leave_seconds"><?php echo $leave_seconds < 31 ? $leave_seconds : '00'; ?></li>
                <li class="re_injection" id="cancelJoin"></li>
            </ul>
            <ul class="game_center_list">
                <li class="bar" id="P49">
                    <p><?=$user_round['bar']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT1_1.fw.png">
                    </div>
                </li>
                <li class="seven" id="P50">
                    <p><?=$user_round['seven']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT2_1.fw.png">
                    </div>
                </li>
                <li class="star" id="P51">
                    <p><?=$user_round['star']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT3_1.fw.png">
                    </div>
                </li>
                <li class="watermelon" id="P52">
                    <p><?=$user_round['watermelon']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT4_1.fw.png">
                    </div>
                </li>
                <li class="bells" id="P53">
                    <p><?=$user_round['bells']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT5_1.fw.png">
                    </div>
                </li>
                <li class="mongo" id="P54">
                    <p><?=$user_round['mongo']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT6_1.fw.png">
                    </div>
                </li>
                <li class="orange" id="P55">
                    <p><?=$user_round['orange']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT7_1.fw.png">
                    </div>
                </li>
                <li class="apple" id="P56">
                    <p><?=$user_round['apple']?></p>
                    <div class="game_center_list_li">
                        <img src="/static/images/fulishe/cash_out/centerT8_1.fw.png">
                    </div>
                </li>
            </ul>
        </div>
        <div class="game_center_right">
            <div class="ranking_div">
                <p class="title_rank_op">收益排行榜</p>
                <div class="list_sale">
                    <table>
                        <tr>
                            <td>排名</td>
                            <td>用户名</td>
                            <td>赢得夺宝币</td>
                        </tr>
                        <?php if(!empty($highest)): ?>
                            <?php foreach($highest as $key=>$item): ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$item->phone?></td>
                                    <td><?=intval($item->income)?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </table>
                </div>
            </div>
            <div class="broadcast_div">
                <div class="title_div">
                    <img src="/static/images/fulishe/cash_out/guangbo.png">
                    <p>参与记录</p>
                </div>
                <div class="carousel">
                    <div class="carousel_div">
                        <ul class="carousel_list">
                            <?php if(!empty($user_history)): ?>
                            <?php foreach ($user_history as $record): ?>
                            <li>
                                <p>
                                    <span class="san"></span>
                                    <span><?=$record->date?></span><span>共投<?=$record->expend?>夺宝币</span>
                                </p>
                                <p>开奖结果：<?=$record->prize?> * <?=$record->times?> 倍</p>
                                <p>奖励金额：<?=$record->income?> 夺宝币</p>
                            </li>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="button">
                <img src="/static/images/fulishe/cash_out/22.fw.png" style="display: none;">
            </div>
        </div>
    </div>
</div>
<!-- 金币不足弹窗 -->
<div class="short_gold" style="display:none;">
    <img src="/static/images/fulishe/cash_out/closes.png" class="closes">
    <div class="short_gold_div">
        <p class="short_gold_op">您当前夺宝币不足&nbsp;请前去充值~ </p>
        <a href="<?=site_url('user/recharge')?>" target="_blank">前去充值>></a>
    </div>
</div>
<!-- 领取条件不满足时 -->
<div class="conditions_time_error" style="display:none;">
    <img src="/static/images/fulishe/cash_out/closes.png" class="closes">
    <div class="short_gold_div">
        <p class="short_gold_op">领取奖券时间为 10:00 ~ 20:00, 谢谢您的配合！</p>
        <a href="javascript:;" class="closes">继续游戏>></a>
    </div>
</div>
<div class="conditions_no" style="display:none;">
    <img src="/static/images/fulishe/cash_out/closes.png" class="closes">
    <div class="short_gold_div">
        <p class="short_gold_op">当前账号今天已投入<span class="red" id="current_coins"></span>夺宝币,不满足<span class="red">100</span>夺宝币免费赠送抽奖的条件,继续加油哦!</p>
        <a href="javascript:;" class="closes">前去游戏>></a>
    </div>
</div>
<!-- 领取条件满足时 -->
<div class="conditions" style="display:none;">
    <img src="/static/images/fulishe/cash_out/closes.png" class="closes">
    <div class="short_gold_div">
        <p class="short_gold_op">恭喜您!领取成功. 当前您领取的彩票号码为<span class="red" id="number"></span></p>
        <a href="javascript:;" class="closes">继续游戏>></a>
    </div>
</div>
<!-- 已领取 -->
<div class="received" style="display:none;">
    <img src="/static/images/fulishe/cash_out/closes.png" class="closes">
    <div class="short_gold_div">
        <p class="short_gold_op">抱歉！您今天的领取次数已用完, 当前您领取的彩票号码为<span class="red" id="golden_number"><?=$user_golden['number']?></span></p>
        <a href="javascript:;" class="closes">继续游戏>></a>
    </div>
</div>
<!-- 遮罩层 -->
<div class="main"></div>
<!-- 玩法规则 -->
<div class="game_rules" style="display:none;">
    <img src="/static/images/fulishe/cash_out/close.png" class="closes_img" id="close">
    <div class="list_nav">
        <p class="op optive"><span>新手指引</span></p>
        <p class="op"><span>游戏说明</span></p>
        <p class="op"><span>彩池奖</span></p>
        <p class="op"><span>注意事项</span></p>
    </div>
    <div class="list_div">
        <div class="view_game">
            <div class="chai">
                <p class="chai_title_op">
                    <span class="spot">1</span>
                    <span class="chai_title_ospan">选择押注的物品，例如选择：押注1个苹果</span>
                </p>
                <div class="div_ming">
                    <img src="/static/images/fulishe/cash_out/new_1.png">
                </div>
                <p class="chai_title_op">
                    <span class="spot">2</span>
                    <span class="chai_title_ospan">押注之后等待系统倒计时，时间为30秒，结束后彩灯开始运转</span>
                </p>
                <div class="div_ming">
                    <img src="/static/images/fulishe/cash_out/new_2.png">
                </div>
                <p class="chai_title_op">
                    <span class="spot">3</span>
                    <span class="chai_title_ospan">当彩灯停止，如果光圈停止在那个所投的物品上，则获得该物品相应的倍数奖励：如光圈停在其他物品上，则无奖励。</span>
                </p>
                <div class="div_ming div_mings">
                    <img src="/static/images/fulishe/cash_out/new_3.png">
                    <img src="/static/images/fulishe/cash_out/new_4.png">
                    <p class="div_ming_op">
                        <span>光圈停在苹果上会获得自身夺宝币数x5倍的夺宝币数奖励</span>
                        <span>光圈停在铃铛上，则无奖励</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="detailed_rules" style="display:none;">
            <p class="headline_op">
                <span class="headline"></span>
                <span class="content_ospan">游戏内共有八种押注物品:BAR、双7、双星、西瓜、铃铛、芒果、橙子、苹果。每个物品都有对应的倍率（详细倍率参考游戏押注的地方）</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">押注方式:</span>
                <span class="content_ospan">押注可以通过点鼠标左键或者数字快捷键1-8来进行操作。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">押注条件:</span>
                <span class="content_ospan">每次押注不能低于1夺宝币，单个彩灯押注上限为99夺宝币。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">获利条件:</span>
                <span class="content_ospan">游戏界面由24个方格拼接成一个正方形，每个方格中都有一个目标，且每个方格下都对应一个小灯。游戏开始后，选择押注的目标，点击开始之后，彩灯开始运动，结束后，如果停在玩家押注的目标上时，则该玩家可赢取相应的夺宝币。如停止在其它未押注的彩灯上则无奖励。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">喜彩奖:</span>
                <span class="content_ospan">大四喜：4个苹果（不包含小苹果）-20倍赔率<br/>小三元：橙子、芒果、铃铛 -30倍赔率<br/>小bar：跑灯中“BAR”-30倍赔率<br/>大三元：西瓜、双星、双七-60倍赔率<br/>大bar：跑灯中“BAR”-60倍赔率</span>
            </p>
        </div>
        <div class="matters" style="display:none;">
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">彩池奖：</span>
                <span class="content_ospan">系统会把随机将一定数量的夺宝币放入彩池，以供玩家作为抽奖奖励。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">领取奖券号码条件：</span>
                <span class="content_ospan">当天10:00——20:00时间段，在水果机游戏中投入大于等于100金币即可免费领取奖券号码。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">彩池奖券领取时间：</span>
                <span class="content_ospan">每天中午10：00开始领取——晚上20：00截止领取；达到领取条件用户；每个账号每天仅能领取1次。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">开奖时间：</span>
                <span class="content_ospan">每天晚上20：00开始抽取幸运用户，中奖者会在页面中间以滚屏公布中奖者信息。</span>
            </p>
            <p class="headline_op">
                <span class="headline"></span>
                <span class="bind_ospan">领取方式：</span>
                <span class="content_ospan">彩池奖中奖后，夺宝币会直接充值到账户上，请中奖者注意查看资金明细。</span>
            </p>
        </div>
        <div class="matters" style="display:none;">
            <p class="headline_op">
                <span class="bind_ospan">1.</span>
                <span class="content_ospan">平台有权根据活动参与情况，结束或提前结束用户参与活动的竞猜（指某轮活动不再接受用户的竞猜）</span>
            </p>
            <p class="headline_op">
                <span class="bind_ospan">2.</span>
                <span class="content_ospan">如遇到不可抗力或其他客观原因导致活动竞猜无法继续进行，则用户的投入将会全额返还到用户的平台账户，平台无需因此而承担任何赔偿或补偿责任</span>
            </p>
            <p class="headline_op">
                <span class="bind_ospan">3.</span>
                <span class="content_ospan">活动期间，如用户存在违规行为（包括但不限于机器作弊），平台将取消用户的竞猜获奖资格，并对用户进行封号处理</span>
            </p>
            <p class="headline_op">
                <span class="bind_ospan">4.</span>
                <span class="content_ospan">平台可根据活动举办的实际情况，在法律允许的范围内，对本活动规则进行变动或调整，相关变动或调整平台将会进行及时公布</span>
            </p>
        </div>
    </div>
</div>
<?php $this->load->view('footer');?>
<script src="/static/js/crypto-js.js"></script>
<script src="/static/js/jquery-1.8.3.min.js"></script>
<script>
    var formatFloat = function(num, digit) {
        var m = Math.pow(10, Math.abs(digit));
        if(digit < 0){
            return num / m;
        }else if(digit > 0){
            return num * m;
        }else{
            return num;
        }
    };
    var round = function round (value, precision, mode) {
        var m, f, isHalf, sgn; // helper variables
        // making sure precision is integer
        precision |= 0;
        m = Math.pow(10, precision);
        value *= m;
        // sign of the number
        sgn = (value > 0) | -(value < 0);
        isHalf = value % 1 === 0.5 * sgn;
        f = Math.floor(value);
        if (isHalf) {
            value = f + (sgn > 0);
        }
        return (isHalf ? value : Math.round(value)) / m;
    };

    var player = {
        token   : "<?=$user_info['id']?>",
        balance : parseFloat( "<?=$user_info['balance']?>"),
        score   : 0,
        history : <?=$user_info['history']?>,
        current : 1,
        apple         : <?=$user_round['apple']?>,
        orange        : <?=$user_round['orange']?>,
        mongo         : <?=$user_round['mongo']?>,
        bells         : <?=$user_round['bells']?>,
        star          : <?=$user_round['star']?>,
        seven         : <?=$user_round['seven']?>,
        watermelon    : <?=$user_round['watermelon']?>,
        bar           : <?=$user_round['bar']?>,
        back_balance  : parseFloat( "<?=$user_info['back_balance']?>"),
        back_score    : 0,
        enable_refund : true,
        enable_golden : ("<?=intval($user_golden['is_exist'])?>" < 1) ? false : true,
        last_record   : ""
    };

    player.reset = function () {
        player.bar    = 0;
        player.apple  = 0;
        player.orange = 0;
        player.mongo  = 0;
        player.bells  = 0;
        player.seven  = 0;
        player.star   = 0;
        player.watermelon = 0;
    };

    player.showCurrent = function(){
        $("ul.game_center_list > li.apple > p").text(player.apple);
        $("ul.game_center_list > li.orange > p").text(player.orange);
        $("ul.game_center_list > li.mongo > p").text(player.mongo);
        $("ul.game_center_list > li.bells > p").text(player.bells);
        $("ul.game_center_list > li.watermelon > p").text(player.watermelon);
        $("ul.game_center_list > li.star > p").text(player.star);
        $("ul.game_center_list > li.seven > p").text(player.seven);
        $("ul.game_center_list > li.bar > p").text(player.bar);
    };

    player.showRecord = function(){
        if(player.last_record.length > 0){
            if($("ul.carousel_list li").length < 1) {
                $("ul.carousel_list").html(player.last_record);
            } else {
                $("ul.carousel_list li:eq(0)").before(player.last_record);
            }

            if(player.history > 30) {
                $("ul.carousel_list li:last").remove();
            }
        }
    };

    player.balanceDialog = function () {
        $(".short_gold").show();
    };

    player.encrypt = function (data) {
        var key  = CryptoJS.enc.Utf8.parse("4c2a8fe7eaf24721cc7a9f0175115bd4");
        var iv   = CryptoJS.enc.Utf8.parse("1234567812345678");
        var encrypted = CryptoJS.AES.encrypt(JSON.stringify(data), key, { iv: iv,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.ZeroPadding});

        return encrypted.toString();
    };

    var fruit = {
        current_round : "<?=$round?>",
        current_golden: "<?=$gold['golden']?>",
        is_running    : "<?=$is_running?>" > 0 ? true : false,
        is_permission : false,
        real_time     : "<?=$leave_seconds?>",
        begin         : "<?=$info['begin']?>",
        apple         : <?=$info['apple']?>,
        orange        : <?=$info['orange']?>,
        mongo         : <?=$info['mongo']?>,
        bells         : <?=$info['bells']?>,
        star          : <?=$info['star']?>,
        seven         : <?=$info['seven']?>,
        watermelon    : <?=$info['watermelon']?>,
        bar           : <?=$info['bar']?>,
        status        : 0,
        lottery       : {},
        error_time    : 0,
        keep_round    : "<?=$round?>",
        init          : function(){
            $("#" + this.begin).addClass("box_sh");
        }
    };

    fruit.showCurrent = function(){
        $("#apple").text(fruit.apple);
        $("#orange").text(fruit.orange);
        $("#mongo").text(fruit.mongo);
        $("#bells").text(fruit.bells);
        $("#watermelon").text(fruit.watermelon);
        $("#star").text(fruit.star);
        $("#seven").text(fruit.seven);
        $("#bar").text(fruit.bar);
    };

    fruit.fetchGolden = function(){
        $.ajax({
            url : "/fruitAJAX/fetch_golden",
            type: "POST",
            dataType: 'json',
            data: {gold : fruit.current_golden},
            success: function(data){
                if(data.code == "200") {
                    $("#coins").text("000000");
                    $("#lucky_number").text(data.lucky);
                }
            }
        });
    };

    fruit.fetchTop = function () {
        $.ajax({
            url : "/fruitAJAX/fetch_top",
            type: "POST",
            dataType: 'json',
            data: {},
            success: function(data){
                var text = "<tr><td>排名</td><td>用户名</td><td>赢得夺宝币</td></tr>";
                for(var i=0,j=data.length;i<j;i++){
                    text+= "<tr><td>" + (i+1) + "</td><td>" + data[i].phone + "</td><td>" + data[i].income + "</td></tr>";
                }
                $("div.list_sale table tbody").html(text);
            }
        });
    };

    fruit.fetchResult = function(){
        var data = { token : player.token, round : fruit.current_round };
        var token  = player.encrypt(data);
        $.ajax({
            url : "/fruitAJAX/fetch_result",
            type: "POST",
            dataType: 'json',
            data: {user : token, round : fruit.current_round},
            success: function(data){
                if(data.code != "200") {
                    if(data.code == 10003 && data.state == 0){
                        fruit.fetchResult();
                    }
                } else {
                    fruit.status = 2;

                    fruit.lottery.is_luck = data.is_luck;
                    fruit.lottery.stop = data.position;
                    fruit.lottery.code = data.prize_code;

                    fruit.real_time = data.leave_seconds;
                    fruit.current_round = data.current;
                    fruit.begin = data.next_start;
                    player.score = player.score + parseInt(data.reward);
                    player.back_score = player.score;
                    player.back_balance = player.balance;
                    player.reset();
                    fruit.reset();

                    var coins = parseInt($("#coins").text()) + parseInt(data.gold);
                    coins = (Array(6).join("0") + coins).slice(-6);
                    $("#coins").text(coins);

                    if(data.expend > 0) {
                        player.history = parseInt(player.history) + 1;
                        var now = new Date();
                        player.last_record = "<li><p><span class='san'></span>" +
                            "<span>"+now.getFullYear()+'.'+('0' + (now.getMonth()+1)).slice(-2)+"."+('0' + now.getDate()).slice(-2)+"</span><span>共投"+ data.expend +"夺宝币</span></p>" +
                            "<p>开奖结果："+ data.prize_name +" * "+ data.prize_times +"倍</p><p>奖励金额："+ data.reward +"夺宝币</p></li>";
                    } else {
                        player.last_record = "";
                    }
                }
            }
        });
    };

    fruit.reset = function () {
        fruit.apple  = 0;
        fruit.orange = 0;
        fruit.mongo  = 0;
        fruit.bells  = 0;
        fruit.watermelon = 0;
        fruit.star   = 0;
        fruit.seven  = 0;
        fruit.bar    = 0;
        fruit.error_time = 0;
    };

    fruit.join = function(id){
        if (fruit.is_permission == false || fruit.real_time < 1) return false;
        if (player.token == "") {
            location.href = "/login";
            return false;
        }
        if (player.balance + player.score <= 1) {
            player.balanceDialog();
            return false;
        }
        var _this = $("#" + id);
        var i = _this.index() + 1;
        _this.find(".game_center_list_li").css({"background": "rgba(200,230,255,0.3)"});
        setTimeout(function () {
            _this.find("img").attr("src", "/static/images/fulishe/cash_out/centerT" + i + "_1.fw.png");
            _this.find(".game_center_list_li").css({"background": ""});
        }, 100);
        // 获取当前押注类型 (限制每注上限99)
        var fruit_name = _this.attr("class");
        if (player[fruit_name] - 99 == 0) return false;

        var number = player.current;
        if (player.current + player[fruit_name] > 99) {
            number = 99 - player[fruit_name];
        }
        if (player.balance + player.score - number < 0) {
            number = player.balance + player.score;
        }
        number = parseInt(number);

        // 扣款
        if (player.score > 0 && player.score - number >= 0) {
            player.score = player.score - number;
        } else {
            player.balance = formatFloat(formatFloat(player.balance, 2) + formatFloat(player.score, 2) - formatFloat(number, 2), -2);
            player.balance = round(player.balance, 2);
            player.score = 0;
        }

        // 用户押注累积
        player[fruit_name] = player[fruit_name] + number;
        fruit[fruit_name] = fruit[fruit_name] + number;

        _this.find("p").text(player[fruit_name]);
        $("#" + fruit_name).text(fruit[fruit_name]);
        $("#score").text(player.score);
        $("#totalGold").text(player.balance);

        var data = { token : player.token, round : fruit.current_round, type : i, number : number};
        var token  = player.encrypt(data);

        $.ajax({
            url: "/fruitAJAX/join_coin",
            type: "POST",
            dataType: 'json',
            data: {user: token, type: i, num: number},
            success: function (data) {
                if (data.code !== 200) {
                    player.balance = player.back_balance;
                    player.score = player.back_score;
                    player[fruit_name] = player[fruit_name] - number;
                    fruit[fruit_name] = fruit[fruit_name] - number;
                    _this.find("p").text(player[fruit_name]);
                    $("#" + fruit_name).text(fruit[fruit_name]);
                    $("#score").text(player.score);
                    $("#totalGold").text(player.balance);
                } else {
                    player.enable_refund = false;
                }
            }
        });
    };

    fruit.running = function(begin){
        $("div.game_center_main .wins_div.other").hide();
        var i = $("#" + begin).attr("data-num") % 24 + 1;
        $("ul.game_main_list li").removeClass("box_sh");
        var counter = 0;
        var keeper = fruit.keep_round;
        var timer = setInterval(function(){
            ++counter;
            $("ul.game_main_list li.gift" + i).addClass("active").siblings().removeClass("active");
            i = i % 24 + 1;

            if(keeper != fruit.keep_round) clearInterval(timer);
            if(fruit.status > 1 && fruit.lottery.is_luck > 0 && fruit.lottery.code < 16 && parseInt(counter / 24) > 1){
                clearInterval(timer);
                var slow_timer = setInterval(function(){
                    $("ul.game_main_list li.gift" + i).addClass("active").siblings().removeClass("active");
                    if(keeper != fruit.keep_round) clearInterval(slow_timer);
                    if(i == 10) {
                        $("ul.game_main_list li.LUCK").addClass("box_sh");
                        $("ul.game_main_list li.gift" + i).removeClass("active");
                        clearInterval(slow_timer);

                        setTimeout(function(){
                            $("ul.game_main_list li").removeClass("box_sh");
                            var luck_timer = setInterval(function(){
                                $("ul.game_main_list li.gift" + i).addClass("active").siblings().removeClass("active");
                                if(keeper != fruit.keep_round) clearInterval(luck_timer);
                                if(i == fruit.lottery.stop){
                                    $("ul.game_main_list li.gift" + i).removeClass("active");
                                    clearInterval(luck_timer);
                                    fruit.status = 0;
                                    fruit.keep_round = fruit.current_round;
                                    fruit.is_running = false;
                                    $("#score").text(player.score);

                                    $("ul.game_main_list li.gift" + i).addClass("box_sh");

                                    var src = "/static/images/fulishe/cash_out/prize" + fruit.lottery.code + ".png";
                                    $(".win_div_right .win_move_img:eq(0)").before('<p class="win_move_img">' + '<img src="'+ src +'">' + '</p>');
                                    $(".win_div_right .win_move_img:last").remove();
                                }
                                i = i % 24 + 1;
                            }, 150);
                        }, 2000);
                    }
                    i = i % 24 + 1;
                }, 130);
            } else if(fruit.status > 1 && parseInt(counter / 24) > 2){
                clearInterval(timer);
                var slow_timer = setInterval(function(){
                    $("ul.game_main_list li.gift" + i).addClass("active").siblings().removeClass("active");
                    if(keeper != fruit.keep_round) clearInterval(slow_timer);
                    if (i == fruit.lottery.stop) {
                        $("ul.game_main_list li.gift" + i).removeClass("active");
                        clearInterval(slow_timer);
                        fruit.status = 0;
                        fruit.keep_round = fruit.current_round;
                        fruit.is_running = false;
                        $("#score").text(player.score);

                        if(fruit.lottery.code < 16) {
                            $("ul.game_main_list li.gift" + i).addClass("box_sh");
                        } else if(fruit.lottery.code == 18) {
                            $("ul.game_main_list li.APPLE").addClass("box_sh");
                            $(".win_big_xi").show();
                        } else if(fruit.lottery.code == 19) {
                            $("ul.game_main_list li.BIG").addClass("box_sh");
                            $(".win_big_san").show();
                        } else if(fruit.lottery.code == 20) {
                            if(fruit.begin < 10){
                                $("ul.game_main_list li.THREE1").addClass("box_sh");
                            }else{
                                $("ul.game_main_list li.THREE2").addClass("box_sh");
                            }
                            $(".win_simall_san").show();
                        }

                        var src = "/static/images/fulishe/cash_out/prize" + fruit.lottery.code + ".png";
                        $(".win_div_right .win_move_img:eq(0)").before('<p class="win_move_img">' + '<img src="'+ src +'">' + '</p>');
                        $(".win_div_right .win_move_img:last").remove();
                    }
                    i = i % 24 + 1;
                }, 130);
            }
        }, 60);
    };

    fruit.init();
    setInterval(function(){
        var now = new Date();
        if(now.getHours() == "20" && now.getMinutes() == "00" && now.getSeconds() == "02"){
            fruit.fetchGolden();
        }

        if(now.getMinutes() % 10 < 1 && now.getSeconds() == "00") {
            fruit.fetchTop();
        }

        --fruit.real_time;
        if (fruit.real_time < 0 || fruit.real_time > 30) {
            fruit.is_permission = false;
            if(fruit.real_time == -5) {
                fruit.fetchResult();
            }
        } else {
            if(fruit.real_time == 30){
                player.showCurrent();
                fruit.showCurrent();
                player.enable_refund = true;
                player.showRecord();
            }
            $("#leave_seconds").text(fruit.real_time);
            fruit.is_permission = true;
            if(fruit.real_time % 3 == 1) {
                fruit.apple = fruit.apple  + Math.floor(Math.random() * 3 + 1);
                fruit.orange= fruit.orange + Math.floor(Math.random() * 3 + 1);
                fruit.mongo = fruit.mongo  + Math.floor(Math.random() * 3 + 1);
                fruit.bells = fruit.bells  + Math.floor(Math.random() * 3 + 1);
                fruit.star  = fruit.star   + Math.floor(Math.random() * 3 + 1);
                fruit.seven = fruit.seven  + Math.floor(Math.random() * 3 + 1);
                fruit.bar   = fruit.bar    + Math.floor(Math.random() * 3 + 1);
                fruit.watermelon = fruit.watermelon + Math.floor(Math.random() * 3 + 1);

                fruit.showCurrent();
            }

            if(fruit.real_time < 1){
                fruit.is_running = true;
                fruit.running(fruit.begin);
            }
        }
    }, 1000);

    $(function() {
        $("ul.cast_currency_list li").on("click", function () {
            $("ul.cast_currency_list li div").removeClass("active");
            $(this).find("div").addClass("active");
            player.current = parseInt($(this).attr("data-num"));
        });

        $("ul.game_center_list li").on("click", function () {
            var id = $(this).attr("id");
            fruit.join(id);
        });
        $(document).keydown(function(event){
            var e = event || window.event;
            var currKey = e.keyCode || e.which || e.charCode;
            if(currKey >= 49 && currKey <= 56){
                fruit.join("P" + currKey);
            }
        });

        $("#cancelJoin").on("click", function () {
            var timers=setTimeout(function(){
                $(".re_injection").css({"width":"110px","height":"40px","background":"url(/static/images/fulishe/cash_out/chong.fw.png) no-repeat","background-size":"100% 100%"});
            },100)
            $(".re_injection").css({"width":"110px","height":"40px","background":"url(/static/images/fulishe/cash_out/chong_1.fw.png) no-repeat","background-size":"100% 100%"});
            if (player.token == "") {
                location.href = "/login";
                return false;
            }
            if (fruit.is_running == true || fruit.is_permission == false) return false;
            $("ul.game_center_list > li > p").text('0');

            var data = { token : player.token, round : fruit.current_round };
            var token  = player.encrypt(data);

            $.ajax({
                url: "/fruitAJAX/cancel_join",
                type: "POST",
                dataType: 'json',
                data: {user: token},
                success: function (data) {
                    if (data.code !== 200) {
                        player.showCurrent();
                    } else {
                        player.balance = player.back_balance;
                        player.score = player.back_score;

                        $("ul.game_center_list > li > p").text('0');
                        $("#score").text(player.score);
                        $("#totalGold").text(player.balance);

                        fruit.apple = fruit.apple - player.apple;
                        fruit.orange = fruit.orange - player.orange;
                        fruit.mongo = fruit.mongo - player.mongo;
                        fruit.bells = fruit.bells - player.bells;
                        fruit.watermelon = fruit.watermelon - player.watermelon;
                        fruit.star = fruit.star - player.star;
                        fruit.seven = fruit.seven - player.seven;
                        fruit.bar = fruit.bar - player.bar;

                        player.reset();
                        fruit.showCurrent();

                        player.enable_refund = true;
                    }
                }
            });
        });

        $("#refund").on("click", function () {
            var timers=setTimeout(function(){
                $(".return_note").css({"width":"90px","height":"40px","background":"url(/static/images/fulishe/cash_out/tui.fw.png) no-repeat","background-size":"100% 100%"});
            },100)
            $(".return_note").css({"width":"90px","height":"40px","background":"url(/static/images/fulishe/cash_out/tui_1.png) no-repeat","background-size":"100% 100%"});
            if (player.token == "") {
                location.href = "/login";
                return false;
            }
            if (fruit.is_running == true || player.enable_refund == false) return false;
            player.balance = formatFloat(formatFloat(player.balance, 2) + formatFloat(player.score, 2), -2);
            player.balance = round(player.balance, 2);
            player.back_balance = player.balance;
            player.score = 0;
            player.back_score = 0;
            $("#score").text(player.score);
            $("#totalGold").text(player.balance);
        });

        $("#fetchGold").on("click", function(){
            if (player.token == "") {
                location.href = "/login";
                return false;
            }
            if(player.enable_golden == false) {
                $(".received").show();
                return false;
            }
            var now = new Date();
            if(now.getHours() < 10 || now.getHours() > 20) {
                $(".conditions_time_error").show();
                return false;
            }

            var data = {token: player.token, round: fruit.current_round, gold: fruit.current_golden};
            var token = player.encrypt(data);

            $.ajax({
                url: "/fruitAJAX/fetch_golden_number",
                type: "POST",
                dataType: 'json',
                data: {user: token, gold : fruit.current_golden},
                success: function (data) {
                    if (data.code !== 200) {
                        $("#current_coins").text(data.current);
                        $(".conditions_no").show();
                    } else {
                        player.enable_golden = false;
                        $("#number").text(data.number);
                        $("#golden_number").text(data.number);
                        $(".conditions").show();
                    }
                }
            });
        });
    });
</script>
<script>
    $(function(){
/*        // 系统广播轮播
        var _BuyList=$(".carousel_list");
        var Trundle = function () {
            _BuyList.prepend(_BuyList.find("li:last")).css('marginTop', '-48px');
            _BuyList.animate({ 'marginTop': '0px' }, 800);
        };
        var setTrundle = setInterval(Trundle, 2000);
        _BuyList.hover(function () {
            clearInterval(setTrundle);
            setTrundle = null;
        },function () {
            setTrundle = setInterval(Trundle, 2000);
        });*/
        $("#guide").on("click", function(){
            $(".wrap").hide();
            $(".game_rules").show();
        });
        $("#close").on("click", function(){
            $(".game_rules").hide();
            $(".wrap").show();
        });
        $(".list_nav p").click(function(){
            var index = $(this).index();
            $(this).addClass("optive").siblings().removeClass("optive");
            $(".list_div>div").eq(index).show().siblings().hide();
        });
        $(".closes").on("click",function(){
            $(".conditions").hide();
            $(".conditions_no").hide();
            $(".conditions_time_error").hide();
            $(".received").hide();
            $(".short_gold").hide();
        });
        var num=0;
        var length = $(".score_list li").length*800;
        $(".score_list").width(length);
        var timer = setInterval(function(){
                num--;
            if(-num == length){
                num = 300;
              }
            $(".score_list").css({left:num});
        },10)

    })
</script>
</body>
</html>
