<?php
namespace luffyzhao\cards\poker\enums;

use Exception;

/**
 * 扑克数值枚举
 */
class Value
{
    private $desc;

    public function __construct(String $desc)
    {
        if (!in_array($desc, ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', '小王', '大王'])) {
            throw new Exception('扑克数值不正确！');
        }
        $this->desc = $desc;
    }
    /**
     * 获取数值
     * @method   getDesc
     * @DateTime 2017-08-02T12:26:40+0800
     * @return   [type]                   [description]
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * 转字符串
     * @method   __toString
     * @DateTime 2017-08-02T14:03:11+0800
     * @return   string                   [description]
     */
    public function __toString()
    {
        return $this->desc;
    }
}
