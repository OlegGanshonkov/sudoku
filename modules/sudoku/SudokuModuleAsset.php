<?php

namespace app\modules\sudoku;

use yii\web\AssetBundle;
use Yii;

/**
 * Общий бандл для модуля.
 */
class SudokuModuleAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/sudoku/assets';
    /**
     * @var array
     */
    public $css = [
        'css/style.css'
    ];
    /**
     * @var array
     */
    public $js = [
        'js/sudoku.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $publishOptions = [
        'forceCopy' => true,
    ];
}