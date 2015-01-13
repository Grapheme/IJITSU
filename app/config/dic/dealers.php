<?php

return array(

    'fields' => function() {

        /**
         * Предзагружаем нужные словари с данными, по системному имени словаря, для дальнейшего использования.
         * Делается это одним SQL-запросом, для снижения нагрузки на сервер БД.
         */
        $dics_slugs = array(
            'dealer_regions',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);
        $lists_ids = Dic::makeLists($dics, null, 'id', 'slug');

        return array(
            'region_id' => array(
                'title' => 'Регион',
                'type' => 'select',
                #'values' => array('Выберите..') + $lists['dealer_regions'], ## Используется предзагруженный словарь
                'values' => $lists['dealer_regions'], ## Используется предзагруженный словарь
            ),
            'city' => array(
                'title' => 'Город/Населенный пункт',
                'type' => 'text',
            ),
            'address' => array(
                'title' => 'Адрес',
                'type' => 'text',
            ),
            'lat' => array(
                'title' => 'Широта',
                'type' => 'text',
            ),
            'lng' => array(
                'title' => 'Долгота',
                'type' => 'text',
            ),
            'phones' => array(
                'title' => 'Телефоны',
                'type' => 'textarea',
            ),
            'emails' => array(
                'title' => 'Адреса e-mail',
                'type' => 'textarea',
            ),
        );
    },

    /**
     * MENUS - дополнительные пункты верхнего меню, под названием словаря.
     */
    'menus' => function($dic, $dicval = NULL) {
        $menus = array();
        $menus[] = array('raw' => '<br/>');

        /**
         * Предзагружаем словари для дальнейшего использования, одним SQL-запросом
         */
        $dics_slugs = array(
            'dealer_regions',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::tad($lists);

        /**
         * Добавляем доп. элементы в меню, в данном случае: выпадающие поля для организации фильтрации записей по их свойствам
         */
        $menus[] = Helper::getDicValMenuDropdown('region_id', 'Все регионы', $lists['dealer_regions'], $dic);
        return $menus;
    },

    'second_line_modifier' => function($line, $dic, $dicval) {

        /**
         * Получаем данные, которые были созданы с помощью хука before_index_view (описание ниже).
         */
        $dics = Config::get('temp.index_dics_lists');
        $dic_dealer_regions = $dics['dealer_regions'];
        #Helper::tad($dic_dealer_regions);

        $dicval->extract();
        #Helper::ta($dicval);

        return @$dic_dealer_regions[$dicval->region_id];
    },

    /**
     * HOOKS - набор функций-замыканий, которые вызываются в некоторых местах кода модуля словарей, для выполнения нужных действий.
     */
    'hooks' => array(

        /**
         * Вызывается в методе index, перед выводом данных в представление (вьюшку).
         * На этом этапе уже известны все элементы, которые будут отображены на странице.
         */
        'before_index_view' => function ($dic, $dicvals) {
            /**
             * Предзагружаем нужные словари
             */
            $dics_slugs = array(
                'dealer_regions',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::tad($dics);
            Config::set('temp.index_dics', $dics);

            $lists = Dic::makeLists($dics, 'values', 'name', 'id');
            Config::set('temp.index_dics_lists', $lists);
            #Helper::dd($lists);

        },
    ),
);