<?php

namespace app\modules\sudoku;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Sudoku module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\sudoku\controllers';

    /**
     * @var string $layout по умолчанию
     */
    public $layout = '@sudoku/views/layouts/base';

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\sudoku\commands';
        } else {
            Yii::setAlias('sudoku', dirname(__DIR__) . '/sudoku');
            $app->getUrlManager()->addRules(require(__DIR__ . '/config/routes.php'), false);
        }

    }

}
