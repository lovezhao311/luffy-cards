<?php
namespace luffyzhao\cards\seat;

use Exception;
use luffyzhao\cards\games\abstracts\PokerGame;
use luffyzhao\cards\player\Player;

/**
 * 座位抽象类
 */
class Seat
{
    protected static $instance = null;
    /**
     * 玩家人数
     * @var int
     */
    protected $playerNumber = 0;
    /**
     * 玩家集合
     * @var array
     */
    protected $list = [];
    /**
     * 是否开始
     * @var bool
     */
    protected $isbegin = false;
    /**
     * 正在进行的游戏
     * @var null
     */
    protected $games = null;
    /**
     * 座位构造
     * @method   __construct
     * @DateTime 2017-08-09T18:01:39+0800
     * @param    Player                   $player [description]
     */
    protected function __construct()
    {
    }
    /**
     * 设置玩家人数
     * @method   setPlayerNumber
     * @DateTime 2017-08-10T10:58:31+0800
     * @param    [type]                   $playerNumber [description]
     */
    public function setPlayerNumber($playerNumber)
    {
        $this->playerNumber = $playerNumber;
    }
    /**
     * 禁止克隆
     * @method   __clone
     * @DateTime 2017-08-10T09:20:24+0800
     * @return   [type]                   [description]
     */
    protected function __clone()
    {}
    /**
     * 单例模式
     * @method   instance
     * @DateTime 2017-08-10T09:19:50+0800
     * @param    [type]                   $seatid       桌位编号
     * @return   [type]                                 [description]
     */
    public static function instance($seatid)
    {
        if (!isset(self::$instance[$seatid]) || self::$instance[$seatid] === null) {
            self::$instance[$seatid] = new static();
        }
        return self::$instance[$seatid];
    }
    /**
     * 删除桌子
     * @method   uninstance
     * @DateTime 2017-08-10T16:25:54+0800
     * @param    [type]                   $seatid [description]
     * @return   [type]                           [description]
     */
    public static function uninstance($seatid)
    {
        if (isset(self::$instance[$seatid])) {
            unset(self::$instance[$seatid]);
        }
    }
    /**
     * 添加玩家（分配座位）
     * @method   addPlayer
     * @DateTime 2017-08-10T09:15:15+0800
     * @param    Player                   $player [description]
     */
    public function addPlayer(Player $player)
    {
        if ($this->playerNumber <= count($this->list)) {
            throw new Exception("人满了");
        }
        // 安排座位
        for ($i = 0; $i < $this->playerNumber; $i++) {
            if (!isset($this->list[$i])) {
                // 玩家信息
                $this->list[$i]['player'] = $player;
                // 是否准备好
                $this->list[$i]['isready'] = false;
                // 手牌
                $this->list[$i]['cards'] = null;
                // 是否掉线
                $this->list[$i]['isdropped'] = false;
                return $i;
            }
        }
        throw new Exception("座位分配失败");
    }
    /**
     * 删除玩家（玩家退出）
     * @method   delPlayer
     * @DateTime 2017-08-10T09:22:30+0800
     * @param    Player                   $player [description]
     * @return   [type]                           [description]
     */
    public function delPlayer(Player $player)
    {

        foreach ($this->list as $key => $value) {
            if ($player === $value['player']) {
                if ($this->isbegin === true) {
                    $this->list[$key]['isdropped'] = true;
                } else {
                    unset($this->list[$key]);
                }
                return true;
            }
        }
        throw new Exception("玩家不存在");
    }
    /**
     * 利用下标删除玩家（玩家退出）
     * @method   delPlayerForIndex
     * @DateTime 2017-08-10T09:24:02+0800
     * @param    int                      $index [description]
     * @return   [type]                          [description]
     */
    public function delPlayerForIndex(int $index)
    {
        if (isset($this->list[$index])) {
            if ($this->isbegin === true) {
                $this->list[$index]['isdropped'] = true;
            } else {
                unset($this->list[$index]);
            }
            return true;
        }
        throw new Exception("玩家不存在");
    }
    /**
     * 准备
     * @method   ready
     * @DateTime 2017-08-10T09:38:03+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function ready(Player $player)
    {
        if ($this->isbegin === true) {
            return true;
        }
        foreach ($this->list as $key => $value) {
            if ($value['player'] == $player) {
                $this->list[$key]['isready'] = true;
                return true;
            }
        }
        throw new Exception("玩家不存在");
    }

    /**
     * 利用下标准备
     * @method   ready
     * @DateTime 2017-08-10T09:38:03+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function readyForIndex($index)
    {
        if ($this->isbegin === true) {
            return true;
        }
        foreach ($this->list as $key => $value) {
            if ($key == $index) {
                $this->list[$index]['isready'] = true;
                return true;
            }
        }
        throw new Exception("玩家不存在");
    }
    /**
     * 取消准备
     * @method   unready
     * @DateTime 2017-08-10T09:43:35+0800
     * @param    Player                   $player [description]
     * @return   [type]                           [description]
     */
    public function unready(Player $player)
    {
        if ($this->isbegin === true) {
            return true;
        }
        foreach ($this->list as $key => $value) {
            if ($value['player'] == $player) {
                $this->list[$key]['isready'] = false;
                return true;
            }
        }
        throw new Exception("玩家不存在");
    }

    /**
     * 取消准备
     * @method   unready
     * @DateTime 2017-08-10T09:43:35+0800
     * @param    Player                   $player [description]
     * @return   [type]                           [description]
     */
    public function unreadyForIndex($index)
    {
        // 开始了就不能取消准备了
        if ($this->isbegin === true) {
            return true;
        }
        foreach ($this->list as $key => $value) {
            if ($key == $index) {
                $this->list[$index]['isready'] = false;
                return true;
            }
        }
        throw new Exception("玩家不存在");
    }
    /**
     * 是否可以开始游戏（人员齐并准备好）
     * @method   isbegin
     * @DateTime 2017-08-10T09:45:16+0800
     * @return   [type]                   [description]
     */
    public function isbegin()
    {
        if ($this->isbegin === true) {
            return true;
        }

        $beginNumber = 0;
        foreach ($this->list as $key => $value) {
            if ($value['isready'] === true) {
                $beginNumber++;
            }
        }

        if ($beginNumber == $this->playerNumber) {
            $this->isbegin = true;
            return true;
        } else {
            return false;
        }
    }
    /**
     * 获取座位的信息
     * @method   getPlayer
     * @DateTime 2017-08-10T10:24:42+0800
     * @param    [type]                   $index [description]
     * @return   [type]                          [description]
     */
    public function getPlayerForIndex($index)
    {
        if (isset($this->list[$index])) {
            return $this->list[$index];
        }
        throw new Exception("玩家不存在");
    }
    /**
     * 获取座位的信息
     * @method   getPlayer
     * @DateTime 2017-08-10T10:24:42+0800
     * @param    [type]                   $index [description]
     * @return   [type]                          [description]
     */
    public function getPlayer(Player $player)
    {
        foreach ($this->list as $key => $value) {
            if ($value['player'] == $player) {
                return $value;
            }
        }
        throw new Exception("玩家不存在");
    }
    /**
     * 添加游戏
     * @method   addGames
     * @DateTime 2017-08-10T11:02:12+0800
     * @param    [type]                   $games [description]
     * @return   [type]                          [description]
     */
    public function addGames($games)
    {
        if ($games instanceof PokerGame) {
            $this->games = $games;
            return $this->games;
        }

        throw new Exception("游戏不存在");
    }
    /**
     * 获取所有玩家信息
     * @method   getLists
     * @DateTime 2017-08-10T11:13:49+0800
     * @return   [type]                   [description]
     */
    public function getLists()
    {
        return $this->list;
    }
    /**
     * 把牌绑定座位
     * @method   bindCards
     * @DateTime 2017-08-10T10:09:15+0800
     * @param    [type]                   $cards [description]
     * @return   [type]                          [description]
     */
    public function bindCards()
    {
        $cards = $this->games->getPlayers();
        foreach ($cards as $key => $value) {
            if (!isset($this->list[$key])) {
                throw new Exception("绑定座位失败。");
            }
            $this->list[$key]['cards'] = $value;
        }
    }
    /**
     * 重新开始（一局结束后）
     * @method   reset
     * @DateTime 2017-08-10T16:18:39+0800
     * @return   [type]                   [description]
     */
    public function reset()
    {
        foreach ($this->list as $key => $value) {
            if ($value['isdropped'] === true) {
                unset($this->list[$key]);
                continue;
            }
            $value['isready'] = false;
        }
    }
}
