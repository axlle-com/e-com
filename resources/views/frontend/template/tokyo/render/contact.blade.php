<?php

/**
 * @var $title string
 * @var $template string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="contact" class="tokyo_tm_section active animated fadeInLeft">
        <div class="container">
            <div class="tokyo_tm_contact">
                <div class="tokyo_tm_title">
                    <div class="title_flex">
                        <div class="left">
                            <span>Контакты</span>
                            <h5>Для связи</h5>
                            <div class="descriptions">
                                <div>8-931-312-2767</div>
                                <div class="info-email">info@yasokolov.ru</div>
                                <h5>Для корреспонденции</h5>
                                <p>107014, г. Москва, а/я 124</p>
                                <h5>Переговорная комната</h5>
                                <p>г. Москва, ул. Бауманская, д. 33/2, строение 1, 3 этаж</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fields">
                    <form action="/ajax/contact" method="post" class="contact_form" autocomplete="off">
                        <div class="returnmessage"></div>
                        <div class="first">
                            <ul>
                                <li>
                                    <input id="name" type="text" placeholder="Имя" name="name" data-validator-required>
                                    <div class="invalid-feedback"></div>
                                </li>
                                <li>
                                    <input id="email" type="text" placeholder="Email" name="email"
                                           data-validator-required>
                                    <div class="invalid-feedback"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="last">
                            <textarea id="message" placeholder="Message" name="body" data-validator-required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group custom-control custom-checkbox">
                            <input type="hidden" class="is-required" name="agreement" value="0">
                            <input type="checkbox" id="agreement-consultation" class="custom-control-input"
                                   name="agreement" value="1" data-validator-required>
                            <label class="custom-control-label" for="agreement-consultation">
                                <a href="javascript:void(0)" data-modal-name="#agreement"
                                   class="link js-custom-modal-open">Согласие
                                    на обработку персональных данных</a>
                            </label>
                            <div class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="tokyo_tm_button" data-position="left">
                            <a href="#">
                                <span class="form-send">Отправить</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show js-custom-modal" id="agreement" tabindex="-1" role="dialog" aria-modal="true"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">СОГЛАШЕНИЕ  О КОНФИДЕНЦИАЛЬНОСТИ</h4>
                </div>
                <div class="js-form-message"></div>
                <div class="modal-body">
                    <h3>Персональные данные</h3>
                    <p>Под персональными данными в настоящем Соглашении понимается любая информация, относящаяся к
                        определенному или определяемому на основании такой информации физическому лицу (пользователю), в
                        том числе его фамилия, имя, отчество, год, месяц, дата рождения, адрес, образование, профессия и
                        иная информация (ФЗ от 27.07.2006 г. № 152).</p>
                    <h3>Обработка Персональных данных</h3>
                    <p>Когда Вы отправляете своё обращение через сайт yasokolov.ru, происходит сбор персональных данных,
                        включающих фамилию, имя, отчество, адрес e-mail, номера телефона, иной информации. Персональные
                        данные, сообщённые Вами при отправке обращения, автоматически сохраняются на серверах.</p>
                    <h3>Использование Персональных данных</h3>
                    <p>Ваши персональные данные, предоставляемые при заполнении формы на сайте yasokolov.ru, в целях
                        оказания Вам услуг, используются исключительно для того, чтобы:</p>
                    <ul>
                        <li>Вы могли получить на указанный Вами адрес e-mail (либо по телефону) ответ по интересующим
                            правовым вопросам;
                        </li>
                        <li>Обрабатывать и разрешать любые обращения, поступающие от Вас через сайт;</li>
                        <li>Собирать Ваши отзывы и предложения, а также публиковать их на сайте.</li>
                    </ul>
                    <h3>Согласие на обработку Персональных данных</h3>
                    <p>Отправляя обращение через сайт yasokolov.ru, Вы даёте согласие на обработку своих персональных
                        данных на условиях настоящего Соглашения.</p>
                    <p>В случае несогласия с каким-либо из условий настоящего Соглашения, Вы не должны отправлять
                        обращение через сайт yasokolov.ru.</p>
                    <h3>Адвокатская тайна</h3>
                    <p>Адвокатской тайной являются любые сведения, связанные с оказанием адвокатом юридической помощи
                        своему доверителю (ФЗ от 31.05.2002 г. № 63). Правила сохранения профессиональной тайны
                        распространяются на:</p>
                    <ul>
                        <li>факт обращения к адвокату, включая имена и названия доверителей;</li>
                        <li>все доказательства и документы, собранные адвокатом в ходе подготовки к делу;</li>
                        <li>сведения, полученные адвокатом от доверителей;</li>
                        <li>информацию о доверителе, ставшую известной адвокату в процессе оказания юридической
                            помощи;
                        </li>
                        <li>содержание правовых советов, данных непосредственно доверителю или ему предназначенных;</li>
                        <li>все адвокатское производство по делу;</li>
                        <li>условия соглашения об оказании юридической помощи, включая денежные расчеты между адвокатом
                            и доверителем;
                        </li>
                        <li>любые другие сведения, связанные с оказанием адвокатом юридической помощи.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-sm js-custom-modal-close"
                            data-dismiss="modal">Понятно
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
