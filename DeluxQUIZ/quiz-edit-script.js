function updateOptions(questionId, count) {
    const container = document.getElementById("options-" + questionId);

    const existing = container.querySelectorAll(".choice-row");
    const current = existing.length;

    // remove extra
    if (current > count) {
        for (let i = current - 1; i >= count; i--) {
            existing[i].remove();
        }
    }

    // add missing
    if (current < count) {
        for (let i = current; i < count; i++) {
            const index = Date.now() + i;

            container.insertAdjacentHTML("beforeend", `
                <div class="input-group m-2 choice-row" style="width:95%;">
                    <span class="input-group-text">
                        <input type="radio"
                               name="questions[${questionId}][correct]"
                               value="new_${index}">
                    </span>

                    <input type="text"
                           class="form-control"
                           name="questions[${questionId}][choices][new_${index}]"
                           placeholder="Choice">
                </div>
            `);
        }
    }
}

document.querySelectorAll(".option-count").forEach(select => {
    select.addEventListener("change", () => {
        updateOptions(
            select.dataset.questionId,
            parseInt(select.value)
        );
    });
});