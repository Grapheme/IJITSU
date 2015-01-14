<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<div id="header"><a href="index.html" class="logo"><img src="{{ Config::get('site.theme_path') }}/images/logo-main.png"></a>

    <ul id="menu__">
        {{ Menu::placement('main_menu') }}
    </ul>

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
