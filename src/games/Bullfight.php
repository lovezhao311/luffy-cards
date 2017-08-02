<?php
namespace luffyzhao\cards\games;

use luffyzhao\cards\games\abstracts\PokerGame;
use Exception;

/**
 * 斗牛
 */
class Bullfight extends PokerGame
{
    /**
     * 玩家数量
     */
    protected $playersNum = 4;
    /**
     * 是否算上大小王
     * @var bool
     */
    protected $isContainGhosts = false;
    /**
     * 每人发牌数量
     * @var int
     */
    protected $playerPokerNum = 5;
    /**
     * 庄家位置
     * @var int
     */
    protected $banker = 0;


    /**
     * 发牌（斗牛是一次发完）
     * @param int $start
     * @return array
     * @throws Exception
     */
    public function deal()
    {
        // 发牌前先洗牌
        if(count($this->pokers) != 52){
            throw new Exception('发牌请先洗牌。');
        }
        $dealStart = $this->getDealStart();
        // 发牌给每个玩家
        $this->players = array_fill(0, $this->playersNum,[]);
        for ($i=0; $i < $this->playerPokerNum; $i++){
            for ($j = 0; $j < $this->playersNum; $j++){
                $this->players[$this->getDealPosition($j)][] = array_shift($this->pokers);
            }
        }
        return $this->players;
    }

    /**
     * 获取发牌位置
     */
    protected function getDealPosition($position): int{
        $dealStart = $this->getDealStart();
        // 开始的位置 + 庄家的位置 + 发牌的位置 % 玩家人数
        return (($dealStart  + $this->banker + $position) % $this->playersNum);
    }
    /**
     * 闲家提牌（看先发谁）
     * 当 $start 为 0 时不提牌，直接从庄家开始发
     * @param int $start
     */
    public function payerWash(int $start){
        if($start > 52 || $start < 0){
            throw new Exception('提牌不能大于总牌数，不能小于0');
        }
        // 选择不提牌
        if($start == 0){
            $this->setDealStart($start);
        }else{
            // 提牌
            $dealStartOriginal = $this->pokers[$start];
            $this->setDealStart($this->pokerToNum($dealStartOriginal) % $this->playersNum);

            $array1 = array_slice($this->pokers, 0, $start);
            $array2 = array_slice($this->pokers, $start);
            // 提牌之后把牌交换搁置
            $this->pokers = array_merge($array2,$array1);
        }
    }

    /**
     * 获取庄家
     * @return int
     */
    public function getBanker():int{
        return $this->banker;
    }

    /**
     * 设置庄家
     * @param $banker
     */
    public function setBanker(int $banker){
        $this->banker = $banker;
    }
}

