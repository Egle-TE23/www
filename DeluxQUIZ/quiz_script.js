//quiz buttons
const questions = document.querySelectorAll('.question');
const submitBtn = document.getElementById('submitBtn');

questions.forEach((question, index) => {
    const choices = question.querySelectorAll('.choice');
    const nextBtn = question.querySelector('.next-btn');
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
var timeElapsed = 0;
var myTimer = 0;

function Start() {
  myTimer = setInterval(function() {
    timeElapsed += 1;
    document.getElementById("time").innerText = timeElapsed;
  }, 1000);

}

function Stop() {
  clearInterval(myTimer);
}

function Reset() {
  timeElapsed = 0;
  clearInterval(myTimer);
  document.getElementById("time").innerHTML = timeElapsed;
}

document.addEventListener('DOMContentLoaded', () => {
    var time = document.getElementById("res-time");
    time.innerHTML = timeElapsed;
});
