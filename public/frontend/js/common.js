imageArray = {};
sparePartArray = [];
const ERROR_MESSAGE = 'Произошла ошибка, попробуйте позднее!'
const uuid = function () {
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
}
const notyError = function (message = 'Произошла ошибка!') {
    new Noty({
        type: 'error', text: '<h5>Внимание</h5>' + message, timeout: 4000
    }).show()
}
const notySuccess = function (message = 'Все прошло успешно!') {
    new Noty({
        type: 'success', text: '<h5>Внимание</h5>' + message, timeout: 4000
    }).show()
}
const notyInfo = function (message = 'Обратите внимание!') {
    new Noty({
        type: 'info', text: '<h5>Внимание</h5>' + message, timeout: 4000
    }).show()
}
const inputMask = function () {
    Inputmask().mask(document.querySelectorAll('.inputmask'));
    $('.phone-mask').inputmask({"mask": "+7(999) 999-99-99"});

}
const setLocation = function (curLoc) {
    try {
        history.pushState(null, null, curLoc);
        return;
    } catch (e) {
    }
    location.hash = '#' + curLoc;
}
const errorResponse = function (response, form = null) {
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
        notyError(message ? message : ERROR_MESSAGE);
    }
}
const validationControl = function () {
    $('body').on('blur', '[data-validator-required]', function (evt) {
        let field = $(this);
        validationChange(field);
    })
}
const validationChange = function (field) {
    let err = false;
    if (field.attr('type') === 'checkbox') {
        if (field.prop('checked')) {
            field.removeClass('is-invalid');
        } else {
            field.addClass('is-invalid');
            err = true;
        }
    } else {
        if (field.val()) {
            field.removeClass('is-invalid');
        } else {
            field.addClass('is-invalid');
            err = true;
        }
    }
    return err;
}
const globSendObject = (obj, url, callback) => {
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
            if (response && response.data) {
                if (response.data.url) {
                    setLocation(response.data.url);
                }
                let redirect = response.data.redirect;
                if (redirect) {
                    window.location.href = redirect;
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
const globSendForm = (form, callback) => {
    let path = form.attr('action')
    let data = new FormData(form[0]);
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
            if (response && response.data) {
                if (response.status) {
                    form[0].reset();
                }
                if (response.data.url) {
                    setLocation(response.data.url);
                }
                let redirect = response.data.redirect;
                if (redirect) {
                    window.location.href = redirect;
                }
            }
        },
        error: function (response) {
            errorResponse(response, form);
        },
        complete: function () {
        }
    });
}
/********** #start basket **********/
const basketDraw = (data) => {
    let mini = '';
    let quantity = 0;
    if (Object.keys(data).length) {
        quantity = data.quantity;
        let sum = data.sum ? data.sum : 0.0;
        let items = data.items;
        if (Object.keys(items).length) {
            mini += `<object class="toolbar-dropdown cart-dropdown js-widget-cart">`;
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
                                <span class="entry-meta">1 x ${items[key]['price']} ₽</span>
                            </div>
                            <div class="entry-delete" data-js-catalog-product-id="${key}"><i class="icon-x"></i></div>
                        </div>`;
            }
            mini += `<div class="text-right">
                        <p class="text-gray-dark py-2 mb-0"><span class="text-muted">Итого:</span> &nbsp;${sum} ₽</p>
                    </div>`;
            mini += `<div class="d-flex">
                        <div class="pr-2 w-50"><a class="btn btn-outline-secondary btn-sm btn-block mb-0 js-basket-clear" href="javascript:void(0)">Очистить</a></div>
                        <div class="pl-2 w-50"><a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/catalog/basket">Оформить</a></div>
                    </div>`;
            mini += `</object>`;
            $('.js-basket-max-sum').text(sum)
        }
    }
    if (mini) {
        let block = $('.js-block-mini-basket');
        block.find('.js-widget-cart').remove();
        block.append(mini);
        block.find('.header__cart-link').attr('href', '/catalog/basket');
        $('[data-cart-count-bubble]').html(`<span data-cart-count="">${quantity}</span>`).show();
    } else {
        basketClearBlock();
    }
}
const basketAdd = () => {
    $('.a-shop').on('click', '[data-js-catalog-product-id]', function (evt) {
        let button = $(this);
        let max = button.attr('data-js-basket-max');
        let id = button.attr('data-js-catalog-product-id');
        let url = '/catalog/ajax/basket-add';
        globSendObject({'catalog_product_id': id}, url, (response) => {
            if (response.status) {
                notySuccess('Корзина сохранена');
                basketDraw(response.data);
                if (max) {
                    button.closest('tr').remove();
                }
            }
        })
    });
}
const basketClearBlock = () => {
    let block = $('.js-block-mini-basket');
    block.find('.js-widget-cart').remove();
    block.find('.header__cart-link').attr('href', 'javascript:void(0)');
    $('[data-cart-count-bubble]').html('').hide();
    let maxBlock = $('.js-basket-max-block');
    maxBlock.find('tbody').html('');
    maxBlock.find('.js-basket-max-sum').text('');
}
const basketClear = () => {
    $('.a-shop').on('click', '.js-basket-clear', function (evt) {
        let url = '/catalog/ajax/basket-clear';
        globSendObject({}, url, (response) => {
            if (response.status) {
                notySuccess('Корзина очищена');
                basketClearBlock();
            }
        })
    });
}
/********** #end basket **********/

/********** #start user **********/
const userAuthForm = () => {
    $('.a-shop').on('click', '.js-user-submit-button', function (evt) {
        evt.preventDefault;
        let form = $(this).closest('form') ? $(this).closest('form') : 0;
        if (form) {
            let err = [];
            let isErr = false;
            $.each(form.find('[data-validator-required]'), function (index, value) {
                err.push(validationChange($(this)));
            });
            isErr = err.indexOf(true) !== -1;
            if (!isErr) {
                globSendForm(form, (response) => {
                    if (response.status) {

                    }
                })
            }
        }
    });
}
/********** #end user **********/

$(document).ready(function () {
    inputMask();
    basketAdd();
    basketClear();
    validationControl();
    userAuthForm();
})
