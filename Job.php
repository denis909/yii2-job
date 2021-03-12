<?php

namespace denis909\yii;

use Yii;

abstract class Job extends \yii\base\BaseObject implements \yii\queue\JobInterface
{

    public $queueComponent = 'queue';

    abstract public function execute($queue);

    public function push($queue)
    {
        if (!$queue)
        {
            $queue = Yii::$app->{$this->queueComponent};
        }

        $queue->push($this);
    }

}