<?
/**
 * TITLE: Где купить
 * AVAILABLE_ONLY_IN_ADVANCED_MODE
 */
?>
<?
/**
 * Находим регионы
 */
$regions = Dic::valuesBySlug('dealer_regions', function($query){
    $query->orderBy('lft');
});
$regions = DicVal::extracts($regions, null, 1, 1);
#Helper::tad($regions);

/**
 * ..и их ID
 */
$regions_ids = Dic::makeLists($regions, null, 'id');
#Helper::tad($regions_ids);

/**
 * Подгружаем дилеров
 */
$dealers = Dic::valuesBySlug('dealers', function($query) use ($regions_ids){

    $tbl1 = $query->join_field('region_id', null);
    $query->whereIn($tbl1.'.value', $regions_ids);

    $query->orderBy('lft');
});
#Helper::smartQueries(1);
$dealers = DicVal::extracts($dealers, null, 1, 1);
#$dealers = DicLib::loadImages($dealers, 'image');
#Helper::tad($dealers);

/**
 * Раскладываем
 */
$temp = new Collection();
$dealers_json = array();
foreach ($dealers as $dealer) {
    if (!isset($temp[$dealer->region_id]))
        $temp[$dealer->region_id] = new Collection();
    $temp[$dealer->region_id][$dealer->id] = $dealer;

    $emails = array();
    $temp = explode("\n", $dealer->emails . "\n");
    if (count($temp)) {
        foreach ($temp as $email) {
            $email = trim($email);
            if (!$email)
                continue;
            $emails[] = "<a href='mailto:" . $email ."'>" . $email . "</a>";
        }
    }

    $dealers_json[] = array(
        "lat" => 48.015883,
        "lng" => 37.80285,
        "text" => "<strong>" . $dealer->city . "</strong> <br>" . $dealer->address . "<br> " . $dealer->organization . " <br>" . $dealer->phones . " <br>" . implode(', ', $emails)
    );
}
$dealers = $temp;
unset($temp);
#Helper::tad($dealers);
?>
@extends(Helper::layout())


@section('page_class')contacts @stop


@section('style')
@stop


@section('content')

    <div class="content col-2 mini-padding">
        <div class="holder">
            <h1>Официальные дилеры</h1>
        </div>
    </div>
    <div id="contacts-map" data-json="/json/contacts-map.json"></div>
    <div class="content contacts-block">
        <div class="holder">
            @foreach ($regions as $region)
                <?
                    if (!@count($dealers[$region->id]))
                        continue;
                ?>
            <div class="subject">
                <h2>{{ $region->name }}</h2>

                @foreach ($dealers[$region->id] as $dealer)
                    <?
                        $emails = array();
                        $temp = explode("\n", $dealer->emails . "\n");
                        if (count($temp)) {
                            foreach ($temp as $email) {
                                $email = trim($email);
                                if (!$email)
                                    continue;
                                $emails[] = $email;
                            }
                        }
                    ?>
                <div class="unit">
                    {{ $dealer->city }} <br>
                    {{ $dealer->address }}<br>
                    {{ $dealer->name }} <br>
                    {{ $dealer->phones }} <br>
                    @if (count($emails))
                        @foreach ($emails as $email)
                            <a href='mailto:{{ $email }}'>{{ $email }}</a>
                        @endforeach
                    @endif
                </div>
                @endforeach
            </div>
            @endforeach

        </div>
    </div>

@stop


@section('scripts')
    <script>
        var dealers = {{ json_encode($dealers_json) }};
    </script>
@stop