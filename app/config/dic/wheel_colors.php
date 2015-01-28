<?php

return array(

    'fields' => function() {

        /**
         * Предзагружаем нужные словари с данными, по системному имени словаря, для дальнейшего использования.
         * Делается это одним SQL-запросом, для снижения нагрузки на сервер БД.
         */
        $dics_slugs = array(
            'wheels',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        #Helper::tad($dics);
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::dd($lists);
        $lists_ids = Dic::makeLists($dics, null, 'id', 'slug');

        return array(
            'wheel_id' => array(
                'title' => 'Колесный диск',
                'type' => 'select',
                #'values' => array('Выберите..') + $lists['dealer_regions'], ## Используется предзагруженный словарь
                'values' => $lists['wheels'], ## Используется предзагруженный словарь
                'default' => Input::get('filter.fields.wheel_id') ?: null,
            ),
            'image' => array(
                'title' => 'Изображение',
                'type' => 'image',
            ),
            'models' => array(
                'title' => 'Модели',
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
            'wheels',
        );
        $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
        $dics = Dic::modifyKeys($dics, 'slug');
        $lists = Dic::makeLists($dics, 'values', 'name', 'id');
        #Helper::tad($lists);

        /**
         * Добавляем доп. элементы в меню, в данном случае: выпадающие поля для организации фильтрации записей по их свойствам
         */
        $menus[] = Helper::getDicValMenuDropdown('wheel_id', 'Все диски', $lists['wheels'], $dic);
        return $menus;
    },

    'second_line_modifier' => function($line, $dic, $dicval) {

        /**
         * Получаем данные, которые были созданы с помощью хука before_index_view (описание ниже).
         */
        $dics = Config::get('temp.index_dics_lists');
        $dic_wheels = $dics['wheels'];
        #Helper::tad($dic_dealer_regions);

        $dicval->extract();
        #Helper::ta($dicval);

        return @$dic_wheels[$dicval->wheel_id];
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
                'wheels',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->with('values')->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::tad($dics);
            Config::set('temp.index_dics', $dics);

            $lists = Dic::makeLists($dics, 'values', 'name', 'id');
            Config::set('temp.index_dics_lists', $lists);
            #Helper::dd($lists);


            /**
             * Создаем списки из полученных данных
             */
            $dic_ids = Dic::makeLists($dics, false, 'id');
            #Helper::d($dic_ids);
            $dicval_ids = Dic::makeLists($dicvals, false, 'id');
            #Helper::d($dicval_ids);

            /**
             * Получаем количество необходимых нам данных, одним SQL-запросом.
             * Сохраняем данные в конфиг - для дальнейшего использования в функции-замыкании actions (см. выше).
             */
            #/*
            $counts = array();
            if (count($dic_ids) && count($dicval_ids))
                $counts = DicVal::counts_by_fields($dic_ids, array('region_id' => $dicval_ids));
            #Helper::dd($counts);
            Config::set('temp.index_counts', $counts);
            #*/
        },
    ),
);