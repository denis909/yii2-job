<?php

namespace denis909\yii;

use Yii;

abstract class Job extends \yii\base\BaseObject implements \yii\queue\JobInterface
{

    abstract public function execute($queue);

    public function push($queue)
    {
        if (!$queue)
        {
            $queue = Yii::$app->queue;
        }

        $queue->push($this);
    }

}