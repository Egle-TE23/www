const questions = document.querySelectorAll('.question');
const submitBtn = document.getElementById('submitBtn');

questions.forEach((question, index) => {
    const choices = question.querySelectorAll('.choice');
    const nextBtn = question.querySelector('.next-btn');

    choices.forEach(choice => {
        choice.addEventListener('change', () => {
            nextBtn.style.display = 'inline-block';
        });
    });

    nextBtn.addEventListener('click', () => {
        question.style.display = 'none';

        if (questions[index + 1]) 
        {
            questions[index + 1].style.display = 'block';
        } 
        else 
        {
            submitBtn.style.display = 'inline-block';
        }
    });
});