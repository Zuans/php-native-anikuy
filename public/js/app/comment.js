

const setCard = (data) => {
    const card = `<div class="comment-card">
        <p class="username">
            ${data.username}
        </p>
        <p class="comment-date">
            at ${data.created_at}
        </p>
        <p class="comment-text">
            ${data.text}
        </p>
    </div>`
    return card;
}

const setAllCard = (allData) => {
    const allCard = allData.map(data => setCard(data));
    return allCard.join('\n');
}

const delAllCard = (parentEl,className) => {
    const allChild = parentEl.children;
    [...allChild].forEach(el => {
        if(el.classList.contains(className)) {
            console.log(el);
            el.remove();
        }
    });
}

define({
    setCard,
    setAllCard,
    delAllCard
})