<?
/**
 * TITLE: Об IJITSU
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
@extends(Helper::layout())


@section('page_class')about @stop


@section('style')
@stop


@section('content')

    {{ $page->block('fader') }}

    <div class="content col-2">
        <div class="holder">
            <h1>{{ $page->block('about', 'name') }}</h1>
            <div class="col">

                {{ $page->block('about') }}

            </div>
        </div>
    </div>
    <div class="content visual-left red-bg">
        <div class="holder"><img src="{{ Config::get('site.theme_path') }}/images/decor-certificate.png" class="visual">
            <div class="text">
                <h2>{{ $page->block('toyota', 'name') }}</h2>

                {{ $page->block('toyota') }}

            </div>
        </div>
    </div>
    <div class="content col-2">
        <div class="holder">
            <h1>{{ $page->block('production', 'name') }}</h1>
            <div class="col">

                {{ $page->block('production') }}

            </div>
            <h1>{{ $page->block('via', 'name') }}</h1>
            <div class="col">

                {{ $page->block('via') }}

            </div>
        </div>
    </div>


@stop


@section('scripts')
@stop