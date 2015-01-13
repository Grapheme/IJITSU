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

    <div class="fader">
        <div style="background-image:url('{{ Config::get('site.theme_path') }}/images/visual-slide-3.jpg');" class="unit"><img src="{{ Config::get('site.theme_path') }}/images/logo-text.png" class="visual">
            <div class="text">
                колесные диски <br>
                с японским сердцем
            </div>
        </div>
        <div style="background-image:url('{{ Config::get('site.theme_path') }}/images/visual-slide-1.png');" class="unit"><img src="{{ Config::get('site.theme_path') }}/images/logo-text.png" class="visual">
            <div class="text">
                колесные диски <br>
                с японским сердцем

            </div>
        </div>
    </div>
    <div class="content col-2">
        <div class="holder">
            <h1>Об IJITSU</h1>
            <div class="col">

                {{ $page->block('about')  }}

            </div>
        </div>
    </div>
    <div class="content visual-left red-bg">
        <div class="holder"><img src="{{ Config::get('site.theme_path') }}/images/decor-certificate.png" class="visual">
            <div class="text">
                <h2>Производство</h2>

                {{ $page->block('toyota')  }}

            </div>
        </div>
    </div>
    <div class="content col-2">
        <div class="holder">
            <h1>Производство</h1>
            <div class="col">

                {{ $page->block('production')  }}

            </div>
        </div>
    </div>
    <div class="content col-2">
        <div class="holder">
            <h1>Стандарт VIA</h1>
            <div class="col">

                {{ $page->block('about')  }}

            </div>
        </div>
    </div>


@stop


@section('scripts')
@stop