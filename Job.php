<?php

namespace denis909\yii;

use Yii;
use yii\queue\Queue;
use yii\queue\JobInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

abstract class Job extends \yii\base\BaseObject implements JobInterface, LoggerAwareInterface 
{

    use LoggerAwareTrait;

    protected $channel;

    protected $priority = 1024;

    abstract public function execute($queue);

    public function init()
    {
        parent::init();

        $this->setLogger(new NullLogger);
    }

    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function push(Queue $queue)
    {
        $channel = $queue->channel; // save channel

        if ($this->channel)
        {
            $queue->channel = $this->channel;
        }

        $return = $queue->priority($this->priority)->push($this);

        $queue->channel = $channel; // restore channel
    
        return $return;
    }

}