<?php

namespace denis909\yii;

use Yii;

abstract class Job extends \yii\base\BaseObject implements \yii\queue\JobInterface
{

    abstract public function execute($queue);

}