<?php

namespace app\modules\sudoku\models;

use yii\base\Model;

/**
 * This is the model class for Grid
 *
 * @property array $values
 */
class Grid extends Model
{
    const KEY_GRID = 'grid';
    const KEY_TOP = 'top';
    
    const BLOCK_1_ROW = [1,2,3];
    const BLOCK_1_COLUMN = [0,1,2];
    const BLOCK_2_ROW = [1,2,3];
    const BLOCK_2_COLUMN = [3,4,5];
    const BLOCK_3_ROW = [1,2,3];
    const BLOCK_3_COLUMN = [6,7,8];
    const BLOCK_4_ROW = [4,5,6];
    const BLOCK_4_COLUMN = [0,1,2];
    const BLOCK_5_ROW = [4,5,6];
    const BLOCK_5_COLUMN = [3,4,5];
    const BLOCK_6_ROW = [4,5,6];
    const BLOCK_6_COLUMN = [6,7,8];
    const BLOCK_7_ROW = [7,8,9];
    const BLOCK_7_COLUMN = [0,1,2];
    const BLOCK_8_ROW = [7,8,9];
    const BLOCK_8_COLUMN = [3,4,5];
    const BLOCK_9_ROW = [7,8,9];
    const BLOCK_9_COLUMN = [6,7,8];

    /**
     * @var array
     */
    private $_values = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (empty($this->_values)) {
            $this->setValues($this->generate());
        }
        $this->shuffleGrid();
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->_values;
    }

    /**
     * @param $values
     */
    public function setValues($values)
    {
        $this->_values = $values;
    }

    /**
     * Размещаем в первую строку 1 2… 8 9, в строках ниже смещаем на 3 позиции влево, т.е. 4 5… 2 3 и 7 8… 5 6.
     * Далее переходя в следующий район по вертикали смещаем на 1 позицию влево предыдущий район.
     * @return array
     */
    private function generate()
    {
        $result = [];
        $key = 0;
        for ($a = 0; $a < 3; $a++) {
            for ($b = 0; $b < 3; $b++) {
                $key++;
                $i = $a;
                $z = $b;
                for ($c = 1; $c <= 9; $c++) {
                    $i++;
                    $res = $i + $z * 3;
                    if ($res > 9) {
                        $res = $i = 1;
                        $z = 0;
                    }
                    $result[$key][] = $res;
                }
            }
        }
        return $result;
    }

    /**
     * Перетасовать сетку
     */
    private function shuffleGrid()
    {
        rand(0, 1) === 1 ? $this->values : $this->transposing();
        $this->transposing();
        $this->removeCell();
        $this->setValues($this->values);
    }

    /**
     * Транспонирование всей таблицы — столбцы становятся строками и наоборот
     */
    private function transposing()
    {
        $result = [];
        foreach ($this->values as $key => $value) {
            foreach ($value as $valueKey => $item) {
                $result[$valueKey+1][] = $item;
            }
        }
        $this->setValues($result);
    }

    /**
     * Обмен двух строк в пределах одного района
     */
    private function swapRowsSmall()
    {
    }

    /**
     * Обмен двух столбцов в пределах одного района
     */
    private function swapCOLUMNsSmall()
    {
    }

    /**
     * Удаляем рандомно клетки
     */
    private function removeCell()
    {
        $result = $this->values;
        foreach ($result as $key => $value) {
            for ($i = 0; $i < 3; $i++) {
                $removeKey = rand(0,8);
                $result[$key][$removeKey] = 0;
            }
        }
        $this->setValues($result);
    }
}
