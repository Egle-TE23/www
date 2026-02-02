
document.querySelectorAll(".form-control").forEach(input => {
    const max = input.getAttribute("maxlength");
    if (!max) return;

    const counter = document.querySelector(
        `.char-counter[data-for="${input.id}"]`
    );

    const update = () => {
        counter.textContent =
            `${input.value.length} / ${max} characters`;
    };

    input.addEventListener("input", update);
    update();
});
