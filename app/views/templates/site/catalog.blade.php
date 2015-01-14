<?
/**
 * TITLE: Каталог
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
/**
 * Находим все колеса
 */
$wheels = Dic::valuesBySlug('wheels', function($query){
    #$tbl1 = $query->join_field('show_on_main', null);
    #$query->where($tbl1.'.value', 1);
    $query->orderBy('lft');
});
$wheels = DicVal::extracts($wheels, null, 1, 1);
#Helper::tad($wheels);

/**
 * ..и их ID
 */
$wheels_ids = Dic::makeLists($wheels, null, 'id');
#Helper::tad($wheels_ids);

/**
 * Подгружаем цвета
 */
$wheels_images = Dic::valuesBySlug('wheel_colors', function($query) use ($wheels_ids){

    $tbl1 = $query->join_field('wheel_id', null);
    $query->whereIn($tbl1.'.value', $wheels_ids);

    $query->orderBy('lft');
});
#Helper::smartQueries(1);
$wheels_images = DicVal::extracts($wheels_images, null, 1, 1);
$wheels_images = DicLib::loadImages($wheels_images, 'image');
#Helper::tad($wheels_images);

/*
foreach ($wheels_images as $img) {
    echo "<img src='" . $img->image->thumb() . "' title='" . $img->id . "' />\n";
}
#*/

/**
 * Раскладываем
 */
$temp = array();
foreach ($wheels_images as $img) {
    #if (!is_object($img->image))
    #    continue;
    if (!isset($temp[$img->wheel_id]))
        $temp[$img->wheel_id] = array();
    $temp[$img->wheel_id][$img->id] = $img;
}
$wheels_images = $temp;
unset($temp);
#Helper::tad($wheels_images);
?>
@extends(Helper::layout())


@section('page_class')catalog @stop


@section('style')
@stop


@section('content')

    {{ $page->block('fader') }}

    @if (is_object($wheels) && $wheels->count()))
    <div class="content col-4">
        <div class="holder">
            <h1>Каталог</h1>
            <div class="wrapper">
                <!--
                @foreach ($wheels as $wheel)
                    <?
                    if (!isset($wheels_images[$wheel->id]) || !count($wheels_images[$wheel->id]))
                        continue;

                    $colors_images = array();
                    $colors_text = array();
                    $image_thumb = '';
                    $image_full = '';
                    foreach ($wheels_images[$wheel->id] as $img) {
                        if (!is_object($img->image)) {
                            $colors_text[$img->id] = $img->name;
                            continue;
                        }

                        $colors_images[$img->id] = $img;

                        if (!$image_thumb) {
                            $image_thumb = $img->image->thumb();
                            $image_full = $img->image->full();
                        }
                    }

                    $models = array();
                    $temp = explode("\n", $wheel->models . "\n");
                    if (count($temp)) {
                        foreach ($temp as $model) {
                            $model = trim($model);
                            if (!$model)
                                continue;
                            $first_letter = mb_substr($model, 0, 1);
                            if (!isset($models[$first_letter]))
                                $models[$first_letter] = array();
                            $models[$first_letter][] = $model;
                        }
                    }
                    ?>
                --><a id="id-1" href="" class="col">
                    <div style="background-image:url('{{ $image_thumb }}');" class="visual"></div>
                    <div class="shadow"></div>
                    <h2>{{ $wheel->name }}</h2>
                    <div class="detail">
                        <div class="holder"><img src="{{ Config::get('site.theme_path') }}/images/ico-cross.png" class="close">
                            <h2>{{ $wheel->name }}</h2>
                            <div class="left">
                                <div class="visual">
                                    <div style="background-image:url('{{ $image_thumb }}');" class="show"></div>
                                    <img src="{{ Config::get('site.theme_path') }}/images/decor-shadow-big.png" class="shadow">
                                </div>
                            </div>
                            <div class="right">
                                @if (count($colors_images))
                                <h2>Цвета</h2>
                                <div class="colors">
                                    @foreach ($colors_images as $color)
                                    <div data-big-img="{{ $color->image->full() }}" class="unit">
                                        <div style="background-image:url('{{ $color->image->thumb() }}');" class="visual"></div>
                                        <div class="title">{{ $color->name }}</div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                @if (count($colors_text))
                                <h2>Другие цвета</h2>
                                <div class="other-color">{{ implode(', ', $colors_text) }}</div>
                                @endif

                                @if (count($models))
                                <h2>Модели</h2>
                                <div class="models">
                                    <div class="left">
                                        @foreach ($models as $letter => $mdls)
                                        <div class="letter-holder">
                                            <div class="letter">{{ $letter }}</div>
                                            <div class="car-holder">
                                                @foreach ($mdls as $model)
                                                    <div class="car">{{ $model }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="clrfx"></div>
                                </div>
                                @endif

                            </div>
                            <div class="clrfx"></div>
                        </div>
                    </div>
                </a><!--
                @endforeach
                -->
            </div>
        </div>
    </div>
    @endif
    <div class="mark"></div>
    <div class="detail-view"></div>

@stop


@section('scripts')
@stop