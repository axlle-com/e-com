<?php

/**
 * @var $title string
 * @var $model Post
 */

use App\Common\Models\Blog\Post;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <main class="history__main unselectable">
        <div class="history__wrap">
            <div class="row-cols-1 history__item">
                <div class="history__text">
                    <h4 class="history__title">
                        A brief story
                    </h4>

                    <p class="history__paragraph">
                        My woodworking life did not start with my grandfather giving me my first chainsaw for my 1st
                        birthday… neither did I finish my first fruit bowl by the age of 4 in a rustic work shed. Instead,
                        I’ve actually had a few very interesting safaris before. I was a chef, I’ve worked in a monkey
                        conservation park and was contracted as a travel guide in Europe.
                    </p>

                    <p class="history__paragraph">
                        My woodworking life did not start with my grandfather giving me my first chainsaw for my 1st
                        birthday… neither did I finish my first fruit bowl by the age of 4 in a rustic work shed. Instead,
                        I’ve actually had a few very interesting safaris before. I was a chef, I’ve worked in a monkey
                        conservation park and was contracted as a travel guide in Europe.
                    </p>

                    <p class="history__paragraph">
                        My woodworking life did not start with my grandfather giving me my first chainsaw for my 1st
                        birthday… neither did I finish my first fruit bowl by the age of 4 in a rustic work shed. Instead,
                        I’ve actually had a few very interesting safaris before. I was a chef, I’ve worked in a monkey
                        conservation park and was contracted as a travel guide in Europe.
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
