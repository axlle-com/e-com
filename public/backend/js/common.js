/********** #start sendForm **********/
const sendForm = () => {
    $('.a-shop .a-shop-block').on('click', '.js-save-button', function (e) {
        let saveButton = $(this);
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
        });
    });
}
const saveForm = (saveButton) => {
    let form = saveButton.closest('#global-form');
    if (form) {
        let err = [];
        let isErr = false;
        $.each(form.find('[data-validator-required]'), function (index, value) {
            err.push(_glob.validation.change($(this)));
        });
        isErr = err.indexOf(true) !== -1;
        if (!isErr) {
            _glob.send.form(form, (response) => {
                if (response.status) {
                    _glob.images = {};
                    let block = $('.a-shop-block');
                    let html = $(response.data.view);
                    block.html(html);
                    _glob.select2();
                    _config.fancybox();
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
                    Swal.fire('Сохранено', '', 'success');
                }
            })
        } else {
            _glob.noty.error('Ошибка валидации');
        }
    }
}
/********** #start images **********/
const _image = {
    confirm: (obj, image) => {
        Swal.fire({
            icon: 'warning',
            title: 'Вы уверены что хотите удалить изображение?',
            text: 'Изменения нельзя будет отменить',
            showDenyButton: true,
            confirmButtonText: 'Удалить',
            denyButtonText: 'Отменить',
        }).then((result) => {
            if (result.isConfirmed) {
                _glob.send.object(obj, '/admin/blog/ajax/delete-image', (response) => {
                    if (response.status) {
                        image.remove();
                        _glob.noty.success('Изображение удалено', '', 'success')
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Изображение не удалено', '', 'info')
            }
        })
    },
    add: function () {
        let self = this;
        $('.a-shop').on('change', '.js-image-upload', function () {
            let input = $(this);
            let div = $(this).closest('fieldset');
            let image = div.find('.js-image-block');
            let file = window.URL.createObjectURL(input[0].files[0]);
            $('.js-image-block-remove').slideDown();
            if (image.length) {
                $(image).html(`<div class="image-box" style="background-image: url(${file}); background-size: cover;background-position: center;"></div>`);
                _config.fancybox();
            }
            _glob.noty.success('Нажните сохранить, что бы загрузить изображение')
        });
    },
    delete: function () {
        let self = this;
        $('.a-shop').on('click', '[data-js-image-array-id]', function (evt) {
            let image = $(this).closest('.js-gallery-item');
            if (!image.length) {
                image = $(this).closest('fieldset').find('.image-box');
                if (!image.length) {
                    return;
                }
            }
            let id = $(this).attr('data-js-image-array-id');
            let idGall;
            if (id) {
                let arr = id.split('.');
                idGall = arr[0];
                id = arr[1];
            }
            let idBd = $(this).attr('data-js-image-id');
            let model = $(this).attr('data-js-image-model');
            if (idBd && model) {
                self.confirm({'id': idBd, 'model': model}, image)
            } else {
                delete _glob.images[idGall]['images'][id];
                image.remove();
            }
        });
    },
    arrayAdd: function () {
        let self = this;
        $('.a-shop').on('change', '.js-blog-category-gallery-input', function (evt) {
            let idGallery = $(this).attr('data-js-gallery-id');
            if (!idGallery) {
                idGallery = _glob.uuid();
                $(this).attr('data-js-gallery-id', idGallery);
            }
            let array = {};
            let files = evt.target.files;
            let fileArray = Array.from(files);
            $(this)[0].value = '';
            for (let i = 0, l = fileArray.length; i < l; i++) {
                let id = _glob.uuid();
                if (!_glob.images[idGallery]) {
                    _glob.images[idGallery] = {};
                    _glob.images[idGallery]['images'] = {};
                }
                _glob.images[idGallery]['images'][id] = {};
                _glob.images[idGallery]['images'][id]['file'] = fileArray[i];
                array[id] = fileArray[i];
            }
            self.arrayDraw(array, idGallery);
        });
    },
    arrayDraw: function (array, idGallery) {
        let self = this;
        if (Object.keys(array).length) {
            let selector = `[data-js-gallery-id="${idGallery}"]`;
            let block = $(selector).closest('.js-galleries-general-block').find('.js-gallery-block-saved');
            for (let key in array) {
                let imageUrl = URL.createObjectURL(array[key]);
                let image = `<div class="md-block-5 js-gallery-item sort-handle">
                            <div class="img rounded">
                                <div class="image-box" style="background-image: url(${imageUrl}); background-size: cover;background-position: center;"></div>
                                <div class="overlay-content text-center justify-content-end">
                                    <div class="btn-group mb-1" role="group">
                                        <a data-fancybox="gallery" href="${imageUrl}">
                                            <button type="button" class="btn btn-link btn-icon text-danger">
                                                <i class="material-icons">zoom_in</i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-link btn-icon text-danger" data-js-image-array-id="${idGallery}.${key}">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-group small">
                                    <input class="form-control form-shadow" placeholder="Заголовок" name="galleries[${idGallery}][images][${key}][title]" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group small">
                                    <input class="form-control form-shadow" placeholder="Описание" name="galleries[${idGallery}][images][${key}][description]" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group small">
                                    <input class="form-control form-shadow" placeholder="Сортировка" name="galleries[${idGallery}][images][${key}][sort]" value="">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>`;
                block.append(image);
            }
            _glob.noty.info('Нажмите "Сохранить", что бы загрузить изображение');
            _config.fancybox();
            _config.sort();
        }
    },
    gallerySort: function () {

    },
    run: function () {
        this.add();
        this.delete();
        this.arrayAdd();
        this.gallerySort();
    }
}
/********** #start catalog **********/
const _product = {
    widget: {
        confirm: function (obj, widget) {
            let self = this;
            Swal.fire({
                icon: 'warning',
                title: 'Вы уверены что хотите удалить виджет?',
                text: 'Изменения нельзя будет отменить',
                showDenyButton: true,
                confirmButtonText: 'Удалить',
                denyButtonText: 'Отменить',
            }).then((result) => {
                if (result.isConfirmed) {
                    _glob.send.object(obj, '/admin/blog/ajax/delete-widget', (response) => {
                        if (response.status) {
                            _glob.noty.success('Все изменения сохранены');
                            widget.remove();
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Виджет не удален', '', 'info')
                }
            })
        },
        add: function () {
            let self = this;
            $('.a-shop .a-shop-block').on('click', '.js-widgets-button-add', function (evt) {
                let formGroup = $(this).closest('.catalog-tabs').find('.widget-tabs-block');
                let uu = _glob.uuid();
                let widget = `<div class="col-sm-12 widget-tabs mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                Widget Tabs
                                <div class="btn-group btn-group-sm ml-auto" role="group">
                                    <button type="button" class="btn btn-light btn-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-light btn-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-light btn-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-trash">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="dropdown ml-1">
                                    <button class="btn btn-sm btn-light btn-icon dropdown-toggle no-caret" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">arrow_drop_down</i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" style="">
                                        <button class="dropdown-item" type="button">Action</button>
                                        <button class="dropdown-item" type="button">Another action</button>
                                        <button class="dropdown-item" type="button">Something else here</button>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    data-action="close"
                                    data-js-widget-model=""
                                    data-js-widget-id=""
                                    data-js-widget-array-id="${uu}"
                                    class="ml-1 btn btn-sm btn-light btn-icon">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                            <div class="card-body">
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
                                                        data-validator-required
                                                        data-validator="tabs.${uu}.title"
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
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                formGroup.append(widget);
                $('.summernote').summernote({
                    height: 150
                });
            });
        },
        delete: function () {
            let self = this;
            $('.a-shop').on('click', '[data-js-widget-array-id]', function (evt) {
                let widget = $(this).closest('.widget-tabs');
                if (!widget.length) {
                    return;
                }
                let idBd = $(this).attr('data-js-widget-id');
                let model = $(this).attr('data-js-widget-model');
                if (idBd && model) {
                    self.confirm({'id': idBd, 'model': model}, widget);
                } else {
                    widget.remove();
                }
            });
        },
    },
    currency: {},
    property: {
        add: function () {
            let self = this;
            $('.a-shop .a-shop-block').on('click', '.js-catalog-property-add', function (evt) {
                let formGroup = $(this).closest('.catalog-tabs').find('.catalog-property-block');
                let ids = JSON.parse($(this).attr('data-js-properties-ids'));
                _glob.send.object({ids}, '/admin/catalog/ajax/add-property', (response) => {
                    if (response.status) {
                        let widget;
                        if (response.data && (widget = response.data.view)) {
                            formGroup.append(widget);
                            _glob.select2();
                            _config.sort();
                        }
                    }
                });
            });
        },
        delete: function () {
            let self = this;
            $('.a-shop').on('click', '[data-js-property-array-id]', function (evt) {
                let widget = $(this).closest('.js-catalog-property-widget');
                if (!widget.length) {
                    return;
                }
                let idBd = $(this).attr('data-js-property-value-id');
                let model = $(this).attr('data-js-property-value-model');
                if (idBd && model) {
                    self.confirm({'id': idBd, 'model': model}, widget);
                } else {
                    widget.remove();
                }
            });
        },
        confirm: function (obj, widget) {
            let self = this;
            Swal.fire({
                icon: 'warning',
                title: 'Вы уверены что хотите удалить виджет?',
                text: 'Изменения нельзя будет отменить',
                showDenyButton: true,
                confirmButtonText: 'Удалить',
                denyButtonText: 'Отменить',
            }).then((result) => {
                if (result.isConfirmed) {
                    _glob.send.object(obj, '/admin/catalog/ajax/delete-property', (response) => {
                        if (response.status) {
                            _glob.noty.success('Все изменения сохранены');
                            widget.remove();
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Виджет не удален', '', 'info')
                }
            })
        },
        typeChange: function () {
            let self = this;
            $('.a-shop .a-shop-block').on('change', '.js-property-type', function (evt) {
                let block = $(this).closest('.js-catalog-property-widget');
                let typeArr = [], type, input, units;
                try {
                    typeArr = $(this).find(':selected').attr('data-js-property-type').split('_has_');
                    type = _glob.propertyTypes[typeArr[typeArr.length - 1]];
                    let un = JSON.parse($(this).find(':selected').attr('data-js-property-units'));
                    units = un[0] ? un[0] : 0;
                } catch (exception) {
                    _glob.console.error(exception.message);
                }
                if (type) {
                    input = block.find('.js-property-value');
                    input.prop('type', type);
                }
                if (units) {
                    block.find('.js-property-unit').val(units).trigger('change');
                } else {
                    block.find('.js-property-unit').val(null).trigger('change');
                }
            });
        },
    },
    run: function () {
        this.property.add();
        this.property.delete();
        this.property.typeChange();
        this.widget.add();
        this.widget.delete();
    },
}
const _property = {
    _modal: {},
    modal: function () {
        // if (Object.keys(this._modal).length) {
        //     return this._modal;
        // }
        this._modal = $('#property-modal');
        return this._modal;
    },
    add: function () {
        let self = this, data;
        $('.a-shop').on('click', '[data-target="#property-modal"]', function (evt) {
            _glob.send.object({}, '/admin/catalog/ajax/add-property-self', (response) => {
                if ((data = _glob.send.data(response))) {
                    self.modal().find('.js-property-modal-body').html(data.view);
                    self.modal().find('.modal-title').html('Добавление нового свойства');
                    _glob.select2();
                } else {
                    _glob.console.error();
                }
            });
        });
    },
    save: function () {
        let self = this, data, form, button;
        $('.a-shop').on('click', '.js-save-modal-button', function (evt) {
            button = $(this);
            form = button.closest('.modal').find('.js-property-modal-body');
            data = {};
            form.find('input, textearea, select').each(function () {
                data[this.name] = $(this).val();
            });
            _glob.send.object(data, '/admin/catalog/ajax/save-property-self', (response) => {
                if ((data = _glob.send.data(response))) {
                    let un = [];
                    if (Object.keys(data.units).length) {
                        for (let i = 0, len = Object.keys(data.units).length; i < len; i++) {
                            un[i] = data.units[i].id;
                        }
                    }
                    self.modal().modal('hide');
                    let selector = `[data-js-catalog-property-id="${data.id}"]`;
                    let input = $(selector);
                    if (input.length) {
                        input.val(data.title);
                    }
                    let option = `<option value="${data.id}"
                                    data-js-property-units="${JSON.stringify(un)}"
                                    data-js-property-type="${data.type_resource}">${data.title}
                                </option>`;
                    $('.catalog-property-block').find('.js-property-type').append(option);
                } else {
                    _glob.console.error();
                }
            });
        });
    },
    edit: function () {
        let self = this, data, form, button, property_id;
        $('.a-shop').on('click', '[data-js-property-id]', function (evt) {
            button = $(this);
            let block = button.closest('.catalog-property-block');
            property_id = button.attr('data-js-property-id');
            if (property_id) {
                _glob.send.object({property_id}, '/admin/catalog/ajax/add-property-self', (response) => {
                    if ((data = _glob.send.data(response))) {
                        console.log(self.modal())
                        self.modal().find('.js-property-modal-body').html(data.view);
                        self.modal().find('.modal-title').html('Редактирование');
                        _glob.select2();
                        self.modal().modal('show');
                    } else {
                        _glob.console.error();
                    }
                });
            }
        });
    },
    closeModal: function () {
        this.modal().on('hidden.bs.modal', function (e) {
            $(this).find('.js-property-modal-body').html('');
            $(this).find('.modal-title').html('');
        })
    },
    run: function () {
        this.add();
        this.edit();
        this.save();
        this.closeModal();
    },
}
const catalogProductShowCurrency = () => {
    $('.a-shop').on('change', '[name="price[810]"].js-action', function (evt) {
        let input = $(this);
        let block = $(this).closest('.js-currency-block');
        let currencyGroup = block.find('[data-currency-code]');
        let currencyArray = [];
        let formatter = new Intl.NumberFormat('en-US', {
            maximumSignificantDigits: 2
        });
        currencyGroup.each(function (i) {
            currencyArray.push($(this).attr('data-currency-code'));
        });
        _glob.send.object({'currency': currencyArray}, '/admin/catalog/ajax/show-rate-currency', (response) => {
            $.each(response.data, function (i, value) {
                let curr = i.replace('__', '');
                let selector = `[data-currency-code="${curr}"]`;
                block.find(selector).val(formatter.format(input.val() * (1 / value)));
            });
            _glob.noty.success('Валюты загружены')
        })
    });
}
/********** #start postCategory **********/
/********** #end postCategory **********/
const _config = {
    sort: function () {
        let block = document.querySelectorAll('.sortable');
        if (block.length) {
            block.forEach(function (el) {
                const swap = el.classList.contains('swap')
                Sortable.create(el, {
                    swap: swap,
                    animation: 150,
                    handle: '.sort-handle',
                    filter: '.remove-handle',
                    onFilter: function (evt) {
                        evt.item.parentNode.removeChild(evt.item)
                    },
                    onSort: function (evt) {
                        let blocks0 = $(evt.item).closest('.swap').find('[name$="[sort]"]');
                        let blocks1 = $(evt.item).closest('.swap').find('[name$="[property_value_sort]"]');
                        if (blocks0.length) {
                            $.each(blocks0, function (i, value) {
                                $(this).val(i + 1);
                            });
                        }
                        if (blocks1.length) {
                            $.each(blocks1, function (i, value) {
                                $(this).val(i + 1);
                            });
                        }
                    },
                })
            })
        }
    },
    fancybox: function () {
        Fancybox.bind('[data-fancybox]', {});
    },
    dateRangePicker: function () {
        flatpickr('.date-range-picker', {
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
    },
    run: function () {
        this.sort();
        this.fancybox();
        this.dateRangePicker();
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
        $('#document-catalog-modal').on('hidden.bs.modal', function (e) {
            let button = $('.js-document-catalog-modal-credit-spare-part-add');
            let span = button.find('span');
            span.html('');
            button.hide();
        });
    }
}
$(document).ready(function () {
    _glob.run();
    _config.run();
    _image.run();
    _product.run();
    _property.run();
    sendForm();
    catalogProductShowCurrency();
})
