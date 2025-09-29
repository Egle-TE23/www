function Previous(n){
    document.getElementById("q"+n).classList.remove("active");
    document.getElementById("q"+(n-1)).classList.add("active");
}

function Next(n){
    document.getElementById("q"+n).classList.remove("active");
    document.getElementById("q"+(n+1)).classList.add("active");
}