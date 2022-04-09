imageArray = {};
sparePartArray = [];
const ERROR_MESSAGE = 'Произошла ошибка, попробуйте позднее!'
const uuid = function () {
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
}
const notyError = function (message = 'Произошла ошибка!') {
    new Noty({
        type: 'error',
        text: '<h5>Внимание</h5>' + message,
        timeout: 4000
    }).show()
}
const notySuccess = function (message = 'Все прошло успешно!') {
    new Noty({
        type: 'success',
        text: '<h5>Внимание</h5>' + message,
        timeout: 4000
    }).show()
}
const notyInfo = function (message = 'Обратите внимание!') {
    new Noty({
        type: 'info',
        text: '<h5>Внимание</h5>' + message,
        timeout: 4000
    }).show()
}
const setLocation = function (curLoc) {
    try {
        history.pushState(null, null, curLoc);
        return;
    } catch (e) {
    }
    location.hash = '#' + curLoc;
}
const inputMask = function () {
    Inputmask().mask(document.querySelectorAll('.inputmask'));

}
const fancybox = function () {
    Fancybox.bind('[data-fancybox]', {});
}
const dateRangePicker = function () {
    flatpickr('.daterangepicker', {
        mode: 'range',
        'locale': 'ru',
        dateFormat: 'd.m.Y',
    });
    flatpickr('.datepicker-wrap', {
        allowInput: true,
        clickOpens: false,
        wrap: true,
        'locale': 'ru',
        dateFormat: 'd.m.Y',
    })
}
const errorResponse = function (response) {
    let message = response.responseJSON.message;
    if (response && response.responseJSON.status_code === 400) {
        let error = response.responseJSON.error;
        if (error && Object.keys(error).length) {
            for (let key in error) {
                let selector = `[data-validator="${key}"]`;
                $(selector).addClass('is-invalid');
            }
        }
    }
    notyError(message ? message : ERROR_MESSAGE);
}

/********** #start sendForm **********/

const confirmSave = (saveButton) => {
    Swal.fire({
        icon: 'warning',
        title: 'Вы уверены что хотите сохранить все изменения?',
        text: 'Изменения нельзя будет отменить',
        showDenyButton: true,
        confirmButtonText: 'Сохранить',
        denyButtonText: 'Отменить',
    }).then((result) => {
        if (result.isConfirmed) {
            saveForm(saveButton);
        } else if (result.isDenied) {
            Swal.fire('Изменения не сохранены', '', 'info')
        }
    })
}

const sendForm = () => {
    $('.a-shop #global-form').on('click', '.js-save-button', function (e) {
        confirmSave($(this));
    });
}

const saveForm = (saveButton) => {
    let form = saveButton.closest('#global-form');
    let path = form.attr('action')
    let data = new FormData(form[0]);
    if (Object.keys(imageArray).length) {
        for (key_1 in imageArray) {
            data.append('images[' + key_1 + '][file]', imageArray[key_1]['file']);
        }
    }
    $.ajax({
        url: path,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                imageArray = {};
                let block = $('.a-shop-block');
                let html = $(response.data.view);
                block.html(html);
                App.select2();
                sendForm();
                fancybox();
                catalogProductWidgetAdd();
                $('.summernote').summernote({
                    height: 150
                });
                flatpickr('.datetimepicker-inline', {
                    enableTime: true,
                    inline: true
                });
                Swal.fire('Сохранено', '', 'success');
                if (response.data.url) {
                    setLocation(response.data.url);
                }
            }
        },
        error: function (response) {
            errorResponse(response);
        },
        complete: function () {
        }
    });
}

/********** #end sendForm **********/
/********** #start images **********/

const confirmImage = (obj, image) => {
    Swal.fire({
        icon: 'warning',
        title: 'Вы уверены что хотите удалить изображение?',
        text: 'Изменения нельзя будет отменить',
        showDenyButton: true,
        confirmButtonText: 'Удалить',
        denyButtonText: 'Отменить',
    }).then((result) => {
        if (result.isConfirmed) {
            imageDelete(obj, image);
        } else if (result.isDenied) {
            Swal.fire('Изображение не удалено', '', 'info')
        }
    })
}

const imageAdd = () => {
    $('.a-shop').on('change', '.js-image-upload', function () {
        let input = $(this);
        let div = $(this).closest('fieldset');
        let image = div.find('.js-image-block');
        let file = window.URL.createObjectURL(input[0].files[0]);
        $('.js-image-block-remove').slideDown();
        if (image.length) {
            $(image).html(`<img data-fancybox src="${file}">`);
            fancybox();
        }
        notySuccess('Нажните сохранить, что бы загрузить изображение')
    });
}

const imageDelete = (obj, image) => {
    $.ajax({
        url: '/admin/blog/ajax/delete-image',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: obj,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                image.remove();
                notySuccess('Изображение удалено', '', 'success')
            }
        },
        error: function (response) {
            errorResponse(response);
        },
        complete: function () {
        }
    });
}

const imagesArrayDraw = (array) => {
    if (Object.keys(array).length) {
        let block = $('.js-gallery-block');
        for (key in array) {
            let imageUrl = URL.createObjectURL(array[key]);
            let image = `<div class="md-block-5 js-gallery-item">
                            <div class="img rounded">
                                <img src="${imageUrl}" alt="Image">
                                <div class="overlay-content text-center justify-content-end">
                                    <div class="btn-group mb-1" role="group">
                                        <a data-fancybox="gallery" href="${imageUrl}">
                                            <button type="button" class="btn btn-link btn-icon text-danger">
                                                <i class="material-icons">zoom_in</i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-link btn-icon text-danger" data-js-image-array-id="${key}">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-group small">
                                    <input class="form-control form-shadow" placeholder="Заголовок" name="images[${key}][sort]" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group small">
                                    <input class="form-control form-shadow" placeholder="Описание" name="images[${key}][title]" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group small">
                                    <input class="form-control form-shadow" placeholder="Сортировка" name="images[${key}][description]" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>`;
            block.append(image);
        }
        notyInfo('Нажмите "Сохранить", что бы загрузить изображение');
        fancybox();
    }
}

const imagesArrayAdd = () => {
    $('.a-shop').on('change', '#js-gallery-input', function (evt) {
        let array = {};
        let files = evt.target.files; // FileList object
        let fileArray = Array.from(files);
        $(this)[0].value = '';
        for (let i = 0, l = fileArray.length; i < l; i++) {
            let id = uuid();
            imageArray[id] = {};
            imageArray[id]['file'] = fileArray[i];
            array[id] = fileArray[i];
        }
        imagesArrayDraw(array);
    });
}

const imagesArrayDelete = () => {
    $('.a-shop').on('click', '[data-js-image-array-id]', function (evt) {
        let image = $(this).closest('.js-gallery-item');
        if (!image.length) {
            image = $(this).closest('.js-image-block').find('img');
            if (!image.length) {
                return;
            }
        }
        let id = $(this).attr('data-js-image-array-id');
        let idBd = $(this).attr('data-js-image-id');
        let model = $(this).attr('data-js-image-model');
        if (idBd && model) {
            confirmImage({'id': idBd, 'model': model}, image)
        } else {
            delete imageArray[id];
            image.remove();
        }
    });
}

/********** #end images **********/
/********** #start catalog **********/

const catalogProductWidgetConfirm = (obj, image) => {
    Swal.fire({
        icon: 'warning',
        title: 'Вы уверены что хотите удалить виджет?',
        text: 'Изменения нельзя будет отменить',
        showDenyButton: true,
        confirmButtonText: 'Удалить',
        denyButtonText: 'Отменить',
    }).then((result) => {
        if (result.isConfirmed) {
            catalogProductWidgetDelete(obj, image);
        } else if (result.isDenied) {
            Swal.fire('Виджет не удален', '', 'info')
        }
    })
}

const catalogProductWidgetAdd = () => {
    $('.a-shop .js-image').on('click', '.js-widgets-button-add', function (evt) {
        let formGroup = $(this).closest('.form-group');
        let uu = uuid();
        let widget = `<div class="col-sm-12 form-block widget-tabs">
                        <div class="row">
                            <div class="col-sm-8 widgets-tabs js-widgets-tabs">
                                <div>
                                    <fieldset class="form-block">
                                        <legend>Наполнение</legend>
                                        <div class="form-group small">
                                            <input
                                                class="form-control form-shadow"
                                                placeholder="Заголовок"
                                                name="tabs[${uu}][title]"
                                                value="">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group small">
                                            <input
                                                class="form-control form-shadow"
                                                placeholder="Заголовок короткий"
                                                name="tabs[${uu}][title_short]"
                                                value="">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group small">
                                            <input
                                                class="form-control form-shadow"
                                                placeholder="Сортировка"
                                                name="tabs[${uu}][sort]"
                                                value="">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group small">
                                        <textarea
                                            id="description"
                                            name="tabs[${uu}][description]"
                                            class="form-control summernote"></textarea>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <fieldset class="form-block">
                                    <legend>Изображение</legend>
                                    <div class="block-image js-image-block"></div>
                                    <div class="form-group">
                                        <label class="control-label button-100" for="js-widgets-image-upload-${uu}">
                                            <a type="button" class="btn btn-primary button-image">Загрузить
                                                фото</a>
                                        </label>
                                        <input
                                            type="file"
                                            data-widgets-uuid="${uu}"
                                            id="js-widgets-image-upload-${uu}"
                                            class="custom-input-file js-image-upload"
                                            name="tabs[${uu}][image]"
                                            accept="image/*">
                                    </div>
                                </fieldset>
                            </div>
                            <button
                                type="button"
                                class="close widget"
                                data-dismiss="alert"
                                data-js-widget-model=""
                                data-js-widget-id=""
                                data-js-widget-array-id="${uu}"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>`;
        formGroup.before(widget);
        $('.summernote').summernote({
            height: 150
        });
    });
}

const catalogProductWidgetArrayDelete = () => {
    $('.a-shop').on('click', '[data-js-widget-array-id]', function (evt) {
        let widget = $(this).closest('.widget-tabs');
        if (!widget.length) {
            return;
        }
        let idBd = $(this).attr('data-js-widget-id');
        let model = $(this).attr('data-js-widget-model');
        if (idBd && model) {
            catalogProductWidgetConfirm({'id': idBd, 'model': model}, widget);
        } else {
            widget.remove();
        }
    });
}

const catalogProductWidgetDelete = (obj, widget) => {
    $.ajax({
        url: '/admin/blog/ajax/delete-widget',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: obj,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                notySuccess('Все изменения сохранены');
                widget.remove();
            }
        },
        error: function (response) {
            errorResponse(response);
        },
        complete: function () {
        }
    });
}

/********** #end catalog **********/
/********** #start postCategory **********/

const postCategorySendForm = () => {}

/********** #end postCategory **********/
const config = () => {
    $('.summernote-500').summernote({
        height: 500
    });
    $('.summernote').summernote({
        height: 150
    });
    flatpickr('.datetimepicker-inline', {
        enableTime: true,
        inline: true
    });
    dateRangePicker();
    App.select2();
    inputMask();
    fancybox();

    $('#document-catalog-modal').on('hidden.bs.modal', function (e) {
        sparePartArray = [];
        let button = $('.js-document-catalog-modal-credit-spare-part-add');
        let span = button.find('span');
        span.html('');
        button.hide();
    });
}
const sort = () => {
    // create from all .sortable classes
    document.querySelectorAll('.sortable').forEach(function(el) {
        const swap = el.classList.contains('swap')
        Sortable.create(el, {
            swap: swap,
            animation: 150,
            handle: '.sort-handle',
            filter: '.remove-handle',
            onFilter: function(evt) {
                evt.item.parentNode.removeChild(evt.item)
            }
        })
    })

    // Shared lists
    Sortable.create(document.getElementById('left'), {
        animation: 150,
        group: 'shared', // set both lists to same group
        handle: '.sort-handle'
    })
    Sortable.create(document.getElementById('right'), {
        animation: 150,
        group: 'shared',
        handle: '.sort-handle'
    })

    // Cloning
    Sortable.create(document.getElementById('left-cloneable'), {
        animation: 150,
        group: {
            name: 'cloning',
            pull: 'clone' // To clone: set pull to 'clone'
        },
        handle: '.sort-handle'
    })
    Sortable.create(document.getElementById('right-cloneable'), {
        animation: 150,
        group: {
            name: 'cloning',
            pull: 'clone'
        },
        handle: '.sort-handle'
    })
}
$(document).ready(function () {
    config();
    imageAdd();
    imagesArrayAdd();
    imagesArrayDelete();
    sendForm();
    catalogProductWidgetAdd();
    catalogProductWidgetArrayDelete();
})
