<?php
namespace luffyzhao\cards\games\abstracts;

use luffyzhao\cards\poker\Poker;
use luffyzhao\cards\poker\enums\Color;
use luffyzhao\cards\poker\enums\Value;
/**
 * 扑克类游戏抽象类
 */
abstract class PokerGame
{
    /**
     * 玩家数量，默认是4
     */
    protected $playersNum = 4;
    /**
     * 扑克牌副数，默认是1
     */
    protected $setsNum = 1;
    /**
     * 游戏牌的集合（底牌）
     */
    protected $pokers = [];
    /**
     * 玩家手牌的集合
     */
    protected $players = [];
    /**
     * 每人发牌数量
     * @var int
     */
    protected $playerPokerNum = 0;
    /**
     * 是否算上大小王，默认为false
     */
    protected $isContainGhosts = false;
    /**
     * 可用扑克数值
     * @var array
     */
    private $pokersColor = ['黑桃', '红桃', '梅花', '方片'];
    /**
     * 可用扑克花色
     * @var array
     */
    private $pokersValue = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', '小王', '大王'];

    /**
     * 从谁开始发牌
     * @var int
     */
    protected $dealStart = 1;
    /**
     * 发牌
     * @param int $start 从谁开始发
     * @return mixed
     */
    abstract protected function deal();

    /**
     * 生成牌(洗牌)
     */
    public function wash(){
        $pokers = [];
        // 大小王
        if($this->getIsContainGhosts()){
            $pokers[] = new Poker(new Color(), new Value('大王'));
            $pokers[] = new Poker(new Color(), new Value('小王'));
        }
        // 数字牌
        $values = $this->getPokersValue();
        $colors = $this->getPokersColor();
        foreach ($values as $value){
            if($value == '大王' || $value == '小王'){
                continue;
            }
            foreach ($colors as $color){
                $pokers[] = new Poker(new Color($color), new Value($value));
            }
        }
        // 用牌副数
        $pokersMerge = [];
        if($this->getSetsNum() > 1){
            for ($i = 1; $i < $this->getSetsNum(); $i++){
                $pokersMerge = array_merge($pokersMerge,$pokers);
            }
        }else{
            $pokersMerge = $pokers;
        }
//        shuffle($pokersMerge);
        $this->pokers = $pokersMerge;
    }
    /**
     * 获取是否算上大小王
     * @return mixed
     */
    public function getIsContainGhosts()
    {
        return $this->isContainGhosts;
    }

    /**
     * 设置是否算上大小王
     * @param mixed $isContainGhosts
     */
    public function setIsContainGhosts(bool $isContainGhosts)
    {
        $this->isContainGhosts = $isContainGhosts;
    }

    /**
     * 获取玩家的集合
     * @return mixed
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * 设置玩家的集合
     * @param mixed $players
     */
    public function setPlayers(array $players)
    {
        $this->players = $players;
    }

    /**
     * 获取玩家数量
     * @return mixed
     */
    public function getPlayersNum()
    {
        return $this->playersNum;
    }

    /**
     * 设置玩家数量
     * @param mixed $playersNum
     */
    public function setPlayersNum(int $playersNum)
    {
        $this->playersNum = $playersNum;
    }

    /**
     *  获取底牌
     * @return mixed
     */
    public function getPokers()
    {
        return $this->pokers;
    }

    /**
     * @param mixed $pokers
     */
    public function setPokers($pokers)
    {
        $this->pokers = $pokers;
    }

    /**
     * 获取扑克副数
     * @return mixed
     */
    public function getSetsNum()
    {
        return $this->setsNum;
    }

    /**
     * 设置扑克副数
     * @param mixed $setsNum
     */
    public function setSetsNum(int $setsNum)
    {
        $this->setsNum = $setsNum;
    }

    /**
     * 获取可用扑克数值
     * @return array
     */
    public function getPokersValue(): array
    {
        return $this->pokersValue;
    }

    /**
     * 设置可用扑克数值
     * @param array $pokersValue
     */
    public function setPokersValue(array $pokersValue)
    {
        $this->pokersValue = $pokersValue;
    }

    /**
     * 获取扑克花色
     * @return array
     */
    public function getPokersColor(): array
    {
        return $this->pokersColor;
    }

    /**
     * 设置可用数值
     * @param array $pokersColor
     */
    public function setPokersColor(array $pokersColor)
    {
        $this->pokersColor = $pokersColor;
    }

    /**
     * 获取每人发牌数量
     * @return int
     */
    public function getPlayerPokerNum(): int
    {
        return $this->playerPokerNum;
    }

    /**
     * 设置每人发牌数量
     * @param int $playerPokerNum
     */
    public function setPlayerPokerNum(int $playerPokerNum)
    {
        $this->playerPokerNum = $playerPokerNum;
    }

    /**
     * 获取发牌位置
     * @return int
     */
    public function getDealStart(): int
    {
        return $this->dealStart;
    }

    /**
     * 设置从谁开始发牌
     * @param int $dealStart
     */
    public function setDealStart(int $dealStart)
    {
        $this->dealStart = $dealStart;
    }

    /**
     * 扑克转数字
     * @param $value
     */
    protected function pokerToNum(Poker $value){
        if($value->getValue() == '大王' || $value->getValue() == '小王'){
            $index = 1;
        }else{
            $values = $this->getPokersValue();
            $index = array_search($value->getValue(), $values);
        }
        return $index + 1;
    }

}
