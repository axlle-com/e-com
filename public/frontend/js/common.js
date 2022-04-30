/********** #start basket **********/
const _basket = {
    draw: function (data) {
        let self = this;
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
                        <div class="pl-2 w-50"><a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/user/order">Оформить</a></div>
                    </div>`;
                mini += `</object>`;
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
        let self = this;
        $('.a-shop').on('click', '[data-js-catalog-product-id]', function (evt) {
            let button = $(this);
            let max = button.attr('data-js-basket-max');
            let id = button.attr('data-js-catalog-product-id');
            let url = '/catalog/ajax/basket-add';
            _glob.send.object({'catalog_product_id': id}, url, (response) => {
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
        let self = this;
        $('.a-shop').on('click', '.js-basket-clear', function (evt) {
            let url = '/catalog/ajax/basket-clear';
            _glob.send.object({}, url, (response) => {
                if (response.status) {
                    _glob.noty.success('Корзина очищена');
                    self.clearBlock();
                }
            })
        });
    },
    run: function () {
        this.add();
        this.clear();
    }
}
/********** #start user **********/
const _user = {
    authForm: function () {
        $('.a-shop').on('click', '.js-user-submit-button', function (evt) {
            evt.preventDefault;
            let form = $(this).closest('form') ? $(this).closest('form') : 0;
            if (form) {
                let err = [], isErr = false;
                $.each(form.find('[data-validator-required]'), function (index, value) {
                    err.push(_glob.validation.change($(this)));
                });
                isErr = err.indexOf(true) !== -1;
                if (!isErr) {
                    _glob.send.form(form, (response) => {
                        if (response.status) {

                        }
                    })
                }
            }
        });
    },
    activatePhone: function () {
        $('.a-shop').on('click', '.js-user-phone-activate-button', function (evt) {
            evt.preventDefault;
            let inp = $('[name="activate_phone"]').val();
            if (inp) {
                _glob.send.object({phone: inp}, '/user/activate-phone', async (response) => {
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
                            _glob.send.object({code: text}, '/user/activate-phone-code',(response) => {
                                if (response.status) {
                                    _glob.noty.success(response.message);
                                }
                            });
                        }
                    }
                })
            }
        });
    },
    run: function () {
        this.authForm();
        this.activatePhone();
    }
}
/********** #start order **********/
const _order = {
    arrow: function () {
        let self = this;
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
        let self = this;
        $('.a-shop .order-page').on('shown.bs.tab', function (evt) {
            let target = $(evt.target).attr('href');
            let arr = target.split('-');
            let num = parseInt(arr[arr.length - 1]);
            let prev = $('[data-js-tab-order="prev"]');
            let next = $('[data-js-tab-order="next"]');
            switch (num) {
                case 1:
                case 2:
                    next.text('Вперед');
                    break;
                case 3:
                    next.text('Оформить');
                    break;
                default:
                    return false;
            }
        });
    },
    run: function () {
        this.arrow();
        this.tabs();
    }
}
/********** #start load **********/
$(document).ready(function () {
    _glob.run();
    _basket.run();
    _user.run();
    _order.run();
})
