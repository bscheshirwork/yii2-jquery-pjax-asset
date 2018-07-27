<?php

namespace bscheshirwork\y2jpa;

use yii\web\AssetBundle;

/**
 * Origin defunkt/jquery-pjax (throw npm-asset/jquery-pjax) asset bundle.
 */
class PjaxAsset extends AssetBundle
{
    public $sourcePath = '@npm/jquery-pjax';
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->js[] = 'jquery.pjax.js';
    }
}
