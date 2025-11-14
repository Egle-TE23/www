const canvas = document.getElementById("myCanvas");
const ctx = canvas.getContext("2d");

const pipes = [];
const speed = 3;
const amount =12;

let mouse = { x: null, y: null, inside: false };

canvas.addEventListener("mousemove", (e) => {
  const rect = canvas.getBoundingClientRect();
  mouse.x = e.clientX - rect.left;
  mouse.y = e.clientY - rect.top;
  mouse.inside =
    mouse.x >= 0 &&
    mouse.x <= canvas.width &&
    mouse.y >= 0 &&
    mouse.y <= canvas.height;
});

canvas.addEventListener("mouseleave", () => {
  mouse.inside = false;
});

function start(){
//restart();
setInterval(update, 1); //update interval
}

function update(){
ctx.fillStyle = "black";
//ctx.fillRect((Math.random() * (canvas.width )), (Math.random() * (canvas.height)), 10, 10); 
pipes.forEach(pipe => {
    if (mouse.inside) pipe.follow(mouse.x, mouse.y);
    pipe.move();
    pipe.draw();
    if (Math.random() <= 0.02) {
        pipe.randomDirection();
    }
});
};

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
    this.x = Math.random() * (canvas.width-600) +300;
    this.y = Math.random() * (canvas.height-300) +150;
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

follow(targetX, targetY) {
    const dx = targetX - this.x;
    const dy = targetY - this.y;
    const dist = Math.sqrt(dx * dx + dy * dy);

    if (dist > 1) {
      this.x += (dx / dist) * (speed * 0.5);
      this.y += (dy / dist) * (speed * 0.5);
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
const hue = Math.floor(Math.random()*360);
  const saturation = 100 + Math.random() * 10;
  const lightness = 45 + Math.random() * 10;  
  return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
}
}
