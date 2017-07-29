<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | following language lines contain default error messages used by
    | validator class. Some of these rules have multiple versions such
    | as size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute должен быть отмечен.',
    'active_url'           => 'Содержимое поля :attribute должена быть ссылкой.',
    'after'                => 'Значение поля :attribute должно быть датой после :date.',
    'after_or_equal'       => 'Значение поля :attribute должно быть датой равной или после :date.',
    'alpha'                => 'Поле :attribute может содержать только буквы.',
    'alpha_dash'           => 'Поле :attribute может содержать только буквы, цифры и нижние подчеркивания.',
    'alpha_num'            => 'Поле :attribute может содержать только буквы и цифры.',
    'array'                => 'Поле :attribute должно быть массивом.',
    'before'               => 'Значение поля :attribute должно быть датой раньше :date.',
    'before_or_equal'      => 'Значение поля :attribute должно быть датой равной или раньше :date.',
    'between'              => [
        'numeric' => 'Значение :attribute должно быть :min - :max.',
        'file'    => 'Размер файла :attribute должен быть :min - :max КБ.',
        'string'  => 'Строка :attribute должна содержать :min - :max символов.',
        'array'   => 'Объект :attribute должен содержать :min - :max значений.',
    ],
    'boolean'              => 'Значение поля :attribute может быть только либо "истина" либо "ложь".',
    'confirmed'            => 'Значение проверочного поля :attribute confirmation does not match.',
    'date'                 => 'Значение поля :attribute должно быть датой.',
    'date_format'          => 'Значение поля :attribute не соответствует формату: :format.',
    'different'            => 'Поля :attribute и :other должны иметь разные значения.',
    'digits'               => 'Поле :attribute должно содержать целых чисел: :digits.',
    'digits_between'       => 'Поле :attribute должно содержать :min - :max целых чисел.',
    'dimensions'           => 'Изображение :attribute имеет недопустимое разрешение.',
    'distinct'             => 'Поле :attribute не должно содержать повторяющихся значений.',
    'email'                => 'Содержимое поля :attribute должно быть корректным email адресом.',
    'exists'               => 'Выбранное значение :attribute некорректно.',
    'file'                 => 'Содержимое :attribute должно быть файлом.',
    'filled'               => 'Поле :attribute не может быть пустым.',
    'image'                => 'Содержимое :attribute должно быть изображением.',
    'in'                   => 'Выбранное значение для :attribute некорректно.',
    'in_array'             => 'Выбранное значение для :attribute не найдено в :other.',
    'integer'              => 'Значение поля :attribute должно быть целым числом.',
    'ip'                   => 'Содержимое поля :attribute должно быть корректным IP адресом.',
    'ipv4'                 => 'Содержимое поля :attribute должно быть корректным IPv4 адресом.',
    'ipv6'                 => 'Содержимое поля :attribute должно быть корректным IPv6 адресом.',
    'json'                 => 'Значение поля :attribute должно иметь формат JSON строки.',
    'max'                  => [
        'numeric' => 'Максимальное значение для :attribute: :max.',
        'file'    => 'Максимальный размер файла :attribute: :max КБ.',
        'string'  => 'Максимальное кол-во символов для :attribute: :max.',
        'array'   => 'Максимальное кол-во значений для объекта :attribute: :max.',
    ],
    'mimes'                => 'Допустимые типы файла для :attribute: :values.',
    'mimetypes'            => 'Допустимые типы файла для :attribute: :values.',
    'min'                  => [
        'numeric' => 'Минимальное значение для :attribute: :min.',
        'file'    => 'Минимальный размер файла :attribute: :min КБ.',
        'string'  => 'Минимальное кол-во символов для :attribute: :min.',
        'array'   => 'Минимальное кол-во значений для объекта :attribute: :min.',
    ],
    'not_in'               => 'Выбранное значение :attribute некорректно.',
    'numeric'              => 'Значение поля :attribute должно быть числом.',
    'present'              => 'Поле :attribute должно присутствовать.',
    'regex'                => 'Поле :attribute имеет некорректное значение.',
    'required'             => 'Поле :attribute обязательное к заполнению.',
    'required_if'          => 'Поле :attribute обязательное для заполнения если :other имеет значение :value.',
    'required_unless'      => 'Поле :attribute обязательное для заполнения если :other не имеет значение :values.',
    'required_with'        => 'Поле :attribute обязательное для заполнения когда установлены значения :values.',
    'required_with_all'    => 'Поле :attribute обязательное для заполнения когда установлены значения :values.',
    'required_without'     => 'Поле :attribute обязательное для заполнения когда значения :values не установлены.',
    'required_without_all' => 'Поле :attribute обязательное для заполнения когда значения :values не установлены.',
    'same'                 => 'Значене поля :attribute и :other должны совпадать.',
    'size'                 => [
        'numeric' => 'Число :attribute должно иметь размер/значение :size.',
        'file'    => 'Файл :attribute должн иметь размер :size КБ.',
        'string'  => 'Строка :attribute должна состоять из :size символов(-а)',
        'array'   => 'Объект :attribute должн содержать  :size значений.',
    ],
    'string'               => 'Содержимое поля :attribute должно быть строкой.',
    'timezone'             => 'Содержимое поля :attribute должно быть корректной временной зоной.',
    'unique'               => ':attribute уже занят.',
    'uploaded'             => 'Произошла ошибка при загрузке :attribute.',
    'url'                  => 'Содержимое поля :attribute должена быть ссылкой (URL).',
    'spamfree'             => 'Поле :attribute содержит запрещенные слова или спам.',
    'maxwish'              => 'Максимально кол-во слов для поля :attribute: :num_words.',
    'uniquearray'          => 'Это значение уже существует.',
    'alpha_num_s'          => 'Поле :attribute may может содержать только буквы, цифры и пробелы.',
    'less_than'            => 'Значение :attribute дольжно быть мешьне чем :param',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'item' => 'желание',
        'subject' => 'тема',
        'body' => 'сообщение',
        'first_name' => 'имя',
        'password' => 'пароль',
        'terms' => 'условия использования',
        'url' => 'ссылка',
        'currency' => 'валюта',
        'current_amount' => 'текущая сумма',
        'amount_needed' => 'необхадимая Сумма',
        'address_one' => 'адрес 1',
        'address_two' => 'адрес 2',
        'city' => 'город',
        'post_code' => 'индекс',
        'country' => 'страна',
        'amount' => 'сумма',
        'current_password' => 'текущий пароль',
        'quantity' => 'количество',
        'selected' => 'приз'
    ],

];
