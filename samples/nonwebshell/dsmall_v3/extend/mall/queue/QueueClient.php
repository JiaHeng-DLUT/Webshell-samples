<?php
namespace mall\queue;
use app\common\logic\Queue;
use think\Cache;
class QueueClient {


    /**
     * 入列
     * @param string $key
     * @param array $value
     */
    public static function push($key, $value) {
        if(config('cache.type') == 'Redis'){
            //Redis 直接写入缓存
            $QueueClientNum = Cache::inc('QueueClientNum');#缓存的数量
            cache('QueueClient_'.$QueueClientNum, serialize(array($key=>$value)));#写入缓存
        }
        if (config('cache.type') == 'File') {
            //当前缓存类型为本地文件,则直接执行
            $QueueLogic = new Queue();
            $QueueLogic->$key($value);return;
        }
    }
}

?>
