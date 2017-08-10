<?php
namespace luffyzhao\cards\poker;

use luffyzhao\cards\poker\enums\Color;
use luffyzhao\cards\poker\enums\Value;

/**
 * 扑克
 */
class Poker
{
    /**
     * 扑克花色
     */
    private $color;

    /**
     * 扑克数值
     */
    private $value;
    /**
     * 扑克
     * @method   __construct
     * @DateTime 2017-08-02T13:59:45+0800
     * @param    Color                    $color [description]
     * @param    Value                    $value [description]
     */
    public function __construct(Color $color, Value $value)
    {
        $this->color = $color;
        $this->value = $value;
    }
    /**
     * 获取花色
     * @method   getColor
     * @DateTime 2017-08-02T14:01:24+0800
     * @return   [type]                   [description]
     */
    public function getColor()
    {
        return $this->color;
    }
    /**
     * 设置花色
     * @method   setColor
     * @DateTime 2017-08-02T14:01:33+0800
     * @param    Color                    $color [description]
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
    }
    /**
     * 获取花色
     * @method   getValue
     * @DateTime 2017-08-02T14:02:12+0800
     * @return   [type]                   [description]
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * 获取扑克花色数值
     * @method   getColorNumber
     * @DateTime 2017-08-03T17:38:16+0800
     * @return   [type]                   [description]
     */
    public function getColorNumber()
    {

        switch ($this->color->getDesc()) {
            case '黑桃':
                return 4;
                break;
            case '红桃':
                return 3;
                break;
            case '梅花':
                return 2;
                break;
            case '方片':
                return 1;
                break;
        }
    }
    /**
     * 获取扑克数值
     * @method   getNumber
     * @DateTime 2017-08-03T15:32:22+0800
     * @return   [type]                   [description]
     */
    public function getNumber()
    {
        switch ($this->value->getDesc()) {
            case 'A':
                return 1;
                break;
            case 'J':
                return 11;
                break;
            case 'Q':
                return 12;
                break;
            case 'K':
                return 13;
                break;
            case '大王':
                return 1;
                break;
            case '小王':
                return 2;
                break;
            default:
                return $this->value->getDesc();
                break;
        }
    }
    /**
     * 设置花色
     * @method   setValue
     * @DateTime 2017-08-02T14:02:22+0800
     * @param    Value                    $value [description]
     */
    public function setValue(Value $value)
    {
        $this->value = $value;
    }
    /**
     * 转数组
     * @method   toArray
     * @DateTime 2017-08-02T14:09:39+0800
     * @return   [type]                   [description]
     */
    public function toArray()
    {
        return [
            'color' => $this->color->getDesc(),
            'value' => $this->value->getDesc(),
        ];
    }
    /**
     * 转字符串
     * @method   __toString
     * @DateTime 2017-08-02T14:03:11+0800
     * @return   string                   [description]
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
