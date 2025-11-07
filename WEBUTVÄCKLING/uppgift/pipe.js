const canvas = document.getElementById("myCanvas");
const ctx = canvas.getContext("2d");

const pipes = [];
const speed = 5;
const amount =20;

function start(){
restart();
setInterval(update, 10); //update interval
}

function update(){
pipes.forEach(pipe => {
    pipe.move();
    pipe.draw();
    if(Math.random()<=0.02)//chance to change direction
    {
        pipe.randomDirection();
    }
});
}

function restart() //resets canvas and creates new pipes
{ 
    ctx.fillStyle = "black";
    ctx.fillRect(0, 0, canvas.width, canvas.height); 
    pipes.splice(0,pipes.length)
    for (let i = 0; i < amount; i++) 
    {
        pipes.push(new Pipe());
    }
}

class Pipe
{
 constructor(){
    this.x = Math.random() * (canvas.width );
    this.y = Math.random() * (canvas.height);
    this.diamater =10;
    this.direction = Math.floor(Math.random() * 4) + 1; //choses 1 of 4 directions
    this.color = this.randomColor();
    //this.color = "#" + Math.floor(Math.random()*16777215).toString(16); //stolen color code... kinda works?
 }

draw()
{
    ctx.fillStyle = this.color;
    ctx.fillRect(this.x, this.y, this.diamater, this.diamater);
}

 move(){
    if(this.direction==1 && (this.x-speed >= 5)){
        this.x-=speed;
    }
    else if(this.direction == 3 && (this.x+speed <= canvas.width-this.diamater-5)){
        this.x+=speed;
    }
    else if(this.direction == 2 && (this.y-speed >= 5)){
        this.y-=speed;
    }
    else if(this.direction == 4 && (this.y+speed <= canvas.height-this.diamater-5)){
        this.y+=speed;
    }
    else{
        this.randomDirection();
    }
}

randomDirection()
{
        if(this.direction==4){
            if((Math.floor(Math.random()) +1)==1){
                this.direction=1;
            }
            else{
            this.direction--;
            }
        }
        else{
            if((Math.floor(Math.random()) +1)==1){
                this.direction++;
            }
            else{
            this.direction--;
            }
        }
}
randomColor(){
const hue = Math.floor(Math.random() * 360);
  const saturation = 90 + Math.random() * 10;
  const lightness = 45 + Math.random() * 10;  
  return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
}
}
