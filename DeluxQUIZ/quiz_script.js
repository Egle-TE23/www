//quiz buttons
const questions = document.querySelectorAll('.question');
const submitBtn = document.getElementById('submitBtn');

questions.forEach((question, index) => {
    const choices = question.querySelectorAll('.choice');
    const nextBtn = question.querySelector('.quiz-btn');
    choices.forEach(choice => {
        choice.addEventListener('change', () => { nextBtn.style.display = 'inline-block'; });
    });
    nextBtn.addEventListener('click', () => {
        question.style.display = 'none';
        if (questions[index + 1]) {
            questions[index + 1].style.display = 'block';
        }
        else {
            submitBtn.style.display = 'inline-block';
        }
    });
});

//quiz edit 
function showQuestion(id) {
    document.querySelectorAll('.edit-question-div')
        .forEach(div => div.style.display = 'none');

    document.querySelector(`.edit-question-div[data-question-id="${id}"]`).style.display = 'block';
}

//quiz edit media
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.media-type').forEach(select => {
        toggleMediaInput(select);

        select.addEventListener('change', () => {
            toggleMediaInput(select);
        });
    });
});

function toggleMediaInput(select) {
    const questionId = select.dataset.questionId;
    const fileInput = document.querySelector(
        `.media-input[data-question-id="${questionId}"]`
    );

    if (!fileInput) return;

    if (select.value === '') {
        fileInput.value = '';
        fileInput.disabled = true;
    } else {
        fileInput.disabled = false;

        //change accepted type 
        if (select.value === 'image') {
            fileInput.accept = 'image/*';
        } else if (select.value === 'video') {
            fileInput.accept = 'video/*';
        } else if (select.value === 'audio') {
            fileInput.accept = 'audio/*';
        }
    }
}
//timer
let quizStartTime = Date.now();
let interval;

window.addEventListener("load", () => {
    startTimer();
});

function startTimer() {
    quizStartTime = Date.now();

    interval = setInterval(() => {
        const seconds = Math.floor((Date.now() - quizStartTime) / 1000);
        const min = Math.floor(seconds / 60);
        const sec = seconds % 60;

        document.getElementById("timer").textContent =
            `${min}:${sec.toString().padStart(2, "0")}`;
    }, 1000);
}

function stopTimer() {
    clearInterval(interval);
    const seconds = Math.floor((Date.now() - quizStartTime) / 1000);
    document.getElementById("time_taken").value = seconds;
}

//canvas confetti

const canvas = document.getElementById("confetti");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const pieces = [];
const colors = ["#ffd500", "#b83fe4ff", "#ff5fa2", "#00d4ff"];

for (let i = 0; i < 200; i++) {
    pieces.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        r: Math.random() * 6 + 4,
        c: colors[Math.floor(Math.random() * colors.length)],
        s: Math.random() * 3 + 5
    });
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let p of pieces) {
        ctx.beginPath();
        ctx.fillStyle = p.c;
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fill();

        p.y += p.s;
        if (p.y > canvas.height) p.y = -10;
    }

    requestAnimationFrame(draw);
}

draw();