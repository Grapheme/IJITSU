<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<div id="header"><a href="{{ URL::route('mainpage') }}" class="logo"><img src="{{ Config::get('site.theme_path') }}/images/logo-main.png"></a>

    {{ Menu::placement('main_menu') }}

    {{--
    <div id="menu">
        <a href="index.html" class="active">
            <div class="label">Главная</div>
        </a><a href="catalog.html">
            <div class="label">Каталог</div>
        </a><a href="about.html">
            <div class="label">Об IJUTSU</div>
        </a><a href="wherebuy.html">
            <div class="label">Где купить</div>
        </a>
    </div>
    --}}
</div>
