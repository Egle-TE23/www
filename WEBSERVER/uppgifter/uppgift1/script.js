function Previous(n){
    document.getElementById("q"+n).style.display="none";
    document.getElementById("q"+(n-1)).style.display="block";
    let title = document.getElementById("title");
    if(n==1){
        title.innerText ="Skriv in ditt namn och börja quizet!!!";
    }
    else{
        title.innerText ="Fråga "+(n-1);
    }
}

function Next(n){
    document.getElementById("q"+n).style.display="none";
    document.getElementById("q"+(n+1)).style.display="block";
    document.getElementById("title").innerText ="Fråga "+(n+1);
}