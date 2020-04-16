<?php

namespace app\modules\sudoku\controllers;

use Yii;
use app\modules\sudoku\models\Grid;
use yii\web\Controller;

/**
 * Default controller for the `sudoku` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $cache = Yii::$app->cache;
        $gridModel = New Grid();

        $grid = $cache->get(Grid::KEY_GRID);
        if ($grid === false) {
            $grid = $gridModel->values;
            $cache->set(Grid::KEY_GRID, $grid);
        }

        return $this->render('index', ['grid' => $grid]);
    }

    /**
     * Renders the top view for the module
     * @return string
     */
    public function actionTop()
    {
        $cache = Yii::$app->cache;
        $top = $cache->get(Grid::KEY_TOP);

        return $this->render('top', ['top' => $top ? $top : []]);
    }

}
