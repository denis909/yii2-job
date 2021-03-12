<?php

namespace denis909\yii;

use Yii;

abstract class Job extends \yii\base\BaseObject implements \yii\queue\JobInterface
{

    protected $channel;

    abstract public function execute($queue);

    public function push($queue)
    {
        if (!$queue)
        {
            $queue = Yii::$app->queue;

            $channel = $queue->channel; // save channel

            if ($this->channel)
            {
                $queue->channel = $this->channel;
            }

            $return = $queue->push($this);

            $queue->channel = $channel; // restore channel
        
            return $return;
        }

        return $queue->push($this);
    }

}