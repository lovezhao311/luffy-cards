<?php

include '../vendor/autoload.php';

use luffyzhao\cards\games\Bullfight;
use luffyzhao\cards\player\Player;
use luffyzhao\cards\seat\Seat;

$seat = Seat::instance(1001);

// 设置玩家人数
$seat->setPlayerNumber(4);

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

    $bull = $seat->addGames(new Bullfight());
    // 设置庄家
    // $bull->setBanker(1);
    // 洗牌
    $bull->wash();
    // 提牌(看谁先发)
    $bull->payerWash(5);
    // 发牌
    $bull->deal();

    $seat->delPlayerForIndex(2);
    $seat->bindCards();
    // 某个人的牛
    // print_r($seat->getPlayerForIndex(1));
    // 全部人的牛
    print_r($seat->getLists());
}
