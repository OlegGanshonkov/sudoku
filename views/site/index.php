<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <p class="lead"><a href="/sudoku">Перейти в игру Судоку</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <p><b>Тестовое задание:</b></p>
            <p>
                Задание
            </p>
            <p>
                Написать Игру судоку с конкурентной борьбой.
            </p>
            <p>
                Должен быть реализован бэкэнд с WebSockets с методами: начало новой игры, добавить результат, топ
                игроков (хранить результаты можно в кэше сервера).
                Должен быть простой фронт с полями под игру, полем для имени, кнопками начать и просмотр топ.
            </p>
            <p>
                Логика:
            </p>
            <p>
                Несколько вкладок играют в конкурентное судоку, то есть одна текущая игра на всех.
                Каждый имеет право поставить в свободную ячейку.
                Кто первый поставит последнюю цифру и судоку посчитается правильно, тот и победил.
                Любая цифра, поставленная на поле, должна отобразиться у других без возможности изменения.
            </p>
            <p>
                Красивый фронт не нужен, так как это дело вкуса.
            </p>
            <p><b>Запуск:</b></p>
            <p>
                docker-compose run --rm php composer update --prefer-dist<br/>
                docker-compose run --rm php composer install<br/>
                docker-compose up -d<br/>
                docker-compose exec php php yii sudoku/socket/start
            </p>
        </div>
    </div>
