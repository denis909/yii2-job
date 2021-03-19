<?php

namespace denis909\yii;

use Yii;
use yii\queue\JobInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

abstract class Job extends \yii\base\BaseObject implements JobInterface, LoggerAwareInterface 
{

    use LoggerAwareTrait;

    protected $channel;

    abstract public function execute($queue);

    public function init()
    {
        parent::init();

        $this->setLogger(new NullLogger);
    }

    public function push($queue = null)
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