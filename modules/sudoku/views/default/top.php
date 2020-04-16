<?php
/**
 * @var $this \yii\web\View
 * @var $top Array;
 */

use app\modules\sudoku\models\Grid;
use app\modules\sudoku\SudokuModuleAsset;

SudokuModuleAsset::register($this);
$this->title = 'Тестовое задание: Топ';
?>

<div id="main">
    <div class="btns">
        <div>
            <p><button onclick="window.location.href='/sudoku'">Вернуться в игру</button></p>
        </div>
    </div>
    <?php if (empty($top)): ?>
        Нет результатов
    <?php endif; ?>
    <table>
        <tbody>
        <?php foreach ($top as $name => $val): ?>
            <tr>
                <td><?= $name; ?>: </td>
                <td><?= $val; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

