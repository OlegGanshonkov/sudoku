<?php

namespace app\modules\sudoku\controllers\api\v1;

use app\modules\sudoku\models\Grid;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Class GridController
 * @package app\modules\sudoku\controllers\api\v1
 */
class GridController extends Controller
{
    /**
     * Установка цифры
     * @return array
     */
    public function actionPutNum()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $val = Yii::$app->request->post('val');
        $rowKey = Yii::$app->request->post('rowKey');
        $valueKey = Yii::$app->request->post('valueKey');
        $name = Yii::$app->request->post('name');

        $cache = Yii::$app->cache;
        $grid = $cache->get(Grid::KEY_GRID);
        $grid[$rowKey][$valueKey] = (int)$val;
        $cache->set(Grid::KEY_GRID, $grid);
        return $grid;
    }

    /**
     * Начало новой игры
     * @return array
     */
    public function actionNewGame()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cache = Yii::$app->cache;
        $gridModel = New Grid();
        $grid = $gridModel->values;
        $cache->set(Grid::KEY_GRID, $grid);
        return $grid;
    }

    /**
     * Начало новой игры
     * @return bool
     */
    public function actionCheckResult()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $grid = Yii::$app->request->post('grid');
        $name = Yii::$app->request->post('name');

        $result['success'] = false;
        $result['name'] = $name;

        $allPick = $this->checkPickAll($grid);
        if ($allPick === false) {
            return;
        }

        $calc = $this->calc($grid);
        if ($calc) {
            $result['success'] = true;
            $cache = Yii::$app->cache;
            $grid = $cache->get(Grid::KEY_TOP);
            if (isset($grid[$name])) {
                $grid[$name]++;
            } else {
                $grid[$name] = 1;
            }
            $cache->set(Grid::KEY_TOP, $grid);
        }
        return $result;
    }

    /**
     * Проверяем что всё заполнено
     * @param $grid
     * @return bool
     */
    private function checkPickAll($grid)
    {
        $allPick = true;
        foreach ($grid as $row) {
            foreach ($row as $value) {
                if ($value == 0) {
                    $allPick = false;
                    break;
                }
            }
        }
        return $allPick;
    }

    /**
     * Проверяем правильность заполнения
     * @param $grid
     * @return bool
     */
    private function calc($grid)
    {
        return $this->calcRow($grid) && $this->calcColumn($grid) && $this->calcBlock($grid);
    }


    /**
     * Проверяем правильность заполнения строк
     * @param $grid
     * @return bool
     */
    private function calcRow($grid)
    {
        $checkRow = [];
        $result = true;
        foreach ($grid as $key => $row) {
            foreach ($row as $value) {
                if (isset($checkRow[$key][$value])) {
                    $result = false;
                    break;
                } else {
                    $checkRow[$key][$value] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * Проверяем правильность заполнения столбцов
     * @param $grid
     * @return bool
     */
    private function calcColumn($grid)
    {
        $transposing = [];
        foreach ($grid as $key => $value) {
            foreach ($value as $valueKey => $item) {
                $transposing[$valueKey + 1][] = $item;
            }
        }
        return $this->calcRow($transposing);
    }

    /**
     * Проверяем правильность заполнения блока 3х3
     * @param $grid
     * @return bool
     */
    private function calcBlock($grid)
    {
        $block1 = $block2 = $block3 = $block4 = $block5 = $block6 = $block7 = $block8 = $block9 = [];
        $result = true;
        foreach ($grid as $key => $row) {
            foreach ($row as $valueKey => $value) {
                if (in_array($key, Grid::BLOCK_1_ROW) && in_array($valueKey, Grid::BLOCK_1_COLUMN)) {
                    if(isset($block1[$value])){
                        $result = false;
                        break;
                    }
                    $block1[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_2_ROW) && in_array($valueKey, Grid::BLOCK_2_COLUMN)){
                    if(isset($block2[$value])){
                        $result = false;
                        break;
                    }
                    $block2[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_3_ROW) && in_array($valueKey, Grid::BLOCK_3_COLUMN)){
                    if(isset($block3[$value])){
                        $result = false;
                        break;
                    }
                    $block3[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_4_ROW) && in_array($valueKey, Grid::BLOCK_4_COLUMN)){
                    if(isset($block4[$value])){
                        $result = false;
                        break;
                    }
                    $block4[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_5_ROW) && in_array($valueKey, Grid::BLOCK_5_COLUMN)){
                    if(isset($block5[$value])){
                        $result = false;
                        break;
                    }
                    $block5[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_6_ROW) && in_array($valueKey, Grid::BLOCK_6_COLUMN)){
                    if(isset($block6[$value])){
                        $result = false;
                        break;
                    }
                    $block6[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_7_ROW) && in_array($valueKey, Grid::BLOCK_7_COLUMN)){
                    if(isset($block7[$value])){
                        $result = false;
                        break;
                    }
                    $block7[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_8_ROW) && in_array($valueKey, Grid::BLOCK_8_COLUMN)){
                    if(isset($block8[$value])){
                        $result = false;
                        break;
                    }
                    $block8[$value] = $value;
                } elseif(in_array($key, Grid::BLOCK_9_ROW) && in_array($valueKey, Grid::BLOCK_9_COLUMN)){
                    if(isset($block9[$value])){
                        $result = false;
                        break;
                    }
                    $block9[$value] = $value;
                }
            }
        }
        return $result;
    }

}