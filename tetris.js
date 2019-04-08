const canvas = document.getElementById('tetris');
const context = canvas.getContext('2d');

context.scale(20, 20);

var gameStatus = -1;               // -1 GAME STOPPED;         0 GAME RUNNING;            1 GAME PAUSED
var playCount = 1;

function arenaSweep() {
    var rowCount = 1;
    outer: 
    for (var y = arena.length -1; y > 0; --y) {
        for (var x = 0; x < arena[y].length; ++x) {
            if (arena[y][x] === 0) {
                continue outer;
            }
        }

        const row = arena.splice(y, 1)[0];
        row = fill(row, 12, 0);
        arena.unshift(row);
        ++y;

        player.score += rowCount * 10;
        rowCount *= 2;
    }
}

function collide(arena, player) {
    const m = player.matrix;
    const o = player.pos;
    for (var y = 0; y < m.length; ++y) {
        for (var x = 0; x < m[y].length; ++x) {
            if (m[y][x] !== 0 &&
               (arena[y + o.y] &&
                arena[y + o.y][x + o.x]) !== 0) {
                return true;
            }
        }
    }
    return false;
}


function fill(array, len, num){
    for(var i = 0; i < len; i++)
        array[i] = num;
    return array;
}


function createMatrix(w, h) {
    const matrix = [];
    while (h--) {
    	var temp = new Array(w);
        matrix.push(fill(temp, w, 0));
    }
    return matrix;
}

function createPiece(type)
{
    if (type === 'I') {
        return [
            [0, 1, 0, 0],
            [0, 1, 0, 0],
            [0, 1, 0, 0],
            [0, 1, 0, 0],
        ];
    } else if (type === 'L') {
        return [
            [0, 2, 0],
            [0, 2, 0],
            [0, 2, 2],
        ];
    } else if (type === 'J') {
        return [
            [0, 3, 0],
            [0, 3, 0],
            [3, 3, 0],
        ];
    } else if (type === 'O') {
        return [
            [4, 4],
            [4, 4],
        ];
    } else if (type === 'Z') {
        return [
            [5, 5, 0],
            [0, 5, 5],
            [0, 0, 0],
        ];
    } else if (type === 'S') {
        return [
            [0, 6, 6],
            [6, 6, 0],
            [0, 0, 0],
        ];
    } else if (type === 'T') {
        return [
            [0, 7, 0],
            [7, 7, 7],
            [0, 0, 0],
        ];
    }
}

function drawMatrix(matrix, offset) {
    matrix.forEach(function (row, y)  {
        row.forEach(function (value, x)  {
            if (value !== 0) {
                context.fillStyle = colors[value];
                context.strokeStyle = "#dee5e3";
                context.lineWidth = 0.1;
                context.strokeRect(x + offset.x, y + offset.y , 1, 1);
                context.fillRect(x + offset.x,
                                 y + offset.y,
                                 1, 1);
            }
        });
    });
}







function draw() {
    context.fillStyle = '#000';
    context.fillRect(0, 0, canvas.width, canvas.height);

    drawMatrix(arena, {x: 0, y: 0});
    drawMatrix(player.matrix, player.pos);
}

function merge(arena, player) {
    player.matrix.forEach(function (row, y) {
        row.forEach(function (value, x) {
            if (value !== 0) {
                arena[y + player.pos.y][x + player.pos.x] = value;
            }
        });
    });
}

function rotate(matrix, dir) {
    var appo;
    for (var y = 0; y < matrix.length; ++y) {
        for (var x = 0; x < y; ++x) {
            appo = matrix [x][y];
            matrix[x][y] = matrix[y][x];
            matrix[y][x] = appo;
        }
    }

    if (dir > 0) {
        matrix.forEach(function (row) { row.reverse()});
    } else {
        matrix.reverse();
    }
}

function playerDrop() {
    player.pos.y++;
    if (collide(arena, player)) {
        player.pos.y--;
        merge(arena, player);
        playerReset();
        arenaSweep();
        updateScore();
    }
    dropCounter = 0;
}

function playerMove(offset) {
    player.pos.x += offset;
    if (collide(arena, player)) {
        player.pos.x -= offset;
    }
}

function playerReset() {
    const pieces = 'TJLOSZI';
    player.matrix = createPiece(pieces[pieces.length * Math.random() | 0]);
    player.pos.y = 0;
    player.pos.x = (arena[0].length / 2 | 0) -
                   (player.matrix[0].length / 2 | 0);
    if (collide(arena, player)) {
        arena.forEach(function (row) { fill(row, 12, 0)});
        //PRELIEVO SCORE AL GAMEOVER
        lastScore(player.score);
        saveScore();
        player.score = 0;
        playCount++;
        updatePlayCount();
        updateScore();
        setNewGame();
        
    }
}

function setNewGame(){
	var elem = document.getElementById("play");
	gameStatus = -1; 
	elem.value = "PLAY"


}

function saveScore(){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET","saveScore.php?s="+player.score,false);
    xmlhttp.send(null);
    document.getElementById("endgame").innerHTML = xmlhttp.responseText;
}

function lastScore(num){
    document.getElementById('lastscore').textContent = num;
}

function updateScore() {
    document.getElementById('score').textContent = player.score;
}

function updatePlayCount(){
    document.getElementById('playcount').textContent = playCount;
}

function playerRotate(dir) {
    const pos = player.pos.x;
    var offset = 1;
    rotate(player.matrix, dir);
    while (collide(arena, player)) {
        player.pos.x += offset;
        offset = -(offset + (offset > 0 ? 1 : -1));
        if (offset > player.matrix[0].length) {
            rotate(player.matrix, -dir);
            player.pos.x = pos;
            return;
        }
    }
}


function playPressed(){
    dropCounter = 0;
    var elem = document.getElementById("play");
    if(gameStatus == 0){    //in gioco e voglio mettere in pausa 
        gameStatus = 1;
        elem.value = "RESUME";
    } else {    //appena caricato/gioco in pausa e voglio iniziare/riprendere
        gameStatus = 0;
        elem.value = "PAUSE";
        window.scrollTo(0,document.body.scrollHeight);      //scorre fino ad eliminare titolo e loginbar durante il gioco
    }
}

function gamePause(){
    if(gameStatus != 0){    //se non sto giocando resetto il contatore
        dropCounter = 0;
    } 
}



var dropCounter = 0;
var dropInterval = 1000;
var lastTime = 0;

function update(time) {
    if(!time){              //se non si passa time -> undefinded -> false allora default
        time = 0;
    }
    const deltaTime = time - lastTime;
    dropInterval = 1000 - player.score * 2;		//incremento difficolta (caduta velocizzata)

    dropCounter += deltaTime;
    gamePause();
    if (dropCounter > dropInterval) {
        playerDrop();
    }

    lastTime = time;

    draw();
    requestAnimationFrame(update);
}




document.addEventListener('keydown', function (event)  {
	if(event.keyCode === 80){			//P PAUSE - UNPAUSE
		playPressed();
		}

	if(gameStatus === 0){	
	    if (event.keyCode === 37) {			// left arrow
	        playerMove(-1);
	    } else if (event.keyCode === 39) {	// right arrow
	        playerMove(1);
	    } else if (event.keyCode === 40) {	// down arrow
	        playerDrop();
	    } else if (event.keyCode === 81) {	// Q
	        playerRotate(-1);	
	    } else if (event.keyCode === 87) {	// W
	        playerRotate(1);
	    }	
	}
});

const colors = [
    null,
    '#FF0D72',
    '#0DC2FF',
    '#0DFF72',
    '#F538FF',
    '#FF8E0D',
    '#FFE138',
    '#3877FF',
];

const arena = createMatrix(12, 20);

const player = {
    pos: {x: 0, y: 0},
    matrix: null,
    score: 0,
};

updatePlayCount();
lastScore(0);
playerReset();
updateScore();
update();