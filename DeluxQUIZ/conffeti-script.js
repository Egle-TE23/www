window.addEventListener('load', () => {
     if (scorePercent >= 80) {  
    const canvas = document.getElementById('confetti-canvas');

    function launchConfetti() {
        const myConfetti = confetti.create(canvas, {resize: true, useWorker: true});

        myConfetti({particleCount: 150,spread: 200,origin: { y: 0.6 }});

        const interval = setInterval(() => {myConfetti({ particleCount: 50,spread: 200,origin: { y: 0.6 }});}, 500);
        setTimeout(() => clearInterval(interval), 2000);
    }
    launchConfetti();
}
});