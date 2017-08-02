<?php
namespace luffyzhao\cards\poker\enums;

use Exception;

/**
 * 花色枚举
 */
class Color
{
    private $desc;

    public function __construct(String $desc = null)
    {
        if (!in_array($desc, ['黑桃', '红桃', '梅花', '方片']) && $desc !== null) {
            throw new Exception('扑克花色不正确！');
        }
        $this->desc = $desc;
    }
    /**
     * 获取花色说明
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
