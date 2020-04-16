<?php
/**
 * @var $this \yii\web\View
 * @var $grid Array;
 */

use app\modules\sudoku\models\Grid;
use app\modules\sudoku\SudokuModuleAsset;

SudokuModuleAsset::register($this);
$this->title = 'Тестовое задание';
?>

<div id="main">
    <div class="btns">
        <div>
            <p>Имя: <input type="text" name="name" id="name"></p>
            <p><button onclick="sudoku.newGame();">Начало новой игры</button></p>
            <p><button onclick="window.location.href='/sudoku/top'">Просмотр топ</button></p>
        </div>
    </div>

    <h1 id="result"></h1>
    <table id="sudokuGrid">
        <tbody>
        <?php foreach ($grid as $rowKey => $row): ?>
            <tr>
                <?php foreach ($row as $valueKey => $value): ?>
                    <td data-row-id="<?= $rowKey; ?>" data-cell-id="<?= $valueKey; ?>"
                        class="<?php if (empty($value)): ?> empty <?php endif; ?>"
                        onclick="num.showNum(this);"><?= $value === 0 ? '' : $value; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div id="num">
        <?php for ($i = 1; $i <= 9; $i++): ?>
            <a onclick="num.putNum(<?= $i; ?>);"><?= $i; ?></a>
        <?php endfor; ?>
    </div>
</div>

