<?php
namespace luffyzhao\cards\games;

use Exception;
use luffyzhao\cards\games\abstracts\PokerGame;

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
        if (count($this->pokers) != 52) {
            throw new Exception('发牌请先洗牌。');
        }
        $dealStart = $this->getDealStart();
        // 发牌给每个玩家
        $this->players = array_fill(0, $this->playersNum, []);
        for ($i = 0; $i < $this->playerPokerNum; $i++) {
            for ($j = 0; $j < $this->playersNum; $j++) {
                $this->players[$this->getDealPosition($j)]['pokers'][] = array_shift($this->pokers);
            }
        }

        foreach ($this->players as $player => $poker) {
            $this->players[$player]['cattle'] = $this->lookBuff($poker['pokers']);
        }
    }

    /**
     * 看牛
     * @method   lookBuff
     * @DateTime 2017-08-03T15:23:47+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function lookBuff($pokers)
    {
        $cattle = $big = null;
        //
        foreach ($pokers as $poker) {
            if ($big == null) {
                $big = $poker;
            } else {
                if ($big->getValue() < $poker->getValue()) {
                    $big = $poker;
                } else if ($big->getValue() == $poker->getValue()) {
                    $big = ($big->getColorNumber() < $poker->getColorNumber()) ? $poker : $big;
                }
            }
        }

        $eachs = [[0, 1, 2], [0, 1, 3], [0, 1, 4], [0, 2, 3], [0, 2, 4], [0, 3, 4], [1, 2, 3], [1, 2, 4], [1, 3, 4], [2, 3, 4]];

        foreach ($eachs as $item) {
            if (($cattle = $this->cattle($pokers, $item)) !== false) {
                break;
            }
        }

        return [
            'cattle' => $cattle,
            'big' => $big,
        ];
    }

    /**
     * 牛几？
     * @method   cattle
     * @DateTime 2017-08-03T17:52:07+0800
     * @param    [type]                   $pokers [description]
     * @return   [type]                           [description]
     */
    public function cattle($pokers, $item)
    {
        $sum = 0;
        $cattle = 0;
        foreach ($pokers as $key => $poker) {
            $value = $poker->getValue()->getDesc();
            if (in_array($value, ['J', 'Q', 'K'])) {
                $value = 10;
            } else if ($value == 'A') {
                $value = 1;
            }
            // 三位相加
            if (in_array($key, $item)) {
                $sum += $value;
            } else {
                $cattle += $value;
            }

        }
        // 没有牛直接返回false
        if ($sum % 10 !== 0) {
            return false;
        } else {
            return $cattle % 10;
        }
    }
    /**
     * 获取发牌位置
     */
    protected function getDealPosition($position): int
    {
        $dealStart = $this->getDealStart();
        // 开始的位置 + 庄家的位置 + 发牌的位置 % 玩家人数
        return (($dealStart + $this->banker + $position) % $this->playersNum);
    }
    /**
     * 闲家提牌（看先发谁）
     * 当 $start 为 0 时不提牌，直接从庄家开始发
     * @param int $start
     */
    public function payerWash(int $start)
    {
        if ($start > 52 || $start < 0) {
            throw new Exception('提牌不能大于总牌数，不能小于0');
        }
        // 选择不提牌
        if ($start == 0) {
            $this->setDealStart($start);
        } else {
            // 提牌
            $dealStartOriginal = $this->pokers[$start];
            $this->setDealStart($dealStartOriginal->getNumber() % $this->playersNum);

            $array1 = array_slice($this->pokers, 0, $start);
            $array2 = array_slice($this->pokers, $start);
            // 提牌之后把牌交换搁置
            $this->pokers = array_merge($array2, $array1);
        }
    }

    /**
     * 获取庄家
     * @return int
     */
    public function getBanker(): int
    {
        return $this->banker;
    }

    /**
     * 设置庄家
     * @param $banker
     */
    public function setBanker(int $banker)
    {
        $this->banker = $banker;
    }
}
