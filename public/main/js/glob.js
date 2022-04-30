const _glob = {
    ERROR_MESSAGE: 'Произошла ошибка, попробуйте позднее!',
    ERROR_FIELD: 'Поле обязательное для заполнения',
    spareParts: [],
    images: {},
    propertyTypes: {
        value_int: 'number',
        value_varchar: 'text',
        value_decimal: 'number',
        value_text: 'text',
    },
    noty: {
        error: function (message = 'Произошла ошибка!') {
            new Noty({
                type: 'error', text: '<h5>Внимание</h5>' + message, timeout: 4000, theme: 'relax'
            }).show()
        },
        success: function (message = 'Все прошло успешно!') {
            new Noty({
                type: 'success', text: '<h5>Внимание</h5>' + message, timeout: 4000, theme: 'relax'
            }).show()
        },
        info: function (message = 'Обратите внимание!') {
            new Noty({
                type: 'info', text: '<h5>Внимание</h5>' + message, timeout: 4000, theme: 'relax'
            }).show()
        }
    },
    send: {
        object: function (obj, url, callback) {
            let self = this;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                data: obj,
                beforeSend: function () {
                },
                success: function (response) {
                    callback(response);
                    self.defaultBehavior(response);
                },
                error: function (response) {
                    self.errorResponse(response);
                },
                complete: function () {
                }
            });
        },
        form: function (form, callback) {
            let self = this;
            let path = form.attr('action')
            let data = new FormData(form[0]);
            if (Object.keys(_glob.images).length) {
                for (let key in _glob.images) {
                    let images = _glob.images[key]['images'];
                    if (Object.keys(images).length) {
                        for (let key2 in images) {
                            data.append('galleries[' + key + '][images][' + key2 + '][file]', images[key2]['file']);
                        }
                    }
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
                    callback(response);
                    self.defaultBehavior(response);
                },
                error: function (response) {
                    self.errorResponse(response);
                },
                complete: function () {
                }
            });
        },
        defaultBehavior: function (response) {
            let self = this;
            let data, url, redirect;
            if (response && (data = response.data)) {
                if ((url = data.url)) {
                    self.setLocation(url);
                }
                if ((redirect = data.redirect)) {
                    window.location.href = redirect;
                }
            }
        },
        errorResponse: function (response, form = null) {
            let json;
            if (response && (json = response.responseJSON)) {
                let message = json.message;
                if (json.status_code === 400) {
                    let error = json.error;
                    if (error && Object.keys(error).length) {
                        for (let key in error) {
                            let selector = `[data-validator="${key}"]`;
                            if (form) {
                                $(form).find(selector).addClass('is-invalid');
                            } else {
                                $(selector).addClass('is-invalid');
                            }
                        }
                    }
                }
                _glob.noty.error(message ? message : _glob.ERROR_MESSAGE);
            }
        },
        setLocation: function (curLoc) {
            try {
                history.pushState(null, null, curLoc);
                return;
            } catch (e) {
            }
            location.hash = '#' + curLoc;
        },
    },
    validation: {
        control: function () {
            let self = this;
            $('body').on('blur', '[data-validator-required]', function (evt) {
                let field = $(this);
                self.change(field);
            })
        },
        change: function (field) {
            let err = false;
            let help = field.closest('div').find('.invalid-feedback');
            if (field.attr('type') === 'checkbox') {
                if (field.prop('checked')) {
                    field.removeClass('is-invalid');
                    help.text('').hide();
                } else {
                    field.addClass('is-invalid');
                    help.text(_glob.ERROR_FIELD).show();
                    err = true;
                }
            } else {
                if (field.val()) {
                    field.removeClass('is-invalid');
                    help.text('').hide();
                } else {
                    field.addClass('is-invalid');
                    help.text(_glob.ERROR_FIELD).show();
                    err = true;
                }
            }
            return err;
        }
    },
    cookie: class {
        constructor(name, value, options) {
            this.name = name;
            this.value = value;
            this.options = options;
        }

        get() {
            let matches = document.cookie.match(
                new RegExp("(?:^|; )" + this.name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }

        set() {
            this.options = this.options || {};
            let expires = this.options.expires;
            if (typeof expires == "number" && expires) {
                let d = new Date();
                d.setDate(d.getDate() + expires);
                expires = this.options.expires = d;
            }
            if (expires && expires.toUTCString) {
                this.options.expires = expires.toUTCString();
            }
            this.value = encodeURIComponent(this.value);
            let updatedCookie = this.name + "=" + this.value;
            for (let propName in this.options) {
                updatedCookie += "; " + propName;
                let propValue = this.options[propName];
                if (propValue !== true) {
                    updatedCookie += "=" + propValue;
                }
            }
            document.cookie = updatedCookie;
            return this;
        }
    },
    setMaps: function () {
        const cookie = new this.cookie('_maps_');
        if (!cookie.get()) {
            cookie.value = true;
            cookie.options = {expires: '', path: '/'};
            cookie.set();
        }
    },
    uuid: function () {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    },
    select2: function () {
        for (const el of document.querySelectorAll('.select2')) {
            let config = {
                width: '100%',
                minimumResultsForSearch: 'Infinity', // hide search
            }
            // live search
            if (el.dataset.select2Search) {
                if (el.dataset.select2Search === 'true') {
                    delete config.minimumResultsForSearch
                }
            }
            // custom content
            if (el.dataset.select2Content) {
                if (el.dataset.select2Content === 'true') {
                    config.templateResult = state => state.id ? $(state.element.dataset.content) : state.text
                    config.templateSelection = state => state.id ? $(state.element.dataset.content) : state.text
                }
            }
            // run
            $(el).select2(config).on('select2:unselecting', function () {
                $(this).data('unselecting', true)
            }).on('select2:opening', function (e) {
                if ($(this).data('unselecting')) {
                    $(this).removeData('unselecting')
                    e.preventDefault()
                }
            })
        }
    },
    inputMask: function () {
        Inputmask().mask(document.querySelectorAll('.inputmask'));
        $('.phone-mask').inputmask({"mask": "+7(999) 999-99-99"});
    },
    synchronization: function () {
        let self = this;
        $('body').on('change', '[data-synchronization]', function (evt) {
            let field = $(this);
            let value = field.val();
            let name = field.attr('data-synchronization').split('.');
            name.forEach(function (item, i, arr) {
                let selector = `[name="${item}"]`;
                $(selector).val(value);
            });
        })
    },
    run: function () {
        this.select2();
        this.inputMask();
        this.validation.control();
        this.setMaps();
        this.synchronization();
    }
}
