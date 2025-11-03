const canvas = document.getElementById("myCanvas");
const ctx = canvas.getContext("2d");
var x = 100;
var y = 100;
var width = 20;
var height = 20;
const speed = 7;
var direction =3;
var color ="#ff0000ff";

function start(){
DrawPipe();
setInterval(update, 10)
setInterval(randomDirection,100);
setInterval(newPipe,8000)
}

function update(){
DrawPipe();
Move();
}

function DrawPipe()
{
    //ctx.clearRect(0, 0, canvas.width, canvas.height); 
    ctx.fillStyle = color;
    ctx.fillRect(x, y, width, height);
}

function Move(){
    if(direction==1 && (x-speed >= 5)){
        x-=speed;
    }
    else if(direction == 2 && (x+speed <= canvas.width-width-5)){
        x+=speed;
    }
    else if(direction == 3 && (y-speed >= 5)){
        y-=speed;
    }
    else if(direction == 4 && (y+speed <= canvas.height-height-5)){
        y+=speed;
    }
    else{
    //samma som randomDirection utan if check
    if(direction==1||direction==2){
        direction = Math.floor(Math.random() * 2) + 3;
        console.log(direction);
    }
    else{
        direction = Math.floor(Math.random() * 2) + 1;
    }
    }
}

function randomDirection(){
    if((Math.floor(Math.random() * 5) +1)==1){
        if(direction==1||direction==2){
            direction = Math.floor(Math.random() * 2) + 3;
            console.log(direction);
        }
        else{
            direction = Math.floor(Math.random() * 2) + 1;
        }
}
}

function randomTime(){
    return Math.floor(Math.random() * 1000) + 100;
}

function newPipe(){
    var letters = '0123456789ABCDEF';
    var newColor = '#';
    for (var i = 0; i < 6; i++) {
        newColor += letters[Math.floor(Math.random() * 16)];
    }
    color=newColor;
    x=Math.floor(Math.random() * canvas.width-width);
    y=Math.floor(Math.random() * canvas.height-height);
}

function restart(){
    ctx.clearRect(0, 0, canvas.width, canvas.height); 
    var letters = '0123456789ABCDEF';
    var newColor = '#';
    for (var i = 0; i < 6; i++) {
        newColor += letters[Math.floor(Math.random() * 16)];
    }
    color=newColor;
    x=Math.floor(Math.random() * canvas.width-width);
    y=Math.floor(Math.random() * canvas.height-height);
}