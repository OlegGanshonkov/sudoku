"use strict";

let num = {};
num = {
    init: function (socket) {
        this.currentElement = null;
        this.socket = socket;
    },
    hideNum: function () {
        $("#num").offset({top: 10000});
    },
    showNum: function (el) {
        el = $(el);
        let html = el.html();
        if (html.length > 0) {
            return;
        }
        let name = $('#name').val();
        if (name.length < 1) {
            alert('Укажите имя');
            return;
        }
        let top = el.offset().top;
        let left = el.offset().left;

        $("#num").offset({top: top + 35, left: left + 32});
        this.currentElement = el;
    },
    putNum: function (val) {
        let rowKey = this.currentElement.data('row-id');
        let valueKey = this.currentElement.data('cell-id');
        let name = $('#name').val();
        $.post('/sudoku/api/v1/grid/put-num', {
            val: val,
            rowKey: rowKey,
            valueKey: valueKey,
            name: name
        }, function (data) {
            let send = {
                grid: data,
                full: false
            };
            num.socket.send(JSON.stringify(send));
            num.checkResult(data,name);
        });
        this.currentElement.html(val);
        this.hideNum();
    },
    checkResult: function (grid, name) {
        $.post('/sudoku/api/v1/grid/check-result', {
            grid: grid,
            name: name
        }, function (data) {
            if (data){
                let send = {
                    result: true,
                    success: data.success,
                    name: data.name
                };
                sudoku.success(data.success, data.name);
                num.socket.send(JSON.stringify(send));
            }
        });
    }
};

let sudoku = {};
sudoku = {
    newGame: function () {
        $.post('/sudoku/api/v1/grid/new-game', {}, function (data) {
            let send = {
                grid: data,
                full: true
            };
            num.socket.send(JSON.stringify(send));
            sudoku.refresh(send);
        });
    },
    refresh: function (data) {
        let grid = data.grid;
        let full = data.full;
        $.each(grid, function (rowIndex, cells) {
            $.each(cells, function (cellIndex, value) {
                if (full) {
                    $('#sudokuGrid').find('tr:eq(' + (rowIndex-1) + ')').find('td:eq(' + cellIndex + ')').removeClass('empty');
                    if (value === 0) {
                        $('#sudokuGrid').find('tr:eq(' + (rowIndex-1) + ')').find('td:eq(' + cellIndex + ')').addClass('empty');
                    }
                    $('#result').html('');
                }
                value = value === 0 ? '' : value;
                $('#sudokuGrid').find('tr:eq(' + (rowIndex-1) + ')').find('td:eq(' + cellIndex + ')').html(value);
            });
        });
    },
    success: function (data, name) {
        if (data){
            $('#result').html('Игра выиграна ('+name+')');
        } else {
            $('#result').html('Игра проиграна ('+name+')');
        }
    }
};


let socket = null;
let createConnection = function () {
    socket = new WebSocket('ws://localhost:8082');
    socket.onopen = function () {
        console.info('Connection opened');
    };
    socket.onclose = function (event) {
        if (event.wasClean) {
            console.info('Connection opened clear');
        } else {
            console.info('Connection lost');
        }
        console.error('Code: ' + event.code, event.reason);
        setTimeout(function () {
            createConnection();
        }, 3000);
    };
    socket.onmessage = function (event) {
        let data = JSON.parse(event.data);
        if (data.result){
            sudoku.success(data.success, data.name);
        }
        sudoku.refresh(data);
    };
    socket.onerror = function (error) {
        console.error(error.message);
    };
};


$(function () {
    createConnection();
    num.init(socket);
});
