/********** #start product **********/
const _product = {
    _block: {},
    imageClick: function (imageNumber) {
        setTimeout(() => {
            const sliderElement = document.getElementById('pgalleryModal');
            swiffyslider.slideTo(sliderElement, imageNumber);
            swiffyslider.onSlideEnd(sliderElement, () => sliderElement.querySelector(".slider-container").focus());
        }, 300);
    },
    thumbHover: function (imageNumber) {
        const sliderElement = document.getElementById('pgallery');
        swiffyslider.slideTo(sliderElement, imageNumber);
    },
    run: function (block) {
        const self = this;
        self._block = $(block);
        if (self._block.length) {
            self._block.on('click', '[data-image-click]', function (evt) {
                evt.preventDefault();
                const button = $(this).attr('data-image-click');
                self.imageClick(button);
            });
            self._block.on('mouseover', '[data-thumb-hover]', function (evt) {
                evt.preventDefault();
                const button = $(this).attr('data-thumb-hover');
                self.thumbHover(button);
            });
        }
    }
}
/********** #start basket **********/
const _basket = {
    _block: {},
    draw: function (data) {
        const self = this;
        let mini = '';
        let quantity = 0;
        if (Object.keys(data).length) {
            quantity = data.quantity;
            let sum = data.sum ? data.sum : 0.0;
            let items = data.items;
            if (Object.keys(items).length) {
                mini += `<div class="toolbar-dropdown cart-dropdown js-widget-cart">`;
                for (let key in items) {
                    mini += `<div class="entry">
                            <div class="entry-thumb">
                                <a href="/catalog/${items[key]['alias']}">
                                    <img src="${items[key]['image']}" alt="${items[key]['title']}">
                                </a>
                            </div>
                            <div class="entry-content">
                                <h4 class="entry-title">
                                    <a href="/catalog/${items[key]['alias']}">${items[key]['title']}</a>
                                </h4>
                                <span class="entry-meta">${items[key]['quantity']} x ${items[key]['price']} ₽</span>
                            </div>`;
                    if (!items[key]['is_single']) {
                        mini += `<div class="basket-change js-basket-change">
                                <i class="fa fa-fw fa-caret-square-left"
                                data-js-basket-action="delete"
                                data-js-basket-id-change="${key}"></i>
                                <i class="fa fa-fw fa-caret-square-right"
                                data-js-basket-action="add"
                                data-js-basket-id-change="${key}"></i>
                            </div>`;
                    }
                    mini += `<a href="javascript:void(0)" class="entry-delete" data-js-catalog-product-id-delete="${key}"><i class="fa fa-fw fa-trash-restore-alt"></i></a>`;
                    mini += `</div>`;
                }
                mini += `<div class="text-right">
                        <p class="text-gray-dark py-2 mb-0"><span class="text-muted">Итого:</span> &nbsp;${sum} ₽</p>
                    </div>`;
                mini += `<div class="d-flex">
                        <div class="pr-2 w-50"><a class="btn btn-outline-secondary btn-sm btn-block mb-0 js-basket-clear" href="javascript:void(0)">Очистить</a></div>
                        <div class="pl-2 w-50"><a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/user/order">Оформить</a></div>
                    </div>`;
                mini += `</div>`;
                $('.js-basket-max-sum').text(sum)
            }
        }
        if (mini) {
            let block = $('.js-block-mini-basket');
            block.find('.js-widget-cart').remove();
            block.append(mini);
            block.find('.header__cart-link').attr('href', '/user/order');
            $('[data-cart-count-bubble]').html(`<span data-cart-count="">${quantity}</span>`).show();
        } else {
            self.clearBlock();
        }
    },
    add: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '[data-js-catalog-product-id]', function (evt) {
            const button = $(this);
            const quantity = button.closest('.product-info-block').find('[name="quantity"]').val();
            if (!quantity) {
                _glob.noty.error('Не известно количество');
                return;
            }
            let max = button.attr('data-js-basket-max');
            let id = button.attr('data-js-catalog-product-id');
            const object = {
                'catalog_product_id': id,
                quantity,
                'action': '/catalog/ajax/basket-add',
            }
            request.setObject(object).send((response) => {
                if (response.status) {
                    _glob.noty.success('Корзина сохранена');
                    self.draw(response.data);
                    if (max) {
                        button.closest('tr').remove();
                    }
                }
            })
        });
    },
    changeMiniBlock: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '[data-js-basket-id-change]', function (evt) {
            const input = $(this);
            const action = input.attr('data-js-basket-action');
            const id = input.attr('data-js-basket-id-change');
            if (!action || !id) {
                _glob.noty.error('Не известно действие');
                return;
            }
            const object = {
                'catalog_product_id': id,
                quantity: 1,
                'action': '/catalog/ajax/basket-' + action,
            }
            request.setObject(object).send((response) => {
                if (response.status) {
                    _glob.noty.success('Корзина сохранена');
                    self.draw(response.data);
                }
            })
        });
    },
    change: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('change', '.js-basket-form [name="quantity"]', function (evt) {
            const input = $(this);
            const basket = input.closest('.js-basket-max-block');
            const product = input.closest('.js-basket-form');
            const quantity = input.val();
            if (!quantity) {
                _glob.noty.error('Не известно количество');
                return;
            }
            let max = product.attr('data-js-basket-max');
            let id = product.attr('data-js-catalog-product');

            const object = {
                'catalog_product_id': id,
                quantity,
                'action': '/catalog/ajax/basket-change',
            }
            request.setObject(object).send((response) => {
                if (response.status) {
                    _glob.noty.success('Корзина сохранена');
                    const data = request.getData();
                    const sum = data['sum'] !== undefined ? data['sum'] : 0.0;
                    if (max && data && (data['items']?.[id] !== undefined)) {
                        const div = `<td>
                                            <div class="product-item">
                                                <a class="product-thumb" href="/catalog/${data['items'][id]['alias']}">
                                                    <img src="${data['items'][id]['image']}" alt="Product">
                                                </a>
                                                <div class="product-info">
                                                    <h4 class="product-title">
                                                        <a href="/catalog/${data['items'][id]['alias']}">${data['items'][id]['title']}</a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="text-center">
                                        <div class="count-input">
                                            <input type="number" class="form-control quantity-product" name="quantity" value="${data['items'][id]['quantity']}">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="count-input">
                                            ${data['items'][id]['real_quantity']} шт.
                                        </div>
                                    </td>
                                    <td class="text-center text-lg">${data['items'][id]['price']} ₽</td>
                                    <td class="text-center text-lg">-</td>
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-js-basket-max="true"
                                                data-js-catalog-product-id-delete="${id}">
                                            Удалить
                                        </button>
                                    </td>`;
                        product.html(div);
                        basket.find('.js-basket-max-sum').text(sum);
                    }
                    if (max && data['items']?.[id] === undefined) {
                        product.remove();
                        basket.find('.js-basket-max-sum').text(sum);
                    }
                }
            })
        });
    },
    delete: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '[data-js-catalog-product-id-delete]', function (evt) {
            const button = $(this);
            let max = button.attr('data-js-basket-max');
            let id = button.attr('data-js-catalog-product-id-delete');
            const object = {
                catalog_product_id: id,
                action: '/catalog/ajax/basket-delete',
            }
            request.setObject(object).send((response) => {
                if (response.status) {
                    _glob.noty.success('Корзина сохранена');
                    self.draw(response.data);
                    if (max) {
                        button.closest('tr').remove();
                    }
                }
            })
        });
    },
    clearBlock: function () {
        let block = $('.js-block-mini-basket');
        block.find('.js-widget-cart').remove();
        block.find('.header__cart-link').attr('href', 'javascript:void(0)');
        $('[data-cart-count-bubble]').html('').hide();
        let maxBlock = $('.js-basket-max-block');
        maxBlock.find('tbody').html('');
        maxBlock.find('.js-basket-max-sum').text('');
    },
    clear: function () {
        const self = this;
        const request = new _glob.request({'action': '/catalog/ajax/basket-clear'});
        self._block.on('click', '.js-basket-clear', function (evt) {
            request.send((response) => {
                if (response.status) {
                    _glob.noty.success('Корзина очищена');
                    self.clearBlock();
                }
            })
        });
    },
    run: function (block) {
        const self = this;
        self._block = $(block);
        if (self._block.length) {
            this.add();
            this.delete();
            this.change();
            this.changeMiniBlock();
            this.clear();
        }
    }
}
/********** #start user **********/
const _user = {
    _block: {},
    defaultCityCode: 435,
    defaultLocation: [45.040199, 38.976113],
    authForm: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '.js-user-submit-button', function (evt) {
            evt.preventDefault;
            let form = $(this).closest('form') ? $(this).closest('form') : 0;
            if (form) {
                request.setObject(form).send()
            }
        });
    },
    activatePhone: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '.js-user-phone-activate-button', function (evt) {
            evt.preventDefault;
            let input = $('[name="activate_phone"]');
            let phone = input.val();
            if (!phone) {
                input = $(this).closest('form').find('[name="user[phone]"]');
                phone = input.val();
            }
            if (phone) {
                request.setObject({phone: phone, action: '/user/activate-phone'}).send(async (response) => {
                    if (response.status) {
                        const {value: text} = await Swal.fire({
                            title: 'Введите полученный код',
                            input: 'text',
                            inputLabel: 'Код',
                            inputPlaceholder: 'Введите полученный код',
                            inputValidator: (value) => {
                                if (!value) {
                                    return 'Введите полученный код!'
                                }
                            },
                            inputAttributes: {
                                maxlength: 6,
                                autocapitalize: 'off',
                                autocorrect: 'off'
                            }
                        })
                        if (text) {
                            const ob = {
                                code: text,
                                action: '/user/activate-phone-code'
                            };
                            const requestNext = new _glob.request(ob);
                            requestNext.send((response) => {
                                if (response.status) {
                                    input.prop('disable', true)
                                    _glob.noty.success(response.message);
                                }
                            });
                        }
                    }
                })
            }
        });
    },
    restorePassword: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '.js-restore-password', function (evt) {
            evt.preventDefault;
            const form = $(this).closest('form');
            request.setObject(form).send(async (response) => {
                if (response.status) {
                    _glob.noty.success((response.message));
                }
            })
        });
    },
    changePassword: function () {
        const self = this;
        const request = new _glob.request();
        self._block.on('click', '.js-change-password', function (evt) {
            evt.preventDefault;
            const form = $(this).closest('form');
            request.setObject(form).send(async (response) => {
            })
        });
    },
    run: function (block) {
        const self = this;
        self._block = $(block);
        if (self._block.length) {
            this.authForm();
            this.activatePhone();
            this.restorePassword();
            this.changePassword();
        }
    }
}
/********** #start delivery **********/
const _delivery = {
    selector: '.order-page',
    _modal: {},
    _block: {},
    cdekAddress: {},
    address: {},
    map: {},
    objectManager: {},
    info: {},
    cities: {},
    citiesHasUuid: {},
    objectsList: {},
    objectsJson: {},
    tariffs: {},
    cityCode: 435,
    location: [45.040199, 38.976113],
    suggestions: function () {
        const self = this;
        const select = `<select
                                class="form-control select2-delivery-city"
                                data-allow-clear="true"
                                data-placeholder="Адрес"
                                data-select2-search="true"
                                name="">
                            <option></option>
                        </select>`;
        $('#map').append(select);
        const csrf = $('meta[name="csrf-token"]').attr('content');

    },
    initYmaps: function (center, zoom) {
        const city = {
            center: center,
            zoom: zoom,
            controls: ['zoomControl', 'typeSelector']
        };
        _delivery.map = new ymaps.Map('map', city);
    },
    initObjectManager: function (objects) {
        _delivery.objectManager = new ymaps.ObjectManager({
            clusterize: true,
            gridSize: 50,
            clusterDisableClickZoom: true,
            clusterOpenBalloonOnClick: false
        });
        _delivery.objectManager.objects.options.set('preset', 'islands#darkGreenSouvenirsCircleIcon');
        _delivery.objectManager.clusters.options.set('preset', 'islands#invertedDarkGreenClusterIcons');
        _delivery.objectManager.add(objects);
        _delivery.map.geoObjects.add(_delivery.objectManager);
        _delivery.objectManager.objects.events.add('click', function (e) {
            const id = e.get('objectId');
            _delivery.setPVZ(id);
        });
    },
    initMap: function () {
        const request = new _glob.request().setPreloader('#map', 50);
        request.setObject({'action': '/catalog/ajax/get-delivery-info'}).send((response) => {
            _delivery.cities = request.data.cities_list;
            _delivery.citiesHasUuid = request.data.cities_has_uuid;
            _delivery.objectsList = request.data.objects_list;
            _delivery.objectsJson = request.data.objects_json;
            _delivery.cityCode = request.data.city_code;
            _delivery.location = request.data.location;
            _delivery.initYmaps(_delivery.location, 10);
            _delivery.initObjectManager(_delivery.objectsJson[_delivery.cityCode]);
            _delivery.initSelect();
            _delivery.initSelectPVZ(_delivery.objectsJson[_delivery.cityCode])
            $('#map').append('<div class="delivery-info"></div>');
            if ('calculate' in request.data && Object.keys(request.data.calculate).length) {
                _delivery.tariffs = request.data.calculate;
                _delivery.showTariffs();
            }
        });
    },
    initSelect: function () {
        const self = this;
        let option = '';
        if (Object.keys(self.cities).length) {
            for (let key in self.cities) {
                option += `<option value="${key}" ${key === _delivery.cityCode ? 'selected' : ''}>${self.cities[key]}</option>`;
            }
        }
        const select = `<div class="col-md-12 mb-3"><div class="form-group"><select
                                class="form-control select2-delivery-city"
                                data-allow-clear="true"
                                data-placeholder="Выберете город доставки"
                                data-select2-search="true"
                                data-validator="delivery.city_code"
                                data-validator-required
                                name="delivery[city_code]">
                            <option></option>
                            ${option}
                        </select></div></div>`;
        $('.delivery-cdek-block').prepend(select);
        $('.select2-delivery-city').select2({
            dropdownCssClass: 'select2-option-delivery-city',
            width: '100%',
            templateResult: function (state) {
                if (!state.id) {
                    return state.text;
                }
                const arr = state.text.split('  ');
                return $(`<span>${arr[0]}</span><br><span class="region">${arr[1]}</span>`);
            },
        });
    },
    eventSelect: function () {
        const self = this;
        self._block.on('change', '.select2-delivery-city', function (evt) {
            evt.preventDefault();
            self.setMap($(this).val());
        });
    },
    setMap: function (id) {
        const self = this;
        const request = new _glob.request().setPreloader('#map', 50);
        request.setObject({'action': '/catalog/ajax/get-object', id}).send((response) => {
            const infoBlock = $('#map .delivery-info');
            infoBlock.html('');
            infoBlock.removeClass('show');
            self.tariffs = {};
            let location = self.location;
            let cityCode = self.cityCode;
            if ('coordinates' in request.data && Object.keys(request.data.coordinates).length) {
                const coordinatesArray = response.data.coordinates;
                location = [coordinatesArray.latitude, coordinatesArray.longitude];
                cityCode = coordinatesArray.code;
                self.cityCode = cityCode;
                self.location = location;
            }
            if ('calculate' in request.data && Object.keys(request.data.calculate).length) {
                self.tariffs = request.data.calculate;
                self.showTariffs();
            }
            self.map.setCenter(location, 10);
            self.objectManager.removeAll();
            self.initObjectManager(self.objectsJson[cityCode]);
            self.initSelectPVZ(self.objectsJson[cityCode]);
        });
    },
    initSelectPVZ: function (objectsJson) {
        const self = this;
        let option = '';
        const features = objectsJson.features;
        if (features && features.length) {
            for (let i = 0, length = features.length; i < length; i++) {
                const select = features[i].select;
                if (select && Object.keys(select).length) {
                    option += `<option value="${select.id}">${select.title}</option>`;
                }
            }
        }
        const select = `<div class="form-group"><select
                                class="form-control select2-delivery-pvz"
                                data-allow-clear="true"
                                data-placeholder="Выберете ПВЗ"
                                data-select2-search="true"
                                data-validator="delivery.cdek_pvz"
                                name="delivery[cdek_pvz]">
                            <option></option>
                            ${option}
                        </select></div>`;
        const pvz = $('.delivery-cdek-block-address-storage');
        pvz.html('');
        pvz.prepend(select);
        $('.select2-delivery-pvz').select2({
            width: '100%',
        });
    },
    setPVZ: function (id) {
        const self = this;
        const infoBlock = $('#map .delivery-info');
        const pvz = self.objectsList[id];
        if (Object.keys(pvz).length) {
            const addressBlock = `<div class="body-block"><span class="head">Адрес пункта выдачи заказов:</span><div>${pvz.address}</div></div>`;
            const workTime = pvz.work_time.split(',');
            let workTimeBlock = '<div class="body-block"><span class="head">Время работы:</span><ul>';
            workTime.forEach(function (currentValue, index, array) {
                workTimeBlock += `<li>${currentValue}</li>`;
            });
            workTimeBlock += '</ul></div>';
            const button = `<div class="body-block"><button type="button" class="choose" data-pvz-id="${id}">Выбрать</button></div>`;
            const noteBlock = `<div class="body-block"><span class="head">Как к нам проехать:</span><div>${pvz.note}</div></div>`;
            const phoneBlock = `<div class="body-block"><span class="head">Телефон:</span><div>${_glob.phone(pvz.phone)}</div></div>`;
            const buttonShowImage = `<div class="body-block" style="width: 100%"><button type="button" class="choose" data-pvz-images-id="${id}">Показать фото</button></div>`;
            const close = `<div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>`;
            const info = `<div class="delivery-info__head">${pvz.name}${close}</div>
                        <div class="delivery-info__body">${addressBlock}${workTimeBlock}${button}${noteBlock}${phoneBlock}${buttonShowImage}</div>`;
            infoBlock.html(info);
            infoBlock.addClass('show');
        }
    },
    closePVZ: function () {
        const self = this;
        self._block.on('click', '#map .delivery-info .close', function (evt) {
            evt.preventDefault();
            const infoBlock = $('#map .delivery-info');
            infoBlock.html('');
            infoBlock.removeClass('show');
        });
    },
    choosePVZ: function () {
        const self = this;
        self._block.on('click', '#map [data-pvz-id]', function (evt) {
            evt.preventDefault();
            const block = $(this);
            const id = block.attr('data-pvz-id');
            const adr = self.objectsList[id].city + ' ' + self.objectsList[id].address;
            $('[name="delivery[cdek_pvz]"]').val(id).trigger("change");
        });
    },
    showImages: function () {
        const self = this;
        self._block.on('click', '#map [data-pvz-images-id]', function (evt) {
            evt.preventDefault();
            const block = $(this);
            const id = block.attr('data-pvz-images-id');
            if (id) {
                const pvz = self.objectsList[id];
                if (Object.keys(pvz).length) {
                    let imagesBlock = '';
                    if (Object.keys(pvz.images).length) {
                        pvz.images.forEach(function (currentValue, index, array) {
                            imagesBlock += `<a
                                        href="${currentValue}"
                                        class="image-box"
                                        data-fancybox="gallery"
                                        style="background-image: url(${currentValue}); background-size: cover;background-position: center;"></a>`;
                        });
                    }
                    block.closest('.body-block').html(imagesBlock);
                }
            }
        });
    },
    showTariffs: function () {
        if (Object.keys(this.tariffs).length) {
            let block = '<div class="col-md-12"><div class="alert alert-primary" role="alert">';
            const storage = this.tariffs.storage;
            if (storage.length) {
                storage.forEach(function (currentValue, index, array) {
                    //const exp = currentValue.tariff_name + ' [код тарифа: ' + currentValue.tariff_code + ']';
                    const exp = currentValue.tariff_description ? 'Экспресс посылка' : 'Посылка';
                    const day = ' [ доставка ' + currentValue.period_min + '-' + currentValue.period_max + ' дней ]';
                    const title = `${exp} : ${_glob.price(currentValue.delivery_sum)}${day}`;
                    block += `<div class="custom-control custom-radio">
                                    <input
                                    data-delivery="storage"
                                    type="radio"
                                    id="storage-${index}"
                                    name="delivery[cdek_tariff]"
                                    value="${currentValue.tariff_code}"
                                    class="custom-control-input js-delivery-storage" checked>
                                    <label class="custom-control-label" for="storage-${index}">${title}</label>
                                </div>`;
                })
            }
            const courier = this.tariffs.courier;
            if (courier.length) {
                courier.forEach(function (currentValue, index, array) {
                    // const exp1 = 'Курьер ' + currentValue.tariff_name + ' [код тарифа: ' + currentValue.tariff_code + ']';
                    const exp1 = currentValue.tariff_description ? 'Экспресс курьер' : 'Курьер';
                    const day1 = ' [ доставка ' + currentValue.period_min + '-' + currentValue.period_max + ' дней ]';
                    const title1 = `${exp1} : ${_glob.price(currentValue.delivery_sum)}${day1}`;
                    block += `<div class="custom-control custom-radio">
                                    <input
                                    data-delivery="courier"
                                    type="radio"
                                    id="courier-${index}"
                                    name="delivery[cdek_tariff]"
                                    value="${currentValue.tariff_code}"
                                    class="custom-control-input js-delivery-courier">
                                    <label class="custom-control-label" for="courier-${index}">${title1}</label>
                                </div>`;
                })
            }
            block += '</div></div>';
            $('.delivery-cdek-block-address').html(block);
            this.changeBlockAddress('storage');
            this.changeTariffs();
        }
    },
    changeTariffs: function () {
        const self = this;
        self._block.on('click', 'input[name="delivery[cdek_tariff]"]', function (e) {
            self.changeBlockAddress($(this).attr('data-delivery'));
        });
    },
    changeBlockAddress: function (type) {
        const start = 'delivery-cdek-block-address-';
        const selector = '.' + start + type;
        const target = $(selector);
        $('[class^=' + start + ']').not(target).hide(0);
        target.fadeIn(500);
    },
    initSelectCourier: function () {
        const self = this, selector = $('.select2-delivery-courier');
        const csrf = $('meta[name="csrf-token"]').attr('content');
        selector.select2({
            dropdownCssClass: 'select2-option-delivery-courier',
            ajax: {
                url: '/catalog/ajax/get-address-courier',
                dataType: 'json',
                method: 'post',
                headers: {'X-CSRF-TOKEN': csrf},
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                },
            },
            templateSelection: function (data, container) {
                $(data.element).attr('data-location', data.location);
                return data.text;
            },
            placeholder: 'Адрес для доставки курьером',
            minimumInputLength: 3,
            language: 'ru',
            width: '100%',
        });
        selector.on('select2:opening', function (event) {
            setTimeout(function () {
                $('.select2-option-delivery-courier').find('.select2-search__field').val(selector.val());
            }, 1);
        });
        selector.on('select2:select', function (event) {
            const option = $(this).find(':selected');
            const location = option.attr('data-location');
            setTimeout(function () {
                $('.select2-option-delivery-courier').find('.select2-search__field').val(selector.val());
                if (location) {
                    const loc = location.split(',');
                    const l1 = Number.parseFloat(loc[0]);
                    const l2 = Number.parseFloat(loc[1]);
                    if (l1 && l2) {
                        _delivery.map.geoObjects.add(new ymaps.Placemark([l1, l2], {
                            iconCaption: 'Адрес для вызова курьера'
                        }, {
                            preset: 'islands#circleIcon',
                            iconColor: '#fc0'
                        }));
                        _delivery.map.setCenter([l1, l2], 15);
                    }
                }
            }, 1);
        });
    },
    changeDelivery: function () {
        const self = this;
        self._block.on('change', '[name="order[catalog_delivery_type_id]"]', function (evt) {
            evt.preventDefault();
            const id = Number.parseInt($(this).val());
            if (id === 1) {
                self.address.removeClass('show');
                self.cdekAddress.addClass('show');
                self.modal().modal('show');
            } else {
                self.address.addClass('show');
                self.cdekAddress.removeClass('show');
            }
        });
    },
    cdek: function () {
        const self = this;
        const ourWidjet = new ISDEKWidjet({
            showWarns: false,
            showErrors: false,
            showLogs: false,
            hideMessages: true,
            defaultCity: 'Краснодар',
            cityFrom: 'Краснодар',
            country: 'Россия',
            link: 'delivery-map',
            path: '/frontend/cdek/scripts/', //директория с библиотеками
            servicepath: '/service.php',
            hidedelt: true,
            hidedress: true,
            onChoose: function (event) {
                _cl_(event);
                self.setAddress(event);
                self.modal().modal('hide');
            },
            onChooseProfile: function (event) {
                _cl_(333)
            },
        });
    },
    setAddress: function (data) {
        const address = data.cityName + ' ' + data.PVZ.Address;
        this.cdekAddress.find('[name="delivery[address]"]').val(address);
    },
    isActive: function (selector) {
        const self = this;
        self._block = $(selector);
        if (self._block.length) {
            return true;
        }
    },
    modal: function () {
        this._modal = $('#xl-modal-document');
        return this._modal;
    },
    run: function () {
        if (this.isActive(this.selector)) {
            this.changeDelivery();
            this.cdekAddress = $('.delivery-cdek-block');
            this.address = $('.delivery-address-block');
            ymaps.ready(this.initMap);
            this.eventSelect();
            this.closePVZ();
            this.choosePVZ();
            this.showImages();
            this.initSelectCourier();
        }
    }
}
/********** #start order **********/
const _order = {
    _block: {},
    save: function () {
        const self = this;
        const request = new _glob.request().setPreloader('.order-page', 50);
        $('.a-shop').on('click', '.js-order-save', function (evt) {
            evt.preventDefault;
            let form = $(this).closest('form');
            request.setObject(form).send((response) => {
            });
        });
    },
    pay: function () {
        const self = this;
        const request = new _glob.request().setPreloader('.order-confirm', 50);
        $('.a-shop').on('click', '.js-order-pay', function (evt) {
            evt.preventDefault;
            let form = $(this).closest('form');
            request.setObject({'action': '/catalog/ajax/order-pay'}).send((response) => {
            });
        });
    },
    arrow: function () {
        const self = this;
        $('.a-shop').on('click', '[data-js-tab-order]', function (evt) {
            evt.preventDefault();
            let element = $(this);
            let form = element.closest('form');
            let link = form.find('a.nav-link.active');
            let href = link.attr('href');
            let arr = href.split('-');
            let num = parseInt(arr[arr.length - 1]);
            let action = element.attr('data-js-tab-order');
            let selector;
            if (action === 'prev') {
                switch (num) {
                    case 2:
                    case 3:
                        selector = `.nav-pills a[href="#order-tab-${num - 1}"]`;
                        break;
                    default:
                        return false;
                }
            } else {
                switch (num) {
                    case 1:
                    case 2:
                        selector = `.nav-pills a[href="#order-tab-${num + 1}"]`;
                        break;
                    default:
                        return false;
                }
            }
            $(selector).tab('show');
        });
    },
    tabs: function () {
        const self = this;
        $('.a-shop .order-page').on('shown.bs.tab', function (evt) {
            let target = $(evt.target).attr('href');
            let arr = target.split('-');
            let num = parseInt(arr[arr.length - 1]);
            let prev = $('[data-js-tab-order="prev"]');
            let next = $('[data-js-tab-order="next"]');
            switch (num) {
                case 1:
                case 2:
                    next.text('Вперед').removeClass('js-order-save');
                    break;
                case 3:
                    next.text('Оформить').addClass('js-order-save');
                    break;
                default:
                    return false;
            }
        });
    },
    run: function () {
        if ($('.order-page').length) {
            this.arrow();
            this.tabs();
            this.save();
        }
        if ($('.order-confirm').length) {
            this.pay();
        }
    }
}
/********** #start admin **********/
const _admin = {
    _block: {},
    productWriteOff: function () {
        const self = this;
        const request = new _glob.request();
        $('.a-shop').on('click', '[data-js-catalog-product-id-write-off]', function (evt) {
            evt.preventDefault();
            const button = $(this);
            const quantity = button.closest('.product-info-block').find('[name="quantity"]').val();
            if (!quantity) {
                _glob.noty.error('Не известно количество');
                return;
            }
            const id = button.attr('data-js-catalog-product-id-write-off');
            const object = {
                'catalog_product_id': id,
                quantity,
                'action': '/admin/catalog/ajax/create-write-off-from-front',
            }
            request.setObject(object).send((response) => {
                if (response.status && response.message) {
                    _glob.noty.success(response.message);
                }
            });
        });
    },
    run: function () {
        this.productWriteOff();
    }
}
/********** #start comment **********/
const _comment = {
    _block: {},
    add: function () {
        const self = this;
        const request = new _glob.request();
        $('.a-shop').on('click', '.js-comment-button', function (evt) {
            evt.preventDefault();
            const button = $(this);
            const form = button.closest('form');
            const id = form.find('[name="comment_id"]').val();
            request.setObject(form).send((response) => {
                if (response.status && response.message) {
                    if (id && request.view) {
                        const selector = '#comment-' + id;
                        $(selector).append(request.view);
                    } else if (request.view) {
                        $('.comment-block-widget').append(request.view);
                    }
                    _glob.noty.success(response.message);
                    form.find('[name="comment_id"]').val('');
                    form.find('.js-answer-name').slideUp();
                }
            });
        });
    },
    answer: function () {
        const self = this;
        $('.a-shop').on('click', '[data-review-id]', function (evt) {
            evt.preventDefault();
            const id = $(this).attr('data-review-id');
            const selector = '#review-name-' + id;
            const nameTemp = $(this).closest('.comment').find(selector).text();
            const name = nameTemp ? nameTemp : 'Undefined';
            const form = $('#contact-form-leave-comments');
            form.find('[name="comment_id"]').val(id);
            form.find('[name="comment_name"]').val(name);
            form.find('.js-answer-name').slideDown();
            $('html, body').animate({
                scrollTop: form.offset().top
            });
        });
    },
    deleteAnswer: function () {
        const self = this;
        $('.a-shop').on('click', '.js-answer-delete', function (evt) {
            evt.preventDefault();
            const form = $('#contact-form-leave-comments');
            form.find('[name="comment_id"]').val('');
            form.find('[name="comment_name"]').val('');
            form.find('.js-answer-name').slideUp();
        });
    },
    open: function () {
        const self = this;
        const request = new _glob.request();
        $('.a-shop').on('click', '[data-open-id]', function (evt) {
            evt.preventDefault();
            const button = $(this);
            const id = button.attr('data-open-id');
            const data = {
                'id': id,
                'action': '/ajax/open-comment',
            };
            request.setObject(data).send((response) => {
                if (response.status) {
                    if (request.view) {
                        const selector = '#comment-' + id;
                        $(selector).append(request.view);
                        button.remove();
                    }
                    _glob.noty.success(response.message);
                }
            });
        });
    },
    run: function () {
        this.add();
        this.answer();
        this.deleteAnswer();
        this.open();
    }
}
/********** #start load **********/
$(document).ready(function () {
    _glob.run();
    _basket.run('.a-shop');
    _user.run('.a-shop');
    _order.run();
    _admin.run();
    _comment.run();
    setTimeout(function () {
        _delivery.run();
    }, 500);
})
