const _cl_ = (p) => {
    console.log(p);
}
const _glob = {
    ERROR_MESSAGE: 'Произошла ошибка, попробуйте позднее!',
    ERROR_FIELD: 'Поле обязательное для заполнения',
    spareParts: [],
    images: {},
    pathArray: null,
    searchParams: null,
    propertyTypes: {
        value_int: 'number',
        value_varchar: 'text',
        value_decimal: 'number',
        value_text: 'text',
    },
    console: {
        error: function (message = null) {
            if (message) {
                console.log(`%c ${message} `, `background: #d43f3a; color: #eee`);
            } else {
                console.log(`%c ${_glob.ERROR_MESSAGE} `, `background: #d43f3a; color: #eee`);
            }
        },
        info: function (message) {
            console.log(`%c ${message} `, `background: #4cae4c; color: #eee`);
        },
    },
    noty: {
        config: function (type, message) {
            const text = '<h5>Внимание</h5>' + message;
            const _config = {type, text, timeout: 4000, theme: 'relax'};
            try {
                new Noty(_config).show();
            } catch (e) {
                this.console.error(e.message);
                alert(message);
            }
        },
        error: function (message = 'Произошла ошибка!') {
            this.config('error', message);
        },
        success: function (message = 'Все прошло успешно!') {
            this.config('success', message);
        },
        info: function (message = 'Обратите внимание!') {
            this.config('info', message);
        }
    },
    send: {
        object: function (obj, url, callback) {
            const self = this;
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
            const self = this;
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
            const self = this;
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
            let json, message, error;
            if (response && (json = response.responseJSON)) {
                message = json.message;
                error = json.error;
            }
            if (response.status === 400) {
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
                _glob.noty.error(message ? message : _glob.ERROR_MESSAGE);
            }
            if (response.status === 500) {
                _glob.noty.error(response.statusText ? response.statusText : _glob.ERROR_MESSAGE);
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
        data: function (response) {
            if (response && 'status' in response && response.status && 'data' in response && Object.keys(response.data).length) {
                return response.data;
            }
            return false;
        },
        view: function (response) {
            let data = this.data(response)
            if (data && 'view' in data) {
                return data.view;
            }
            return false;
        },
    },
    preloader: `<div class="preloader" style="display: none;">
            <div class="lds-spinner">
            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
            </div>
            </div>`,
    request: class {
        validate;
        hasErrors = false;
        hasSend = false;
        payload;
        action;
        form;
        response;
        data;
        view;
        preloader;

        constructor(object = null, validate = true) {
            this.reset().validate = validate;
            if (object) {
                this.setObject(object);
            }
        }

        reset() {
            this.hasErrors = this.hasSend = false;
            this.payload = this.action = this.form = this.response = this.data = this.view = this.preloader = null;
            return this;
        }

        setPreloader(element) {
            const self = this;
            let block = $(element);
            if (block && block.length) {
                self.preloader = $(_glob.preloader);
                block.addClass('relative');
                block.prepend(self.preloader);
            }
            return self;
        }

        setObject(object = null) {
            this.data = this.view = this.response = null;
            if (object) {
                if ('action' in object) {
                    this.action = object.action;
                    delete object.action;
                    let data = new FormData();
                    if (Object.keys(object).length) {
                        for (let key in object) {
                            /****** TODO make recursive  ******/
                            if (typeof object[key] === 'object') {
                                let cnt = 0;
                                for (let key2 in object[key]) {
                                    data.append(key + '[' + cnt + ']', object[key][key2]);
                                    cnt++;
                                }
                            } else {
                                data.append(key, object[key]);
                            }
                        }
                    }
                    this.payload = data;
                } else if (object instanceof jQuery) {
                    this.form = object;
                    this.action = this.form.attr('action');
                    this.payload = new FormData(this.form[0]);
                    if (this.validate) {
                        let err = [];
                        $.each(this.form.find('[data-validator-required]'), function (index, value) {
                            err.push(_glob.validation.change($(this)));
                        });
                        this.hasErrors = err.indexOf(true) !== -1;
                    }
                } else {
                    _glob.console.error('Не известные данные');
                }
            }
            return this;
        }

        setAction(action) {
            this.action = action;
            return this;
        }

        appendPayload(object = null) {
            if (object && this.payload) {
                if (Object.keys(object).length) {
                    for (let key in object) {
                        /****** TODO make recursive  ******/
                        if (typeof object[key] === 'object') {
                            let cnt = 0;
                            for (let key2 in object[key]) {
                                this.payload.append(key + '[' + cnt + ']', object[key][key2]);
                                cnt++;
                            }
                        } else {
                            this.payload.append(key, object[key]);
                        }
                    }
                }
            } else {
                _glob.console.error('Нечего отправлять');
            }
            return this;
        }

        send(callback = null) {
            const self = this;
            if (this.hasErrors) {
                _glob.noty.error('Заполнены не все обязательные поля');
                return;
            }
            if (this.hasSend) {
                _glob.console.error('Форма еще отправляется');
                return;
            }
            if (self.preloader) {
                self.preloader.show();
            }
            self.hasSend = true;
            if (Object.keys(_glob.images).length) {
                for (let key in _glob.images) {
                    let images = _glob.images[key]['images'];
                    if (Object.keys(images).length) {
                        for (let key2 in images) {
                            self.payload.append('galleries[' + key + '][images][' + key2 + '][file]', images[key2]['file']);
                        }
                    }
                }
            }
            const csrf = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: self.action,
                headers: {'X-CSRF-TOKEN': csrf},
                type: 'POST',
                dataType: 'json',
                data: self.payload,
                processData: false,
                contentType: false,
                beforeSend: function () {
                },
                success: function (response) {
                    self.setData(response).defaultBehavior();
                    if (callback) {
                        callback(response);
                    }
                },
                error: function (response) {
                    self.errorResponse(response);
                },
                complete: function () {
                    self.hasSend = false;
                    if (self.preloader) {
                        self.preloader.hide();
                    }
                }
            });
        }

        getData() {
            const self = this;
            if (!self.data) {
                if (self.response && 'status' in self.response && self.response.status && 'data' in self.response) {
                    self.data = self.response.data;
                } else {
                    self.data = false;
                }
            }
            return self.data;
        }

        setData(response) {
            const self = this;
            self.response = response;
            if (response && 'status' in response && response.status && 'data' in response) {
                self.data = response.data;
                self.form ? self.form[0].reset() : null;
            } else {
                self.data = null;
            }
            return self;
        }

        defaultBehavior() {
            let self = this, data, url, redirect, view;
            if ((data = self.data)) {
                if ('url' in data && (url = data.url)) {
                    self.setLocation(url);
                }
                if ('redirect' in data && (redirect = data.redirect)) {
                    window.location.href = redirect;
                }
                if ('view' in data && (view = data.view)) {
                    self.view = view;
                }
            }
        }

        errorResponse(response, form = null) {
            let json, message, error;
            if (response && (json = response.responseJSON)) {
                message = json.message;
                error = json.error;
            }
            if (response.status === 400) {
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
                _glob.noty.error(message ? message : _glob.ERROR_MESSAGE);
            } else if (response.status === 406) {
                _glob.noty.error(message ? message : _glob.ERROR_MESSAGE);
            } else if (response.status === 500) {
                _glob.noty.error(response.statusText ? response.statusText : _glob.ERROR_MESSAGE);
            } else {
                _glob.noty.error(response.statusText ? response.statusText : _glob.ERROR_MESSAGE);
            }
        }

        setLocation(curLoc) {
            try {
                history.pushState(null, null, curLoc);
                return;
            } catch (e) {
            }
            location.hash = '#' + curLoc;
        }
    },
    validation: {
        control: function () {
            const self = this;
            $('body').on('blur', '[data-validator-required]', function (evt) {
                let field = $(this);
                self.change(field);
            })
        },
        change: function (field) {
            _cl_(field)
            let err = false, self = this;
            let help = field.closest('div').find('.invalid-feedback');
            if (field.attr('type') === 'checkbox') {
                if (field.prop('checked')) {
                    field.removeClass('is-invalid');
                    help.text('').hide();
                } else {
                    field.addClass('is-invalid');
                    help.text(self.ERROR_FIELD).show();
                    err = true;
                }
            } else {
                if (field.val()) {
                    field.removeClass('is-invalid');
                    help.text('').hide();
                } else {
                    field.addClass('is-invalid');
                    help.text(self.ERROR_FIELD).show();
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
        $('.phone-mask').inputmask({"mask": "+7(999) 999-99-99"});
    },
    synchronization: function () {
        const self = this;
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
        try {
            const urlSearchParams = new URLSearchParams(window.location.search);
            const params = Object.fromEntries(urlSearchParams.entries());
            if (Object.keys(params).length) {
                this.searchParams = params;
            }
            const path = document.location.pathname.replace(/\//, '');
            if (path) {
                this.pathArray = path.split('/');
            }
        } catch (e) {
            this.console.error(e.message);
        }
        try {
            this.inputMask();
        } catch (e) {
            this.console.error(e.message);
        }
        try {
            this.select2();
        } catch (e) {
            this.console.error(e.message);
        }
        this.validation.control();
        this.setMaps();
        this.synchronization();
    }
}
