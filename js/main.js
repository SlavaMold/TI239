
document.addEventListener("DOMContentLoaded", (event) => {
            let replaceble = document.querySelector('.underline-one');

            replaceble.onmouseover = function replace_txt() {
                replaceble.innerText = 'Выполнить вход';
            };

            replaceble.onmouseleave = function replace_txt2() {
            replaceble.innerText = 'Для старосты';
            }

})