<?php
namespace luffyzhao\cards\player;

/**
 * 玩家
 */
class Player
{
    protected $userInfo;
    /**
     * 玩家构造
     * @method   __construct
     * @DateTime 2017-08-09T17:48:07+0800
     * @param    [type]                   $userInfo 玩家信息
     */
    public function __construct($userInfo)
    {
        $this->userInfo = $userInfo;
    }

}
