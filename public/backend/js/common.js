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
/********** #start images **********/

const imageAdd = () => {
    $('.a-shop .js-image').on('change', '.js-image-upload', function () {
        console.log($(this))
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

const imageDelete = (id) => {
    $.ajax({
        url: '/admin/blog/ajax/delete-image',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: {id: id},
        // processData: false,
        // contentType: false,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                notySuccess('Все изменения сохранены');
                return true;
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
    $('.a-shop .js-image').on('change', '#js-gallery-input', function (evt) {
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
    $('.a-shop .js-image').on('click', '[data-js-image-array-id]', function (evt) {
        let image = $(this).closest('.js-gallery-item');
        let id = $(this).attr('data-js-image-array-id');
        let idBd = $(this).attr('data-js-image-id');
        if (idBd) {
            image.remove();
            if (imageDelete(idBd)) {

            }
        } else {
            delete imageArray[id];
            image.remove();
        }
    });
}

/********** #end images **********/
/********** #start sendForm **********/

const sendForm = () => {
    $('.a-shop #global-form').on('click', '.js-save-button', function (e) {
        let form = $(this).closest('#global-form');
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
                    imageAdd();
                    fancybox();
                    $('.summernote').summernote({
                        height: 150
                    });
                    flatpickr('.datetimepicker-inline', {
                        enableTime: true,
                        inline: true
                    });

                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены');
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

/********** #end sendForm **********/
/********** #start catalog **********/

const catalogProductWidgetAdd = () => {
    $('.a-shop .js-image').on('click', '.js-widgets-button-add', function (evt) {
        let formGroup = $(this).closest('.form-group');
        let uu = uuid();
        let widget = `<div class="col-sm-12 form-block">
                        <div class="row">
                            <div class="col-sm-8 widgets-tabs js-widgets-tabs">
                                <div>
                                    <fieldset class="form-block">
                                        <input type="hidden"
                                        name="catalog_product_widgets_id" value="">
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
                                                name="tabs[${uu}][title]"
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
                                            id="js-widgets-image-upload-${uu}"
                                            class="custom-input-file js-image-upload"
                                            name="tabs[${uu}][image]"
                                            accept="image/*">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>`;
        formGroup.before(widget);
        $('.summernote').summernote({
            height: 150
        });

    });
}

/********** #end catalog **********/
/********** #start postCategory **********/

const postCategorySendForm = () => {}

/********** #end postCategory **********/
/********** document-credit **********/

function documentSearchProducer() {
    $('.js-document-search-producer').select2({
        ajax: {
            url: '/admin/document/ajax-catalog-producer',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.data
                };
            }
        },
        placeholder: 'Поставщик',
        minimumInputLength: 3,
        language: 'ru'
    });
}

function documentDeleteImage(id) {
    $.ajax({
        url: '/admin/document/ajax-delete-image/' + id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: {},
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                notySuccess(response.message ? response.message : 'Изображение успешно удалено!')
            } else {
                notyError(response.message ? response.message : ERROR_MESSAGE);
            }
        },
        error: function (response) {
            notyError(ERROR_MESSAGE);
        },
        complete: function () {
        }
    });
}

function documentDeletePart(id) {
    $.ajax({
        url: '/admin/document/ajax-delete-spare-part/' + id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: {},
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                notySuccess(response.message ? response.message : 'Позиция успешно удалена!')
            } else {
                notyError(response.message ? response.message : ERROR_MESSAGE);
            }
        },
        error: function (response) {
            notyError(ERROR_MESSAGE);
        },
        complete: function () {
        }
    });
}

function documentDeleteDocument(id) {
    $.ajax({
        url: '/admin/document/ajax-delete-document/' + id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: {},
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                notySuccess(response.message ? response.message : 'Позиция успешно удалена!')
            } else {
                notyError(response.message ? response.message : ERROR_MESSAGE);
            }
        },
        error: function (response) {
            notyError(ERROR_MESSAGE);
        },
        complete: function () {
        }
    });
}

function documentCreditSearchParts() {
    $('.js-document-credit-search-parts').select2({
        ajax: {
            url: '/admin/document/ajax-catalog-spare-part',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.data
                };
            }
        },
        placeholder: 'Поиск запасных частей',
        minimumInputLength: 3,
        language: 'ru'
    });
}

function documentCreditSearchPartsByCode() {
    $('.js-document-credit').on('input', '.js-document-credit-add-parts-item-by-code', function (e) {
        let code = $(this).val();
        if (code.length > 3) {
            $.ajax({
                url: '/admin/document/ajax-catalog-spare-part-by-code',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                data: {
                    code: code,
                },
                // processData: false,
                // contentType: false,
                beforeSend: function () {
                },
                success: function (response) {
                    if (response.status) {
                        if (response.data.view && response.data.view.length) {
                            $('.js-document-credit-parts').append(response.data.view);
                            documentCreditSearchParts();
                            documentCreditSearchStorage();
                            inputMask();
                            $('.js-document-credit-category-storage').select2();
                            $('.js-document-credit-add-parts-item-by-code').val('');
                        } else {
                            notyError('Запасная часть не найдена.');
                        }
                    } else {
                        notyError(response.message ? response.message : ERROR_MESSAGE);
                    }
                },
                error: function (response) {
                    errorResponse(response);
                },
                complete: function () {
                }
            });
        }
    });
}

function documentCreditSearchStorage() {
    $('.js-document-credit-search-storage').select2({
        ajax: {
            url: '/admin/document/ajax-catalog-storage-place',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.data
                };
            }
        },
        placeholder: 'Поиск склада',
        minimumInputLength: 2,
        language: 'ru'
    });
}

function documentCreditItemAdd() {
    $('.js-document-credit').on('click', '.js-document-credit-button-add-parts-item', function () {
        let id = uuid();
        imageArray[id] = [];
        let id_2 = uuid();
        let id_3 = uuid();
        let length = $('.js-document-credit-parts-item').length + 1;
        $.ajax({
            url: '/admin/document/ajax-catalog-storage-place-general',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {},
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    let option = '';
                    if (response.data) {
                        for (let i = 0, length = response.data.length; i < length; i++) {
                            option += `<option value="${response.data[i].id}">${response.data[i].title}</option>`;
                        }

                    }
                    let html = `<div class="card mb-2 js-document-credit-parts-item" data-id="0" data-uuid="${id}">
                        <div class="card-body p-2 p-sm-3">
                            <div class="media forum-item">
                                <div class="text-muted small text-center align-self-center pr-3">
                                    <span class="d-none d-sm-inline-block">${length}</span>
                                </div>
                                <div class="media-body">
                                    <input
                                        type="hidden"
                                        name="document_credit[item][${id}][catalog_document_content_id]">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control js-document-credit-search-parts"
                                                    data-placeholder="Запасная часть"
                                                    name="document_credit[item][${id}][spare_part]"
                                                    data-validator="document_credit.item.${id}.spare_part">
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="js-document-credit-category-storage-select-group">
                                                    <select
                                                        class="form-control js-document-credit-category-storage"
                                                        data-select-storage-cnt="0"
                                                        data-validator="document_credit.item.${id}.catalog_storage_place_id"
                                                        data-placeholder="Выбрать склад">
                                                        <option></option>
                                                        ${option}
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label for="fieldset-input-${id_2}">Входящая цена</label>
                                                    <input
                                                        type="text"
                                                        class="form-control inputmask"
                                                        id="fieldset-input-${id_2}"
                                                        name="document_credit[item][${id}][price_in]"
                                                        data-inputmask-alias="currency"
                                                        data-validator="document_credit.item.${id}.price_in">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="fieldset-input-${id_3}">Исходящая цена</label>
                                                    <input
                                                        type="text"
                                                        class="form-control inputmask"
                                                        id="fieldset-input-${id_3}"
                                                        name="document_credit[item][${id}][price_out]"
                                                        data-inputmask-alias="currency"
                                                        data-validator="document_credit.item.${id}.price_out">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="list-with-gap">
                                                <button type="button" class="btn btn-danger btn-xs js-document-credit-button-delete-parts-item">Удалить</button>
                                                <label class="control-label" for="item-images-${id}">
                                                    <a type="button" class="btn btn-primary btn-xs">Загрузить фото</a>
                                                </label>
                                                <input
                                                    type="file"
                                                    id="item-images-${id}"
                                                    class="custom-input-file js-document-credit-parts-gallery-input"
                                                    name="document_credit[item][${id}][images][]"
                                                    multiple=""
                                                    accept="image/*">
                                            </div>
                                            </div>
                                        <div class="col-sm-6">
                                            <div class="gallery-saved js-document-credit-parts-gallery-saved"></div>
                                            <div class="parts-gallery js-document-credit-parts-gallery"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    $('.js-document-credit-parts').append(html);
                    documentCreditSearchParts();
                    documentCreditSearchStorage();
                    inputMask();
                    $('.js-document-credit-category-storage').select2();
                    $('.js-document-credit-category-storage-place').select2();
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });

    })
}

function documentCreditItemDelete() {
    $('.js-document-credit').on('click', '.js-document-credit-button-delete-parts-item', function () {
        $(this).closest('.js-document-credit-parts-item').remove();
    })
}

function documentCreditItemDeleteFromBD() {
    $('.js-document-credit').on('click', '.js-document-credit-button-delete-parts-item-id', function () {
        let block = $(this).closest('.js-document-credit-parts-item');
        let id = block.attr('data-id');
        if (id * 1) {
            documentDeletePart(id);
        }
        block.remove();
    })
}

function documentCreditGallerySelect() {
    $('.js-document-credit').on('change', '.js-document-credit-search-parts,.js-document-credit-search-parts-by-code', function () {
        let item = $(this).closest('.js-document-credit-parts-item');
        let itemId = item.attr('data-uuid');
        let block = item.find('.js-document-credit-parts-gallery-saved');
        $.ajax({
            url: '/admin/document/ajax-catalog-gallery',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: $(this).val(),
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    let galleryBlock = '';
                    if (response.data) {
                        for (let i = 0, length = response.data.length; i < length; i++) {
                            let imagesBlock = '';
                            let gallery = response.data[i];
                            let images = gallery.catalog_gallery_images;
                            if (images && images.length) {
                                for (let ii = 0, length = images.length; ii < length; ii++) {
                                    imagesBlock += `
                                        <a data-fancybox="gallery-${gallery.id}" href="${images[ii].url}">
                                            <div style="display:inline-block;width:30px;height:25px;background: center/cover no-repeat url(${images[ii].url})"></div>
                                        </a>
                                    `;
                                }
                            }
                            galleryBlock += `
                                <div class="custom-control custom-radio">
                                    <input
                                        type="radio"
                                        id="customRadio-${gallery.id}"
                                        name="document_credit[item][${itemId}][catalog_gallery_id]"
                                        value="${gallery.id}"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio-${gallery.id}"></label>
                                    ${imagesBlock}
                                </div>
                            `;
                        }
                    }
                    let id = uuid();
                    galleryBlock += `
                        <div class="custom-control custom-radio">
                            <input
                                type="radio"
                                id="customRadio-${id}"
                                name="document_credit[item][${itemId}][catalog_gallery_id]"
                                value=""
                                class="custom-control-input">
                            <label class="custom-control-label" for="customRadio-${id}">Новая галлерея</label>
                        </div>
                    `;
                    block.html(galleryBlock);
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    })
}

function documentCreditImageArrayDraw(array, uuid) {
    if (Object.keys(array).length) {
        let selector = `[data-uuid="${uuid}"]`
        let block = $(selector).find('.js-document-credit-parts-gallery');
        for (key in array) {
            let imageUrl = URL.createObjectURL(array[key]);
            let image = `<div class="md-block-7 js-document-credit-parts-gallery-item">
                            <div class="img rounded">
                                <img src="${imageUrl}" alt="Image">
                                <div class="overlay-content text-center justify-content-end">
                                    <div class="btn-group mb-1" role="group">
                                        <a data-fancybox="gallery-${uuid}" href="${imageUrl}">
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
                        </div>`;
            block.append(image);
        }
        notyInfo('Нажмите "Сохранить", что бы загрузить изображение');
        fancybox();
    }
}

function documentCreditImageArrayAdd() {
    $('.js-document-credit').on('change', '.js-document-credit-parts-gallery-input', function (evt) {
        let array = {};
        let files = evt.target.files; // FileList object
        let fileArray = Array.from(files);
        let uuidData = $(this).closest('.js-document-credit-parts-item').attr('data-uuid');
        let id = $(this).closest('.js-document-credit-parts-item').attr('data-id');
        if (typeof imageArray[uuidData] === 'undefined') {
            imageArray[uuidData] = [];
        }
        $(this)[0].value = '';
        for (let i = 0, l = fileArray.length; i < l; i++) {
            let id = uuid();
            imageArray[uuidData][id] = fileArray[i];
            array[id] = fileArray[i];
        }
        documentCreditImageArrayDraw(array, uuidData);
    });
}

function documentCreditImageArrayDelete() {
    $('.js-document-credit').on('click', '[data-js-image-array-id]', function (evt) {
        let block = $(this).closest('.js-document-credit-parts-item');
        let image = $(this).closest('.js-document-credit-parts-gallery-item');
        let id = $(this).attr('data-js-image-array-id');
        let uuid = block.attr('data-uuid');
        delete imageArray[uuid][id];
        image.remove();
    });
}

function documentCreditImageDeleteFromBD() {
    $('.js-document-credit').on('click', '[data-js-image-id]', function (evt) {
        let image = $(this).closest('.js-document-credit-parts-gallery-item');
        let id = $(this).attr('data-js-image-id');
        documentDeleteImage(id);
        image.remove();
    });
}

function documentCreditDocumentFromBD() {
    $('.js-document-credit').on('click', '[data-js-document-credit-table-id]', function (evt) {
        let block = $(this).closest('.js-document-credit-table');
        let id = $(this).attr('data-js-document-credit-table-id');
        documentDeleteDocument(id);
        block.remove();
    });

}

function documentCreditFormSend() {
    $('.js-document-credit').on('click', '.js-document-credit-save-button', function (e) {
        let form = $(this).closest('#document-credit-form');
        let data = new FormData(form[0]);
        if (Object.keys(imageArray).length) {
            for (key_1 in imageArray) {
                for (key_2 in imageArray[key_1]) {
                    data.append('document_credit[item][' + key_1 + '][images][' + key_2 + ']', imageArray[key_1][key_2]);
                }
            }
        }
        $.ajax({
            url: '/admin/document/ajax-save-credit',
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
                    let block = $('.js-document-credit');
                    let html = $(response.data.view).find('#document-credit-form');
                    block.html(html);
                    App.select2();
                    documentCreditSearchParts();
                    documentCreditSearchStorage();
                    inputMask();
                    fancybox();
                    documentSearchProducer();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены');
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function documentCreditPosting() {
    $('.js-document-credit').on('click', '.js-document-credit-posting-button', function (e) {
        let form = $(this).closest('#document-credit-form');
        let data = new FormData(form[0]);
        if (Object.keys(imageArray).length) {
            for (key_1 in imageArray) {
                for (key_2 in imageArray[key_1]) {
                    data.append('document_credit[item][' + key_1 + '][images][' + key_2 + ']', imageArray[key_1][key_2]);
                }
            }
        }
        $.ajax({
            url: '/admin/document/ajax-posting-credit',
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
                    let block = $('.js-document-credit');
                    let html = $(response.data.view).find('#document-credit-form');
                    block.html(html);
                    fancybox();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены');
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function documentCreditFormFilter() {
    $('.js-document-credit').on('click', '.js-document-credit-filter-button', function (e) {
        let form = $(this).closest('.js-document-credit').find('#document-credit-form-filter');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/document/ajax-filter-credit',
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
                    let block = $('.js-document-credit');
                    let html = $(response.data.view).find('.js-document-credit-inner');
                    block.html(html);
                    App.select2();
                    documentSearchProducer();
                    dateRangePicker();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Данные сформированы');
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function documentCreditSetAdd() {
    $('.js-schemes,.js-china-resource').on('click', '.js-set-spare-part', function (e) {
        let data = $(this).attr('data-spare-part');
        $.ajax({
            url: '/admin/document/ajax-credit-set-add',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                let count = $('.js-set-credit-count');
                let title = $('.js-set-credit-title');
                let block = $('.js-set-credit-block');
                let link = $('.js-set-credit-link');
                if (response.status) {
                    let array = response.data;
                    if (array.length) {
                        count.html(array.length);
                        title.html(`<i data-feather="server" class="mr-2"></i>${array.length}  Позиции`);
                        link.show();
                        let items = '';
                        for (key in array) {
                            items += `
                                <div class="list-group-item list-group-item-action js-set-credit-item">
                                    <div class="media">
                                        <div class="media-body ml-2">
                                            <p class="mb-0">${array[key]['title']}</p>
                                            <small class="text-secondary">${array[key]['oem']}</small>
                                            <i
                                                class="material-icons js-set-spare-part-delete"
                                                data-document-spare-part="${array[key]['id']}"
                                            >delete</i>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        block.html(items);
                    } else {
                        count.html('');
                    }
                    notySuccess(response.message ? response.message : 'Данные сформированы');
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function documentCreditSetAddInDocument() {
    $('#document-catalog-modal').on('click', '.js-set-document-spare-part', function (e) {
        let data = $(this).attr('data-spare-part');
        let button = $('.js-document-catalog-modal-credit-spare-part-add');
        let span = button.find('span');
        sparePartArray.push(data);
        notySuccess('Позиция добавлена');
        span.html(sparePartArray.length ? sparePartArray.length : '');
        button.show();
    });
}

function documentCreditSetAddFromDocument() {
    $('#document-catalog-modal').on('click', '.js-document-catalog-modal-credit-spare-part-add', function (e) {
        if (sparePartArray.length) {
            $.ajax({
                url: '/admin/document/ajax-credit-set-add-from-document',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                data: {sparePartArray},
                // processData: false,
                // contentType: false,
                beforeSend: function () {
                },
                success: function (response) {
                    let count = $('.js-set-credit-count');
                    let title = $('.js-set-credit-title');
                    let block = $('.js-document-credit-parts');
                    let link = $('.js-set-credit-link');
                    if (response.status) {
                        block.append(response.data);
                        documentCreditSearchParts();
                        documentCreditSearchStorage();
                        inputMask();
                        $('.js-document-credit-category-storage').select2();
                        notySuccess(response.message ? response.message : 'Данные сформированы');
                    } else {
                        notyError(response.message ? response.message : ERROR_MESSAGE);
                    }
                },
                error: function (response) {
                    errorResponse(response);
                },
                complete: function () {
                }
            });
        }
    });
}

function documentCreditSetDelete() {
    $('body').on('click', '.js-set-spare-part-delete', function (e) {
        let data = $(this).attr('data-document-spare-part');
        $.ajax({
            url: '/admin/document/ajax-credit-set-delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {id: data},
            // processData: false,
            // contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                let count = $('.js-set-credit-count');
                let title = $('.js-set-credit-title');
                let block = $('.js-set-credit-block');
                let link = $('.js-set-credit-link');
                if (response.status) {
                    let array = response.data;
                    if (array.length) {
                        count.html(array.length);
                        title.html(`<i data-feather="server" class="mr-2"></i>${array.length}  Позиции`);
                        let items = '';
                        for (key in array) {
                            items += `
                                <div class="list-group-item list-group-item-action js-set-credit-item">
                                    <div class="media">
                                        <div class="media-body ml-2">
                                            <p class="mb-0">${array[key]['title']}</p>
                                            <small class="text-secondary">${array[key]['oem']}</small>
                                            <i
                                                class="material-icons js-set-spare-part-delete"
                                                data-document-spare-part="${array[key]['id']}"
                                            >delete</i>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        block.html(items);
                    } else {
                        count.html('');
                        block.html('');
                        title.html(`<i data-feather="server" class="mr-2"></i>Нет данных`);
                        link.hide();
                    }
                    notySuccess(response.message ? response.message : 'Данные сформированы');
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function documentCreditCatalogPaste() {
    $('.js-document-credit').on('click', '.js-span-link', function (e) {
        let url = $(this).attr('data-href');
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            // dataType: 'json',
            data: {},
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                let block = $('.js-document-catalog-modal-credit');
                block.html(response);
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function documentCreditStorageChange() {
    $('.js-document-credit').on('change', '.js-document-credit-category-storage', function (e) {
        let group = $(this).closest('.form-group');
        let cnt = $(this).attr('data-select-storage-cnt');
        let uuid = $(this).closest('.js-document-credit-parts-item').attr('data-uuid');
        $.ajax({
            url: '/admin/document/ajax-catalog-storage-place-change',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {
                id: $(this).val(),
                uuid: uuid,
            },
            // processData: false,
            // contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    let selects = group.find('[data-select-storage-cnt]');
                    selects.each(function (index) {
                        if (cnt < index) {
                            let block = $(this).closest('.js-document-credit-category-storage-select-group');
                            block.remove();
                        }
                    });
                    group.append(response.data);
                    selects = group.find('[data-select-storage-cnt]');
                    selects.each(function (index) {
                        $(this).attr('data-select-storage-cnt', index);
                    });
                    notySuccess(response.message ? response.message : 'Данные сформированы');
                    $('.js-document-credit-category-storage').select2();
                    $('.js-document-credit-category-storage-place').select2();
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

/********** //document-credit **********/

/********** document-debit **********/
function documentSearchCustomer() {
    $('.js-document-search-customer').select2({
        ajax: {
            url: '/admin/document/ajax-catalog-customer',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.data
                };
            }
        },
        placeholder: 'Покупатель',
        minimumInputLength: 3,
        language: 'ru'
    });
}

function documentDebitSearchParts() {
    $('.js-document-debit-search-parts').select2({
        ajax: {
            url: '/admin/document/ajax-catalog-document-content-spare-part',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.data
                };
            }
        },
        placeholder: 'Поиск запасных частей',
        minimumInputLength: 3,
        language: 'ru'
    });
}

function documentDebitItemAdd() {
    $('body').on('click', '.js-document-debit-button-add-parts-item', function () {
        let id = uuid();
        let id_2 = uuid();
        let id_3 = uuid();
        let length = $('.js-document-debit-parts-item').length + 1;
        let html = `<div class="card mb-2 document-debit-parts-item js-document-debit-parts-item" data-id="0" data-uuid="${id}">
                        <div class="card-body p-2 p-sm-3">
                            <div class="media forum-item">
                                <div class="text-muted small text-center align-self-center pr-3">
                                    <span class="d-none d-sm-inline-block">${length}</span>
                                </div>
                                <div class="media-body">
                                    <input
                                        type="hidden"
                                        name="document_debit[item][${id}][catalog_document_content_id]">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control js-document-debit-search-parts"
                                                    data-placeholder="Запасная часть"
                                                    name="document_debit[item][${id}][spare_part]"
                                                    data-validator="document_debit.item.${id}.spare_part">
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="accordion-unstacked accordion-active-primary" id="accordion-unstacked-active-style-${id}">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <button class="btn dropdown-toggle collapsed" type="button" data-toggle="collapse" data-target="#accordion-unstacked-active-style-3-${id}" aria-expanded="false">
                                                            Информация
                                                        </button>
                                                    </div>
                                                    <div id="accordion-unstacked-active-style-3-${id}" class="collapse" data-parent="#accordion-unstacked-active-style-${id}">
                                                        <div class="card-body text-secondary">
                                                            <div class="document-debit-content-info js-document-debit-content-info"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label for="fieldset-input-${id_3}">Исходящая цена</label>
                                                    <input
                                                        type="text"
                                                        class="form-control inputmask"
                                                        id="fieldset-input-${id_3}"
                                                        name="document_debit[item][${id}][price_out]"
                                                        data-inputmask-alias="currency"
                                                        data-validator="document_debit.item.${id}.price_out">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="list-with-gap">
                                                <button type="button" class="btn btn-danger btn-xs js-document-debit-button-delete-parts-item">Удалить</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="parts-gallery js-document-debit-parts-gallery"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
        $('.js-document-debit-parts').append(html);
        documentDebitSearchParts();
        inputMask();
        fancybox();
    })
}

function documentDebitItemSelect() {
    $('body').on('change', '.js-document-debit-search-parts', function () {
        let block = $(this).closest('.js-document-debit-parts-item');
        let info = block.find('.js-document-debit-content-info');
        let images = block.find('.js-document-debit-parts-gallery');
        let data = JSON.parse($(this).val());
        $.ajax({
            url: '/admin/document/ajax-catalog-document-content-spare-part-info',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    let imagesBlock = '';
                    if (response.data.images && response.data.images.length) {
                        for (let i = 0, length = response.data.images.length; i < length; i++) {
                            imagesBlock += `
                                <div class="md-block-7 js-document-credit-parts-gallery-item">
                                    <div class="img rounded">
                                        <img src="${response.data.images[i]}" alt="Image">
                                        <div class="overlay-content text-center justify-content-end">
                                            <div class="btn-group mb-1" role="group">
                                                <a data-fancybox="gallery-123456789" href="${response.data.images[i]}">
                                                    <button type="button" class="btn btn-link btn-icon text-danger">
                                                        <i class="material-icons">zoom_in</i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    }
                    let html = `
                        <p><strong>Наименование:</strong> ${response.data.title}</p>
                        <p><strong>OEM:</strong> ${response.data.oem}</p>
                        <p><strong>Склад:</strong> ${response.data.catalog_storage_place}</p>
                        <p><strong>Цена входящая:</strong> ${response.data.price_in}</p>
                        <p><strong>Цена исходящая:</strong> ${response.data.price_out}</p>
                        <p><strong>Приходный докумет</strong> № ${response.data.catalog_document_id} от ${response.data.created_at}</p>
                        <p><strong>Поставщик:</strong> ${response.data.producer_name}</p>
                        <p><strong>Ответственный:</strong> ${response.data.user_name_short}</p>
                    `;
                    info.html(html);
                    images.html(imagesBlock);
                }
                fancybox();
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    })
}

function documentDebitItemDelete() {
    $('body').on('click', '.js-document-debit-button-delete-parts-item', function () {
        $(this).closest('.js-document-debit-parts-item').remove();
    })
}

function documentDebitItemDeleteFromBD() {
    $('body').on('click', '.js-document-debit-button-delete-parts-item-id', function () {
        let block = $(this).closest('.js-document-debit-parts-item');
        let id = block.attr('data-id');
        if (id * 1) {
            documentDeletePart(id);
        }
        block.remove();
    })
}

function documentDebitDocumentFromBD() {
    $('body').on('click', '[data-js-document-debit-table-id]', function (evt) {
        let block = $(this).closest('.js-document-debit-table');
        let id = $(this).attr('data-js-document-debit-table-id');
        documentDeleteDocument(id);
        block.remove();
    });

}

function documentDebitFormSend() {
    $('body').on('click', '.js-document-debit-save-button', function (e) {
        let form = $(this).closest('#document-debit-form');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/document/ajax-save-debit',
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
                    let block = $('.js-document-debit');
                    let html = $(response.data.view).find('#document-debit-form');
                    block.html(html);
                    App.select2();
                    documentDebitSearchParts();
                    documentSearchCustomer();
                    inputMask();
                    fancybox();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены')
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function documentDebitPosting() {
    $('body').on('click', '.js-document-debit-posting-button', function (e) {
        let form = $(this).closest('#document-debit-form');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/document/ajax-posting-debit',
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
                    let block = $('.js-document-debit');
                    let html = $(response.data.view).find('#document-debit-form');
                    block.html(html);
                    fancybox();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены');
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

/********** //document-debit **********/

/********** producer **********/
function producerFormSend() {
    $('.js-producer').on('click', '.js-producer-save-button', function (e) {
        let form = $(this).closest('#producer-form');
        let data = new FormData(form[0]);
        if (Object.keys(imageArray).length) {
            for (let key_1 in imageArray) {
                data.append('images[' + key_1 + ']', imageArray[key_1]);
            }
        }
        $.ajax({
            url: '/admin/producer/ajax-save',
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
                    let block = $('.js-producer');
                    let html = $(response.data.view).find('#producer-form');
                    block.html(html);
                    App.select2();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены')
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function producerDelete() {
    $('.js-producer').on('click', '[data-js-producer-table-id]', function (evt) {
        let block = $(this).closest('.js-producer-table');
        let id = $(this).attr('data-js-producer-table-id');
        $.ajax({
            url: '/admin/producer/ajax-delete/' + id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {},
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    notySuccess(response.message ? response.message : 'Позиция успешно удалена!');
                    block.remove();
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function producerFormFilter() {
    $('.js-producer').on('click', '.js-producer-filter-button', function (e) {
        let form = $(this).closest('.js-producer').find('#producer-form-filter');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/producer/ajax-filter',
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
                    let block = $('.js-producer');
                    let html = $(response.data.view).find('.js-producer-inner');
                    block.html(html);
                    App.select2();
                    dateRangePicker();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Данные сформированы');
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function producerChangeType() {
    $('.js-producer').on('change', '.js-producer-type', function (e) {
        let html = {
            1: `
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input
                            class="form-control"
                            placeholder="Название"
                            name="name"
                            id="name"
                            value=""
                            data-validator="name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name_full">Полное название</label>
                        <input
                            class="form-control"
                            placeholder="Полное название"
                            name="name_full"
                            id="name_full"
                            value=""
                            data-validator="name_full">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="site">Сайт</label>
                        <input
                            class="form-control"
                            placeholder="Сайт"
                            name="site"
                            id="site"
                            value=""
                            data-validator="site">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input
                            class="form-control"
                            placeholder="E-mail"
                            name="email"
                            id="email"
                            value=""
                            data-validator="email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="address_actual">Фактический адрес</label>
                        <input
                            class="form-control"
                            placeholder="Фактический адрес"
                            name="address_actual"
                            id="address_actual"
                            value=""
                            data-validator="address_actual">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="address_legal">Юридический адрес</label>
                        <input
                            class="form-control"
                            placeholder="Юридический адрес"
                            name="address_legal"
                            id="address_legal"
                            value=""
                            data-validator="address_legal">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="inn">ИНН</label>
                        <input
                            class="form-control"
                            placeholder="ИНН"
                            name="inn"
                            id="inn"
                            value=""
                            data-validator="inn">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="kpp">КПП</label>
                        <input
                            class="form-control"
                            placeholder="КПП"
                            name="kpp"
                            id="kpp"
                            value=""
                            data-validator="kpp">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="bik">БИК</label>
                        <input
                            class="form-control"
                            placeholder="БИК"
                            name="bik"
                            id="bik"
                            value=""
                            data-validator="bik">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="bank_name">Наименование банка</label>
                        <input
                            class="form-control"
                            placeholder="Наименование банка"
                            name="bank_name"
                            id="bank_name"
                            value=""
                            data-validator="bank_name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="account_correspondent">Корреспонденский счет</label>
                        <input
                            class="form-control"
                            placeholder="Корреспонденский счет"
                            name="account_correspondent"
                            id="account_correspondent"
                            value=""
                            data-validator="account_correspondent">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="account_checking">Расчетный счет</label>
                        <input
                            class="form-control"
                            placeholder="Расчетный счет"
                            name="account_checking"
                            id="account_checking"
                            value=""
                            data-validator="account_checking">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            `,
            2: `
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input
                            class="form-control"
                            placeholder="Название"
                            name="name"
                            id="name"
                            value=""
                            data-validator="name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name_full">Полное название</label>
                        <input
                            class="form-control"
                            placeholder="Полное название"
                            name="name_full"
                            id="name_full"
                            value=""
                            data-validator="name_full">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input
                            class="form-control"
                            placeholder="E-mail"
                            name="email"
                            id="email"
                            value=""
                            data-validator="email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            `,
            3: `
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input
                            class="form-control"
                            placeholder="Название"
                            name="name"
                            id="name"
                            value=""
                            data-validator="name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name_full">Полное название</label>
                        <input
                            class="form-control"
                            placeholder="Полное название"
                            name="name_full"
                            id="name_full"
                            value=""
                            data-validator="name_full">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="vin">VIN</label>
                        <input
                            class="form-control"
                            placeholder="VIN"
                            name="vin"
                            id="vin"
                            value=""
                            data-validator="vin">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="producer-images">
                            <a type="button" class="btn btn-primary">Загрузить фото</a>
                        </label>
                        <input
                            type="file"
                            id="producer-images"
                            class="custom-input-file js-producer-images-input"
                            name="images"
                            multiple=""
                            accept="image/*">
                    </div>
                    <div class="parts-gallery js-producer-images-block">
                    </div>
                </div>
            `
        };
        let type = $(this).val();
        $('.js-producer-fields').html(html[type]);
    });
}

function producerImageArrayDraw(array) {
    if (Object.keys(array).length) {
        let block = $('.js-producer-images-block');
        for (key in array) {
            let imageUrl = URL.createObjectURL(array[key]);
            let image = `<div class="md-block-7 js-producer-gallery-item">
                            <div class="img rounded">
                                <img src="${imageUrl}" alt="Image">
                                <div class="overlay-content text-center justify-content-end">
                                    <div class="btn-group mb-1" role="group">
                                        <a data-fancybox="gallery" href="${imageUrl}">
                                            <button type="button" class="btn btn-link btn-icon text-danger">
                                                <i class="material-icons">zoom_in</i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-link btn-icon text-danger" data-js-producer-images-array-id="${key}">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            block.append(image);
        }
        notyInfo('Нажмите "Сохранить", что бы загрузить изображение');
        fancybox();
    }
}

function producerImageArrayAdd() {
    $('.js-producer').on('change', '.js-producer-images-input', function (evt) {
        let array = {};
        let files = evt.target.files; // FileList object
        let fileArray = Array.from(files);
        $(this)[0].value = '';
        for (let i = 0, l = fileArray.length; i < l; i++) {
            let id = uuid();
            imageArray[id] = fileArray[i];
            array[id] = fileArray[i];
        }
        producerImageArrayDraw(array);
    });

}

function producerImageArrayDelete() {
    $('.js-producer').on('click', '[data-js-producer-images-array-id]', function (evt) {
        let image = $(this).closest('.js-producer-gallery-item');
        let id = $(this).attr('data-js-producer-images-array-id');
        delete imageArray[id];
        image.remove();
    });

}

function producerImageDeleteFromBD() {
    $('.js-producer').on('click', '[data-js-producer-images-id]', function (evt) {
        let image = $(this).closest('.js-producer-gallery-item');
        let id = $(this).attr('data-js-producer-images-id');
        producerDeleteImage(id);
        image.remove();
    });

}

function producerDeleteImage(id) {
    $.ajax({
        url: '/admin/producer/ajax-delete-image/' + id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: {},
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                notySuccess(response.message ? response.message : 'Изображение успешно удалено!')
            } else {
                notyError(response.message ? response.message : ERROR_MESSAGE);
            }
        },
        error: function (response) {
            notyError(ERROR_MESSAGE);
        },
        complete: function () {
        }
    });
}

/********** //producer **********/

/********** customer **********/
function customerFormSend() {
    $('body').on('click', '.js-customer-save-button', function (e) {
        let form = $(this).closest('#customer-form');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/customer/ajax-save',
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
                    let block = $('.js-customer');
                    let html = $(response.data.view).find('#customer-form');
                    block.html(html);
                    App.select2();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены')
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function customerDelete() {
    $('body').on('click', '[data-js-customer-table-id]', function (evt) {
        let block = $(this).closest('.js-customer-table');
        let id = $(this).attr('data-js-customer-table-id');
        $.ajax({
            url: '/admin/customer/ajax-delete/' + id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {},
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    notySuccess(response.message ? response.message : 'Позиция успешно удалена!');
                    block.remove();
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function customerFormFilter() {
    $('body').on('click', '.js-customer-filter-button', function (e) {
        let form = $(this).closest('.js-customer').find('#customer-form-filter');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/customer/ajax-filter',
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
                    let block = $('.js-customer');
                    let html = $(response.data.view).find('.js-customer-inner');
                    block.html(html);
                    dateRangePicker();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Данные сформированы');
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

/********** //customer **********/

/********** employee **********/
function employeeFormSend() {
    $('body').on('click', '.js-employee-save-button', function (e) {
        let form = $(this).closest('#employee-form');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/employee/ajax-save',
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
                    let block = $('.js-employee');
                    let html = $(response.data.view).find('#employee-form');
                    block.html(html);
                    App.select2();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены')
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function employeeDelete() {
    $('body').on('click', '[data-js-employee-table-id]', function (evt) {
        let block = $(this).closest('.js-employee-table');
        let id = $(this).attr('data-js-employee-table-id');
        $.ajax({
            url: '/admin/employee/ajax-delete/' + id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {},
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    notySuccess(response.message ? response.message : 'Позиция успешно удалена!');
                    block.remove();
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function employeeFormFilter() {
    $('body').on('click', '.js-employee-filter-button', function (e) {
        let form = $(this).closest('.js-employee').find('#employee-form-filter');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/employee/ajax-filter',
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
                    let block = $('.js-employee');
                    let html = $(response.data.view).find('.js-employee-inner');
                    block.html(html);
                    dateRangePicker();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Данные сформированы');
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

/********** //employee **********/

/********** storage-place **********/
function storagePlaceFormSend() {
    $('body').on('click', '.js-storage-place-save-button', function (e) {
        let form = $(this).closest('#storage-place-form');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/storage-place/ajax-save',
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
                    let block = $('.js-storage-place');
                    let html = $(response.data.view).find('#storage-place-form');
                    block.html(html);
                    App.select2();
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены')
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function storagePlaceFormSendGroup() {
    $('body').on('click', '.js-storage-place-group-save-button', function (e) {
        let form = $(this).closest('#storage-place-group-form');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/storage-place/ajax-create-group',
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
                    let block = $('.js-storage-place .js-inc');
                    console.log(block)
                    let html = response.data.view;
                    block.html(html);
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Все изменения сохранены')
                }
            },
            error: function (response) {
                errorResponse(response);
            },
            complete: function () {
            }
        });
    });
}

function storagePlaceDelete() {
    $('body').on('click', '[data-js-storage-place-table-id]', function (evt) {
        let block = $(this).closest('.js-storage-place-table');
        let id = $(this).attr('data-js-storage-place-table-id');
        $.ajax({
            url: '/admin/storage-place/ajax-delete/' + id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: {},
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    notySuccess(response.message ? response.message : 'Позиция успешно удалена!');
                    block.remove();
                } else {
                    notyError(response.message ? response.message : ERROR_MESSAGE);
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

function storagePlaceFormFilter() {
    $('body').on('click', '.js-storage-place-filter-button', function (e) {
        let form = $(this).closest('.js-storage-place').find('#storage-place-form-filter');
        let data = new FormData(form[0]);
        $.ajax({
            url: '/admin/storage-place/ajax-filter',
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
                    let block = $('.js-storage-place');
                    let html = $(response.data.view).find('.js-storage-place-inner');
                    block.html(html);
                    if (response.data.url) {
                        setLocation(response.data.url);
                    }
                    notySuccess('Данные сформированы');
                    dateRangePicker();
                    App.select2();
                }
            },
            error: function (response) {
                notyError(ERROR_MESSAGE);
            },
            complete: function () {
            }
        });
    });
}

/********** //storage-place **********/
const config = () => {
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
$(document).ready(function () {
    config();
    imageAdd();
    imagesArrayAdd();
    imagesArrayDelete();
    sendForm();
    catalogProductWidgetAdd();
})
