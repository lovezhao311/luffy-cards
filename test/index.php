<?php

include '../vendor/autoload.php';

use luffyzhao\cards\games\Bullfight;
use luffyzhao\cards\player\Player;
use luffyzhao\cards\seat\Seat;

$seat = Seat::instance(4);

$seat->addPlayer(new Player(1));
// 玩家1准备
$seat->readyForIndex(0);
if ($seat->isbegin()) {
    // 每次有玩家准备都要检查是否可以开始游戏
}
$seat->addPlayer(new Player(2));
$seat->addPlayer(new Player(3));
$seat->addPlayer(new Player(4));
// 玩家2准备
$seat->readyForIndex(2);
// 玩家2退出
$seat->delPlayerForIndex(2);
$seat->addPlayer(new Player(6));
// 玩家4退出
$seat->delPlayerForIndex(3);
$seat->addPlayer(new Player(7));

$seat->readyForIndex(1);
if ($seat->isbegin()) {
    // 每次有玩家准备都要检查是否可以开始游戏
}
$seat->readyForIndex(2);
if ($seat->isbegin()) {
    // 每次有玩家准备都要检查是否可以开始游戏
}
$seat->readyForIndex(3);
// 准备好之后发牌
if ($seat->isbegin()) {
    $bull = new Bullfight();
    // 设置庄家
    // $bull->setBanker(1);
    // 洗牌
    $bull->wash();
    // 提牌(看谁先发)
    $bull->payerWash(5);
    // 发牌
    $bull->deal();
    // 玩家手中的牌
    // $er = $bull->getPlayers();
    // 玩家手里的牛
    $cards = $bull->turn();
    // 把生成的牌
    $seat->bindCards($cards);
    // 掉线
    $seat->delPlayerForIndex(2);
    print_r($seat);
}
