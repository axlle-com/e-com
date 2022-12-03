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
                            <span>Contact</span>
                            <h3>Get in Touch</h3>
                        </div>
                    </div>
                </div>
                <div class="map_wrap">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="355" id="gmap_canvas"
                                    src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                            <a href="https://fmovies-online.net">fmovies</a><br>
                            <style>.mapouter {
                                    position: relative;
                                    text-align: right;
                                    height: 355px;
                                    width: 100%;
                                }</style>
                            <a href="https://www.embedgooglemap.net">embedgooglemap.net</a>
                            <style>.gmap_canvas {
                                    overflow: hidden;
                                    background: none !important;
                                    height: 355px;
                                    width: 100%;
                                }</style>
                        </div>
                    </div>
                </div>
                <div class="fields">
                    <form action="/" method="post" class="contact_form" id="contact_form" autocomplete="off">
                        <div class="returnmessage"
                             data-success="Your message has been received, We will contact you soon."></div>
                        <div class="empty_notice"><span>Please Fill Required Fields</span></div>
                        <div class="first">
                            <ul>
                                <li>
                                    <input id="name" type="text" placeholder="Name">
                                </li>
                                <li>
                                    <input id="email" type="text" placeholder="Email">
                                </li>
                            </ul>
                        </div>
                        <div class="last">
                            <textarea id="message" placeholder="Message"></textarea>
                        </div>
                        <div class="tokyo_tm_button" data-position="left">
                            <a id="send_message" href="#">
                                <span>Send Message</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
