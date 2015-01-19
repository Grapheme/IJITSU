<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
@section('title'){{{ isset($page_title) ? $page_title : Config::get('app.default_page_title') }}}@stop
@section('description'){{{ isset($page_description) ? $page_description : Config::get('app.default_page_description') }}}@stop
@section('keywords'){{{ isset($page_keywords) ? $page_keywords : Config::get('app.default_page_keywords') }}}@stop
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <link rel="icon" type="image/png" href="{{ Config::get('site.theme_path') }}/images/favicon.png">
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::stylemod(Config::get('site.theme_path').'/styles/main.css') }}
        {{ HTML::scriptmod(Config::get('site.theme_path').'/scripts/vendor/modernizr.js') }}

        <script>
            var theme_path = '{{ URL::to(Config::get('site.theme_path')) }}';
        </script>