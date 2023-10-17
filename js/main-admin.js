window.onload = function(){

        let replaceble = document.querySelector('.underline-one');

        replaceble.onmouseover = function replace_txt() {
            replaceble.innerText = 'Управление';
        };

        replaceble.onmouseleave = function replace_txt2() {
        replaceble.innerText = 'Вход Выполнен';
        }

        let delButt = document.querySelectorAll('.delete-comm');
        delButt.forEach((butt) => {
            butt.addEventListener('click', function() {
                let wrap = butt.parentElement;
                let delId = 'confirm_' + butt.id;
                let cancId =  'cancel_' + butt.id;
                wrap.innerHTML = `<form method="POST" action=""> <input type="hidden" name="id" value="`+ butt.id +`"/>
                 <input type="submit" name="delete" value="Подтвердить"> </form>
                <form method="POST" action=""> <input type="hidden" name="id" value="`+ butt.id +`"/>
                 <input type="submit" name="cancel" value="Отменить"> </form>`;   
            })
        });
}