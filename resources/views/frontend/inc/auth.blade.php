<!-- start authModal -->
<a href="#" class="header__login-link" data-toggle="modal" data-target="#authModal">
    <svg aria-hidden="true" focusable="false" class="header__login-icon" viewBox="0 0 28.33 37.68">
        <path
            d="M14.17 14.9a7.45 7.45 0 1 0-7.5-7.45 7.46 7.46 0 0 0 7.5 7.45zm0-10.91a3.45 3.45 0 1 1-3.5 3.46A3.46 3.46 0 0 1 14.17 4zM14.17 16.47A14.18 14.18 0 0 0 0 30.68c0 1.41.66 4 5.11 5.66a27.17 27.17 0 0 0 9.06 1.34c6.54 0 14.17-1.84 14.17-7a14.18 14.18 0 0 0-14.17-14.21zm0 17.21c-6.3 0-10.17-1.77-10.17-3a10.17 10.17 0 1 1 20.33 0c.01 1.23-3.86 3-10.16 3z">
        </path>
    </svg>
</a>
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="nav-item">
                        <a class="nav-link active" href="#loginTab" role="tab" data-toggle="tab"
                           aria-controls="home" aria-selected="true">
                            Вход
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a class="nav-link" href="#registrationTab" role="tab" data-toggle="tab"
                           aria-controls="profile" aria-selected="false">
                            Регистрация
                        </a>
                    </li>
                </ul>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="1" y1="-1" x2="21.1537" y2="-1"
                              transform="matrix(0.691658 0.722226 -0.691658 0.722226 1 2)"
                              stroke="#007bff" stroke-width="2" stroke-linecap="round"/>
                        <line x1="1" y1="-1" x2="21.1537" y2="-1"
                              transform="matrix(-0.691658 0.722226 0.691658 0.722226 17 2)"
                              stroke="#007bff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="loginTab">
                        <form class="form-horizontal big" action="/user/ajax/login">
                            <div class="form-group">
                                <label for="login_input">Логин</label>
                                <input type="text" class="form-control" id="login_input" data-validator-required
                                       data-validator="login" name="login">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="login_pass_input">Пароль</label>
                                <input type="password"
                                       autocomplete="off"
                                       class="form-control"
                                       id="login_pass_input"
                                       data-validator-required
                                       data-validator="password"
                                       name="password">
                                <div class="invalid-feedback"></div>
                                <div class="form-group forgot-pass mt-3">
                                    <a href="/user/restore password">Забыли пароль?</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <input
                                        class="form__checkbox"
                                        type="checkbox"
                                        name="remember"
                                        id="loginCheckbox">
                                    <label for="loginCheckbox">
                                        Запомнить меня
                                    </label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <a class="btn btn-outline-default js-user-submit-button">Войти</a>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="registrationTab">
                        <form class="form-horizontal big" action="/user/ajax/registration">
                            <div class="form-group">
                                <label for="register_first_name">Имя</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="register_first_name"
                                    name="first_name"
                                    data-validator-required
                                    data-validator="first_name">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="register_last_name">Фамилия</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="register_last_name"
                                    name="last_name"
                                    data-validator-required
                                    data-validator="last_name">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="register_phone_input">Номер телефона</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control phone-mask"
                                    id="register_phone_input"
                                    data-validator-required
                                    data-validator="phone">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="registerPassInput">Пароль</label>
                                <input
                                    type="password"
                                    name="password"
                                    value=""
                                    autocomplete="off"
                                    class="form-control"
                                    id="registerPassInput"
                                    data-validator-required
                                    data-validator="password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="registerPassInputRe">Повторите пароль</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    value=""
                                    class="form-control"
                                    id="registerPassInputRe"
                                    data-validator-required
                                    data-validator="password_confirmation">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <a class="btn btn-outline-default js-user-submit-button">
                                    Зарегистрироваться
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end authModal -->
