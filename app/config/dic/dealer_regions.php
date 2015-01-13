<?php

return array(

    /**
     * ACTIONS - дополнительные элементы в столбце "Действия", на странице списка записей словаря.
     * Внутри данной функции не должно производиться запросов к БД!
     * Все запросы следует выносить в хуки (описание хуков ниже).
     */
    'actions' => function($dic, $dicval) {

        /**
         * Получаем данные, которые были созданы с помощью хука before_index_view (описание ниже).
         */
        $dics = Config::get('temp.index_dics');
        $dic_dealers = $dics['dealers'];
        $counts = Config::get('temp.index_counts');

        /**
         * Возвращаем доп. элементы в столбец "Действия": кнопки со ссылками и счетчиками, индивидуальны для каждой записи
         */
        return '
            <span class="block_ margin-bottom-5_">
                <a href="' . URL::route('entity.index', array('dealers', 'filter[fields][region_id]' => $dicval->id)) . '" class="btn btn-default">
                    Дилеры (' . @(int)$counts[$dicval->id][$dic_dealers->id]. ')
                </a>
            </span>
        ';
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
                'dealers',
            );
            $dics = Dic::whereIn('slug', $dics_slugs)->get();
            $dics = Dic::modifyKeys($dics, 'slug');
            #Helper::tad($dics);
            Config::set('temp.index_dics', $dics);

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