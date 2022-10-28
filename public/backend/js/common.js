/********** #start sendForm **********/
const _form = {
    _block: [],
    confirm: function () {
        const self = this;
        self._block.on('click', '.js-save-button', function (e) {
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
                    self.send(saveButton);
                } else if (result.isDenied) {
                    Swal.fire('Изменения не сохранены', '', 'info');
                }
            });
        });
    },
    send: function (saveButton) {
        let form = saveButton.closest('#global-form');
        if (form) {
            const request = new _glob.request(form).setPreloader('.js-product');
            request.send((response) => {
                if (response.status) {
                    let html = $(response.data.view);
                    self._block.html(html);
                    _glob.images = {};
                    _glob.select2();
                    _config.run();
                    Swal.fire('Сохранено', '', 'success');
                }
            });
        }
    },
    run: function (selector) {
        this._block = $(selector);
        if (this._block.length) {
            this.confirm();
        }
    }
}
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
                Swal.fire('Изменения не сохранены', '', 'info');
            }
        });
    });
}
const saveForm = (saveButton) => {
    let form = saveButton.closest('#global-form');
    if (form) {
        const request = new _glob.request(form).setPreloader('.js-product');
        request.send((response) => {
            if (response.status) {
                _glob.images = {};
                let block = $('.a-shop-block');
                let html = $(response.data.view);
                block.html(html);
                _glob.select2();
                _config.run();
                Swal.fire('Сохранено', '', 'success');
            }
        })
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
                        _glob.noty.success('Изображение удалено', '', 'success');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Изображение не удалено', '', 'info');
            }
        })
    },
    add: function () {
        const self = this;
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
            _glob.noty.success('Нажните сохранить, что бы загрузить изображение');
        });
    },
    delete: function () {
        const self = this;
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
        const self = this;
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
        const self = this;
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
    _block: {},
    isActive: function (selector) {
        const self = this;
        self._block = $(selector);
        if (self._block.length) {
            return true;
        }
    },
    currency: {},
    widget: {
        confirm: function (obj, widget) {
            const self = this;
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
            const self = this;
            _product._block.on('click', '.js-widgets-button-add', function (evt) {
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
            const self = this;
            _product._block.on('click', '[data-js-widget-array-id]', function (evt) {
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
    property: {
        add: function () {
            const self = this;
            _product._block.on('click', '.js-catalog-property-add', function (evt) {
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
            const self = this;
            _product._block.on('click', '[data-js-property-array-id]', function (evt) {
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
            const self = this;
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
            const self = this;
            _product._block.on('change', '.js-property-type', function (evt) {
                let block = $(this).closest('.js-catalog-property-widget');
                let typeArr = [], type, input, un, resource;
                try {
                    resource = $(this).find(':selected').attr('data-js-property-type');
                    typeArr = resource.split('_has_');
                    type = _glob.propertyTypes[typeArr[typeArr.length - 1]];
                    un = $(this).find(':selected').attr('data-js-property-units');
                } catch (exception) {
                    _glob.console.error(exception.message);
                }
                if (resource) {
                    block.find('[name$="[type_resource]"]').val(resource);
                }
                if (type) {
                    input = block.find('.js-property-value');
                    input.prop('type', type);
                }
                if (un) {
                    block.find('.js-property-unit').val(un).trigger('change');
                } else {
                    block.find('.js-property-unit').val(null).trigger('change');
                }
            });
        },
    },
    sort: function () {
        const self = this;
        let block = document.querySelectorAll('.sortable');
        let button = $('.a-product-index .js-product-sort-save');
        if (block.length) {
            block.forEach(function (el) {
                const swap = el.classList.contains('swap')
                Sortable.create(el, {
                    swap: swap,
                    animation: 150,
                    handle: '.sort-handle',
                    filter: '.remove-handle',
                    onFilter: function (evt) {
                        evt.item.parentNode.removeChild(evt.item);
                    },
                    onSort: function (evt) {
                        button.show();
                    },
                })
            });
            const request = new _glob.request().setPreloader('.js-product');
            $('.a-shop').on('click', '.a-product-index .js-product-sort-save', function (evt) {
                let product = $('.a-product-index [data-js-product-id]');
                evt.preventDefault();
                let array = [];
                $.each(product, function (i, value) {
                    array.push($(this).attr('data-js-product-id'));
                });
                let form = {
                    action: '/admin/catalog/ajax/save-product-sort',
                    ids: array,
                };
                request.setObject(form).send((response) => {
                    _glob.noty.info('Порядок сохранен!');
                    button.hide();
                });
            });
        }
    },
    run: function (selector) {
        if (this.isActive(selector)) {
            this.property.add();
            this.property.delete();
            this.property.typeChange();
            this.widget.add();
            this.widget.delete();
        }
        if ($('.a-shop .a-product-index').length) {
            this.sort();
        }
    },
}
const _property = {
    _modal: {},
    _block: {},
    confirm: function (obj, block) {
        const self = this;
        const request = new _glob.request(obj);
        Swal.fire({
            icon: 'warning',
            title: 'Вы уверены что хотите удалить?',
            text: 'Изменения нельзя будет отменить',
            showDenyButton: true,
            confirmButtonText: 'Удалить',
            denyButtonText: 'Отменить',
        }).then((result) => {
            if (result.isConfirmed) {
                request.send((response) => {
                    if (response.status) {
                        _glob.noty.success('Все изменения сохранены');
                        block.remove();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Позиция не удалена', '', 'info');
            }
        })
    },
    isActive: function (selector) {
        const self = this;
        self._block = $(selector);
        if (self._block.length) {
            return true;
        }
    },
    modal: function () {
        this._modal = $('#property-modal');
        return this._modal;
    },
    add: function () {
        let self = this, view;
        const request = new _glob.request({action: '/admin/catalog/ajax/add-property-self'});
        self._block.on('click', '[data-target="#property-modal"]', function (evt) {
            request.send((response) => {
                if ((view = request.view)) {
                    self.modal().find('.js-property-modal-body').html(view);
                    self.modal().find('.modal-title').html('Добавление нового свойства');
                    _glob.select2();
                } else {
                    _glob.console.error();
                }
            });
        });
    },
    save: function () {
        let self = this, body, form, button, data;
        const request = new _glob.request();
        self._block.on('click', '.js-save-modal-button', function (evt) {
            button = $(this);
            form = button.closest('.modal').find('.js-property-modal-body');
            body = {action: '/admin/catalog/ajax/save-property-self'};
            form.find('input, textearea, select').each(function () {
                body[this.name] = $(this).val();
            });
            request.setObject(body).send((response) => {
                if ((data = request.data)) {
                    self.modal().modal('hide');
                    let selector = `[data-js-catalog-property-id="${data.id}"]`;
                    let input = $(selector);
                    if (input.length) {
                        input.val(data.title);
                    }
                    let option = `<option value="${data.id}"
                                    data-js-property-units="${data.unit.id}"
                                    data-js-property-type="${data.type_resource}">${data.title}
                                </option>`;
                    $('.catalog-property-block').find('.js-property-type').append(option);
                } else {
                    _glob.console.error();
                }
            });
        });
    },
    delete: function () {
        const self = this;
        self._block.on('click', '[data-js-property-table-id]', function (evt) {
            evt.preventDefault();
            const element = $(this);
            let block = element.closest('tr');
            if (!block.length) {
                return;
            }
            let id = element.attr('data-js-property-table-id');
            if (id) {
                self.confirm({id, 'action': '/admin/catalog/ajax/delete-property-model'}, block);
            } else {
                block.remove();
            }
        });
    },
    edit: function () {
        let self = this, data, form, button, property_id;
        const request = new _glob.request();
        self._block.on('click', '[data-js-property-id]', function (evt) {
            button = $(this);
            let block = button.closest('.catalog-property-block');
            property_id = button.attr('data-js-property-id');
            if (property_id) {
                request.setObject({property_id, action: '/admin/catalog/ajax/add-property-self'}).send((response) => {
                    if ((data = request.data)) {
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
    run: function (selector) {
        if (this.isActive(selector)) {
            this.add();
            this.edit();
            this.save();
            this.delete();
            this.closeModal();
        }
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
        });
    });
}
/********** #start _document **********/
const _document = {
    _block: [],
    _items: {},
    block: function (selector = null) {
        if (selector) {
            this._block = $(selector).length ? $(selector) : [];
        }
        return this._block;
    },
    isActive: function (selector) {
        return !!this.block(selector).length;
    },
    addContent: function () {
        let self = this, data, form, button, property_id;
        const request = new _glob.request();
        self.block().on('click', '.js-catalog-document-content-add', function (evt) {
            const uuid = _glob.uuid();
            const out = $(this).attr('data-price-out');
            let outInput = '';
            if (out) {
                outInput = `<div class="form-group price-product small">
                                <label>
                                    Цена продажи
                                    <input
                                        type="number"
                                        value=""
                                        name="contents[${uuid}][price_out]"
                                        class="form-control form-shadow price_in"
                                        data-validator="contents.${uuid}.price_out"
                                        placeholder="Цена продажи">
                                </label>
                            </div>`;
            }
            let block = $('.js-catalog-document-content-inner');
            let html = `<div class="mb-3 document-content js-catalog-document-content sort-handle">
                            <div class="card h-100">
                                <div class="card-header">
                                    Строка
                                    <div class="btn-group btn-group-sm ml-auto" role="group">
                                        <button type="button" class="btn btn-light btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round" class="feather feather-plus">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-light btn-icon">
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
                                        data-js-document-content-value-id=""
                                        data-js-document-content-array-id="${uuid}"
                                        class="ml-1 btn btn-sm btn-light btn-icon">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <div class="form-group product small">
                                            <label>
                                                Продукт
                                                <select
                                                    class="form-control select2 js-document-get-product"
                                                    data-placeholder="Продукт"
                                                    data-select2-search="true"
                                                    data-validator-required
                                                    data-validator="contents.${uuid}.catalog_product_id"
                                                    name="contents[${uuid}][catalog_product_id]">
                                                    <option></option>
                                                </select>
                                            </label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group quantity-product small">
                                            <label>
                                                Кол.
                                                <input
                                                    type="number"
                                                    value="1"
                                                    name="contents[${uuid}][quantity]"
                                                    class="form-control form-shadow quantity"
                                                    data-validator-required
                                                    data-validator="contents.${uuid}.quantity"
                                                    placeholder="Количество">
                                            </label>
                                        </div>
                                        <div class="form-group price-product small">
                                            <label>
                                                Цена
                                                <input
                                                    type="number"
                                                    value=""
                                                    name="contents[${uuid}][price]"
                                                    class="form-control form-shadow price_in"
                                                    data-validator="contents.${uuid}.price"
                                                    placeholder="Цена">
                                            </label>
                                        </div>
                                        ${outInput}
                                        <div class="form-group stock-product small">
                                            <label>
                                                На складе
                                                <input
                                                    type="number"
                                                    value=""
                                                    class="form-control form-shadow in_stock" disabled>
                                            </label>
                                            <label>
                                                Резерв
                                                <input
                                                    type="number"
                                                    value=""
                                                    class="form-control form-shadow in_reserve" disabled>
                                            </label>
                                            <label>
                                                До
                                                <input
                                                    type="text"
                                                    value=""
                                                    class="form-control form-shadow reserve_expired_at" disabled>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            block.append(html);
            _config.documentSearchProduct('.js-document-get-product');
            // self.changeContent('.js-document-get-product');
        });
    },
    changeContent: function (selector) {
        let self = this, option, block, in_stock, in_reserve, reserve_expired_at, price_in, price_out;
        self.block().on('select2:select', selector, function (evt) {
            option = $(this).find(':selected');
            block = option.closest('.js-catalog-document-content');
            in_stock = block.find('.in_stock');
            if (in_stock.length) {
                in_stock.val(option.attr('data-in-stock'));
            }
            in_reserve = block.find('.in_reserve');
            if (in_reserve.length) {
                in_reserve.val(option.attr('data-in-reserve'));
            }
            reserve_expired_at = block.find('.reserve_expired_at');
            const expiredAt = option.attr('data-reserve-expired-at');
            if (reserve_expired_at.length && expiredAt) {
                let now = new Date(expiredAt * 1000).format('HH:MM:ss dd.mm.yyyy');
                reserve_expired_at.val(now);
            }
            price_in = block.find('.price_in');
            if (price_in.length) {
                price_in.val(option.attr('data-price-in'));
            }
            price_out = block.find('.price_out');
            if (price_out.length) {
                price_out.val(option.attr('data-price-out'));
            }
        });
    },
    deleteContent: function () {
        const self = this;
        self.block().on('click', '[data-js-document-content-value-id]', function (evt) {
            const element = $(this);
            let block = element.closest('.js-catalog-document-content');
            if (!block.length) {
                return;
            }
            let id = element.attr('data-js-document-content-value-id');
            let model = element.attr('data-js-document-content-value-model');
            if (id && model) {
                self.confirm({id, model, 'action': '/admin/catalog/ajax/delete-document-content'}, block);
            } else {
                block.remove();
            }
        });
    },
    delete: function () {
        const self = this;
        self.block().on('click', '[data-js-document-table-id]', function (evt) {
            evt.preventDefault();
            const element = $(this);
            let block = element.closest('tr');
            if (!block.length) {
                return;
            }
            let id = element.attr('data-js-document-table-id');
            let model = element.attr('data-js-document-table-model');
            if (id && model) {
                self.confirm({id, model, 'action': '/admin/catalog/ajax/delete-document'}, block);
            } else {
                block.remove();
            }
        });
    },
    confirm: function (obj, block) {
        const self = this;
        const request = new _glob.request(obj);
        Swal.fire({
            icon: 'warning',
            title: 'Вы уверены что хотите удалить виджет?',
            text: 'Изменения нельзя будет отменить',
            showDenyButton: true,
            confirmButtonText: 'Удалить',
            denyButtonText: 'Отменить',
        }).then((result) => {
            if (result.isConfirmed) {
                request.send((response) => {
                    if (response.status) {
                        _glob.noty.success('Все изменения сохранены');
                        block.remove();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Позиция не удалена', '', 'info');
            }
        })
    },
    posting: function () {
        const self = this;
        self.block().on('click', '.js-catalog-document-posting', function (evt) {
            Swal.fire({
                icon: 'warning',
                title: 'Вы уверены что хотите провести документ?',
                text: 'Изменения нельзя будет отменить!',
                showDenyButton: true,
                confirmButtonText: 'Провести',
                denyButtonText: 'Отменить',
            }).then((result) => {
                if (result.isConfirmed) {
                    const element = $(this);
                    let form = element.closest('#global-form');
                    const request = new _glob.request(form).setPreloader('.js-product').setAction('/admin/catalog/ajax/posting-document');
                    request.send((response) => {
                        if (response.status) {
                            _glob.images = {};
                            let block = $('.a-shop-block');
                            let html = $(response.data.view);
                            block.html(html);
                            _glob.select2();
                            _config.fancybox();
                            _config.sort();
                            _config.summernote500();
                            _config.summernote();
                            _config.flatpickr();
                            Swal.fire('Сохранено', '', 'success');
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Отменено', '', 'info');
                }
            });
        });
    },
    productView: function (target) {
        const self = this;
        const request = new _glob.request().setPreloader('.modal-body');
        self.block().on('click', '.js-catalog-document-product-all', function (evt) {
            const element = $(this);
            const block = $(target);
            block.find('.modal-body').html('');
            if (!block.length) {
                return;
            }
            request.setObject({action: '/admin/catalog/ajax/load-product'}).send((response) => {
                if (response.status) {
                    block.modal('show');
                    block.find('.modal-body').hide().html(request.view).slideDown();
                    _glob.run();
                }
            });
        });
    },
    productSelect: function (target) {
        const self = this;
        self.block().on('change', target + ' [data-js-product-id-checkbox]', function (evt) {
            const element = $(this);
            const button = $('.js-product-down');
            const id = element.attr('data-js-product-id-checkbox');
            if (element.is(':checked')) {
                self._items[id] = id;
            } else {
                delete self._items[id];
            }
            if (Object.keys(self._items).length) {
                button.removeClass('btn-outline-primary').addClass('btn-primary').addClass('button-shake');
            } else {
                button.removeClass('btn-primary').removeClass('button-shake').addClass('btn-outline-primary');
            }
        });
    },
    productLoad: function (target) {
        const self = this;
        const request = new _glob.request().setPreloader('.modal-body');
        self.block().on('click', target + ' .js-product-down', function (evt) {
            const button = $(this);
            request.setObject({
                items: self._items,
                action: '/admin/catalog/ajax/load-product-content'
            }).send((response) => {
                if (response.status) {
                    $(target).find('.modal-body').html('');
                    $(target).modal('hide');
                    $('.js-catalog-document-content-inner').append(request.view);
                    _glob.run();
                    self._items = {};
                }
            });
        });
    },
    target: function (target) {
        const self = this;
        const request = new _glob.request().setPreloader('.modal-body');
        const selector = `[data-target="${target}"]`;
        self.block().on('click', selector, function (evt) {
            const element = $(this);
            const action = element.attr('data-action');
            const type = element.attr('data-target-type');
            const block = $(target);
            block.find('.modal-body').html('');
            if (!action || !block.length) {
                return;
            }
            request.setObject({type, action}).send((response) => {
                if (response.status) {
                    block.find('.modal-body').hide().html(request.view).slideDown();
                    _glob.run();
                }
            });
        });
    },
    targetLoad: function (target) {
        const self = this;
        const request = new _glob.request().setPreloader('.modal-body');
        const selector = target + ' .js-document-down';
        self.block().on('click', selector, function (evt) {
            const element = $(this);
            const id = element.attr('data-js-id');
            request.setObject({
                action: '/admin/catalog/ajax/load-document',
                id
            }).send((response) => {
                if (response.status) {
                    $(target).modal('hide');
                    $(target).find('.modal-body').html('');
                    const sel = `[data-target="${target}"]`;
                    const block = $(sel).closest('.js-document-target-block');
                    block.find('h6').html(request.data.target);
                    block.find('input').val(id);
                    $('.js-catalog-document-content-inner').html(request.view);
                    _glob.run();
                }
            });
        });
    },
    targetRemove: function () {
        const self = this;
        self.block().on('click', '.js-document-target-remove', function (evt) {
            const element = $(this);
            const block = element.closest('.js-document-target-block');
            block.find('h6').html('');
            block.find('input').val('');
        });
    },
    innerPagination: function (target) {
        const self = this;
        const request = new _glob.request().setPreloader(target + ' .modal-body');
        const selector = target + ' a.page-link';
        self.block().on('click', selector, function (evt) {
            evt.preventDefault();
            const element = $(this);
            const action = element.attr('href');
            const block = $(target);
            block.find('.modal-body').hide().html('');
            if (!action || !block.length) {
                return;
            }
            request.setObject({action}).send((response) => {
                if (response.status) {
                    block.find('.modal-body').hide().html(request.view).slideDown();
                    _glob.run();
                }
            });
        });
    },
    invoiceFastCreate: function (target) {
        const self = this;
        const request = new _glob.request().setPreloader(target + ' .modal-body', 50);
        const selector = target + ' button.btn-primary';
        self.block().on('click', selector, function (evt) {
            evt.preventDefault();
            request.setObject($(this).closest('form')).send((response) => {
                if (response.status && response.message) {
                    _glob.noty.success(response.message);
                    $(target).modal('hide');
                }
            });
        });
    },
    run: function (selector) {
        if (this.isActive(selector)) {
            this.changeContent('.js-document-get-product');
            this.posting();
            this.delete();
            this.addContent();
            this.deleteContent();
            this.target('#xl-modal-document');
            this.targetLoad('#xl-modal-document');
            this.innerPagination('#xl-modal-document');
            this.targetRemove();
            this.productView('#xl-modal-document');
            this.productSelect('#xl-modal-document');
            this.productLoad('#xl-modal-document');
            if (_glob.pathArray[_glob.pathArray.length - 1] === 'fin-invoice') {
                this.invoiceFastCreate('#lgModal');
            }
        }
    },
}
/********** #start _coupon **********/
const _coupon = {
    checkboxes: function () {
        const wrapper = $('.js-coupon');
        if (wrapper.length) {
            const bulkMail = document.querySelector('#bulk-mail');
            const checkboxes = '.coupon-item-block input[type="checkbox"]';

            function checkAll() {
                $.each(wrapper.find(checkboxes + ':not(:checked)'), function (i, value) {
                    $(this).click();
                });
            }

            function uncheckAll() {
                $.each(wrapper.find(checkboxes + ':checked'), function (i, value) {
                    $(this).click();
                });
            }

            function toggleBulk() {
                const checked = wrapper.find(checkboxes + ':checked').length;
                checked ? bulkMail.removeAttribute('hidden') : bulkMail.setAttribute('hidden', true);
            }

            wrapper.on('click', '[data-check="all-toggle"]', function (e) {
                let check = $(this);
                if (check.prop('checked')) {
                    checkAll();
                } else {
                    uncheckAll();
                }
            });
            wrapper.on('click', checkboxes, function (e) {
                let check = $(this);
                toggleBulk();
            });
        }
    },
    getChecked: function () {
        const wrapper = $('.js-coupon');
        const checkboxes = '.coupon-item-block input[type="checkbox"]';
        let array = [];
        $.each(wrapper.find(checkboxes + ':checked'), function (i, value) {
            array.push($(this).attr('data-js-coupon-id'));
        });
        return array;
    },
    add: function () {
        let selector = $('.js-add-coupon');
        if (selector.length) {
            const request = new _glob.request().setPreloader('.js-coupon');
            $('.a-shop').on('click', '.js-add-coupon', function (evt) {
                evt.preventDefault;
                let form = $(this).closest('form'), view;
                request.setObject(form).send((response) => {
                    if ((view = request.view)) {
                        $('.js-coupon-item-block').prepend(view);
                    }
                });
            });
        }
    },
    delete: function () {
        const self = this;
        let selector = $('.js-coupon-delete');
        if (selector.length) {
            const request = new _glob.request().setPreloader('.js-coupon');
            $('.a-shop').on('click', '.js-coupon-delete', function (evt) {
                evt.preventDefault;
                let form = {
                    action: '/admin/catalog/ajax/delete-coupon',
                    ids: self.getChecked(),
                };
                request.setObject(form).send((response) => {
                    if (response && 'status' in response && response.status) {
                        if (request.data && 'ids' in request.data) {
                            $.each(request.data.ids, function (i, value) {
                                let selector = `[data-js-coupon-id="${value}"]`;
                                let block = $(selector).closest('.coupon-item');
                                block.length ? block.remove() : null;
                            });
                        }
                    }
                });
            });
        }
    },
    gift: function () {
        const self = this;
        let selector = $('.js-coupon-issued');
        if (selector.length) {
            const request = new _glob.request().setPreloader('.js-coupon');
            $('.a-shop').on('click', '.js-coupon-issued', function (evt) {
                evt.preventDefault;
                let form = {
                    action: '/admin/catalog/ajax/gift-coupon',
                    ids: self.getChecked(),
                };
                request.setObject(form).send((response) => {
                    if (response && 'status' in response && response.status) {
                        $.each(form.ids, function (i, value) {
                            let selector = `[data-js-coupon-id="${value}"]`;
                            let block = $(selector).closest('.coupon-item').find('.coupon-item-block-status span');
                            if (block.length) {
                                block.text('Выдан');
                                block.addClass('gift');
                            }
                        });
                    }
                });
            });
        }
    },
    run: function () {
        if ($('.js-coupon').length) {
            this.checkboxes();
            this.add();
            this.delete();
            this.gift();
        }
    }
}
/********** #start _user **********/
const _user = {
    save: function () {
        const request = new _glob.request();
        $('.a-shop').on('click', '.js-user-save-button', function (evt) {
            evt.preventDefault;
            let form = $(this).closest('form'), view;
            request.setObject(form).send((response) => {
                let block = $('.a-shop-block');
                let html = $(response.data.view);
                block.html(html);
                _glob.select2();
                _config.run();
                Swal.fire('Сохранено', '', 'success');
            });
        });
    },
    run: function () {
        this.save();
    }
}
/********** #start _user **********/
const _storage = {
    _products: {},
    change: function () {
        const request = new _glob.request();
        const self = this;
        $('.a-shop').on('click', '.js-storage-update-price-out', function (evt) {
            evt.preventDefault;
            const input = $(this);
            const action = input.attr('data-storage-update-price-out-href');
            if (Object.keys(self._products).length) {
                self._products['action'] = action;
                request.setObject(self._products).send((response) => {
                    self._products = {};
                    Swal.fire('Сохранено', '', 'success');
                });
            }
        });
    },
    save: function () {
        const self = this;
        $('.a-shop').on('change', '[name="product[price_out]"]', function (evt) {
            evt.preventDefault;
            const input = $(this);
            const val = input.val();
            const id = input.attr('data-product-id');
            if (!(id in self._products)) {
                self._products[id] = {}
            }
            self._products[id]['new'] = val;
            if (self._products[id]['new'] === self._products[id]['old']) {
                delete self._products[id];
            }
        });
        $('.a-shop').on('focus', '[name="product[price_out]"]', function (evt) {
            evt.preventDefault;
            const input = $(this);
            const val = input.val();
            const id = input.attr('data-product-id');
            const catalogStoragePlaceId = input.attr('data-storage-place-id');
            if (!(id in self._products)) {
                self._products[id] = {}
            }
            if (!('old' in self._products[id])) {
                self._products[id]['old'] = val;
            }
            self._products[id]['storage'] = catalogStoragePlaceId;
        });
    },
    run: function () {
        this.change();
        this.save();
    }
}
/********** #start _config **********/
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
        try {
            Fancybox.bind('[data-fancybox]', {});
        } catch (e) {
            _glob.console.error(e.message);
        }
    },
    dateRangePicker: function () {
        try {
            flatpickr('.date-range-picker', {
                mode: 'range',
                'locale': 'ru',
                dateFormat: 'd.m.Y',
            });
        } catch (e) {
            _glob.console.error(e.message);
        }
        try {
            flatpickr('.datepicker-wrap', {
                allowInput: true,
                clickOpens: false,
                wrap: true,
                'locale': 'ru',
                dateFormat: 'd.m.Y',
            })
        } catch (e) {
            _glob.console.error(e.message);
        }
    },
    documentSearchProduct: function (selector = null) {
        if (selector) {
            const csrf = $('meta[name="csrf-token"]').attr('content');
            $(selector).select2({
                ajax: {
                    url: '/admin/catalog/ajax/get-product',
                    dataType: 'json',
                    method: 'post',
                    headers: {'X-CSRF-TOKEN': csrf},
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                },
                placeholder: 'Продукт',
                minimumInputLength: 3,
                language: 'ru',
                templateSelection: function (data, container) {
                    $(data.element).attr('data-in-stock', data.in_stock);
                    $(data.element).attr('data-in-reserve', data.in_reserve);
                    $(data.element).attr('data-reserve-expired-at', data.reserve_expired_at);
                    $(data.element).attr('data-price-in', data.price_in);
                    $(data.element).attr('data-price-out', data.price_out);
                    return data.text;
                }
            });
        }
    },
    summernote500: function () {
        const summernote500 = $('.summernote-500');
        if (summernote500.length) {
            summernote500.summernote({
                height: 500
            });
        }
    },
    summernote: function () {
        const summernote = $('.summernote');
        if (summernote.length) {
            summernote.summernote({
                height: 150
            });
        }
    },
    flatpickr: function () {
        const selector = '.datetimepicker-inline';
        if ($(selector).length) {
            flatpickr(selector, {
                enableTime: true,
                inline: true
            });
        }
    },
    run: function () {
        if ($('.a-shop .a-product').length) {
            this.sort();
        }
        this.fancybox();
        this.dateRangePicker();
        this.summernote500();
        this.summernote();
        this.flatpickr();
        const modal = $('#document-catalog-modal');
        if (modal.length) {
            modal.on('hidden.bs.modal', function (e) {
                let button = $('.js-document-catalog-modal-credit-spare-part-add');
                let span = button.find('span');
                span.html('');
                button.hide();
            });
        }
        if ($('.js-document-get-product').length) {
            this.documentSearchProduct('.js-document-get-product');
        }
    }
}
$(document).ready(function () {
    _glob.run();
    _config.run();
    _user.run();
    _image.run();
    _product.run('.a-shop-block');
    _property.run('.a-shop-block');
    _coupon.run();
    _document.run('.a-shop-block');
    _form.run('.a-shop-block');
    _storage.run('.a-shop-block');
    /***** TODO remake this porno *****/
    sendForm();
    catalogProductShowCurrency();
})
