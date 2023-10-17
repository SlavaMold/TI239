let fileCount = 0;
let trigger = true;
let imagesHtml = {};
let imagesJs = [];
let out = '';
let button = '';
let outerror = 0;

function delImg() {
    out = ``;
    fileCount = 0;
    $('#formImage').val('');
    $(imagePreview).html(out);
    document.querySelector('.delete-img').classList.remove('visible')
    getImages();
}



function getButton() {
    document.querySelector('.delete-img').addEventListener('click', () => {
        delImg();
    });

}


function getImages() {
    imagesHtml = document.querySelectorAll('.delete-img');
}


function formHandler() {

    const formImage = document.getElementById('formImage');
    const imagePreview = document.getElementById('imagePreview');
    const Ordered = document.getElementById('formOrdered');
    const NoOrdered = document.getElementById('formNoOrdered');


    Ordered.addEventListener('click', () => {
        Ordered.removeAttribute('required');
        Ordered.setAttribute('checked', '');
        NoOrdered.removeAttribute('checked');
        NoOrdered.setAttribute('required', '');
    })

    NoOrdered.addEventListener('click', () => {
        NoOrdered.removeAttribute('required');
        NoOrdered.setAttribute('checked', '');
        Ordered.removeAttribute('checked');
        Ordered.setAttribute('required', '');
    })



    const form = document.getElementById('form');
    form.classList.remove('shown');
    form.addEventListener('submit', formSend);

    formImage.addEventListener('change', () => {

    for (let i = 0; i < formImage.files.length; i++) {
        uploadFile(formImage.files[i]);
    }
})

    // form.addEventListener('submit', formSend);
}

async function formSend(e) {
    e.preventDefault();

    let error = formValidate(form);

    let formData = new FormData(form);
    if (error == 0) {
        if (formImage != []){
            for (let i = 0; i < imagesJs.length; i++) {
                formData.append("files[" + i + "]", imagesJs[i]);
            }
        }

        formData.append('acc', "resp");
        $.ajax({
            url: 'saveform.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#form').find('input').prop("disabled", true);
                $('#form').find('button').prop("disabled", true);

            }
            , success: function (data2) {
                if (data2.status == 'ok') {

                    let forNotes = document.querySelector('.forNotifications');
                    forNotes.innerHTML = `
                        <div class="confirm" id="confirm"> <span> Новая запись успешно создана! </span> </div>
                    `;
                    window.location.href = '#confirm';
                    function reload(){
                        window.location.href = 'admin_auth.php';
                    }
                    setTimeout(reload, 1500);
                    
                }
                else {
                    alert('Не удалось загрузить ваши файлы, попробуйте ещё раз');
                }
            }
        })
    }
    else {
        alert('Заполните обязательные поля!');
    }
}


function formValidate(form) {
    let error = 0;
    let formReq = form.querySelectorAll('.req');
    console.log(formReq);

    for (let index = 0; index < formReq.length; index++) {
        const input = formReq[index];
        formRemoveError(input);

        if (input.value == '') {
            formAddError(input);
            error++;
        }
        else {
            formRemoveError(input);
        }

        if (input.classList.contains('file-input')) {
            if (fileTest(input)) {
                formAddError(input);
                error++;
            }
        }

    }
    console.log(error);
    return error;
}

function formAddError(input) {
    input.parentElement.classList.add('error');
    input.classList.add('error');
}

function formRemoveError(input) {
    input.parentElement.classList.remove('error');
    input.classList.remove('error');
}


function uploadFile(file) {
    // if (!['image/jpeg', 'image/jpg', 'image/png', 'image/svg', 'image/bmp', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel'].includes(file.type)) {
    //     alert('Недопустимый формат файла.');
    //     formImage.value = '';
    //     return;
    // }

    let reader = new FileReader();
    reader.onload = function (e) {
        if (['image/jpeg', 'image/jpg', 'image/png', 'image/svg', 'image/bmp'].includes(file.type)) {
            out += `<div><img class='prev-photo' src="${e.target.result}" alt="photo" id="${fileCount}"></div>`;
            $(imagePreview).html(out);
            getButton();
            document.querySelector('.delete-img').classList.add('visible');
            getImages();
            imagesJs[fileCount] = file;
            console.log(imagesJs);
            fileCount++;
        }
        else {
            out += `<div class="prev-file-wrap"><img class='prev-file' src="../imgs/file.png" alt="photo" id="${fileCount}"><span> ${file.name} </span></div>`;
            getButton();
            document.querySelector('.delete-img').classList.add('visible');
            getImages();
            $(imagePreview).html(out);
            imagesJs[fileCount] = file;
            console.log(imagesJs);
            fileCount++;
        }
    }


    reader.onerror = function (e) {
        alert('Ошибка');
    };
    reader.readAsDataURL(file);
}

