<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        // User Input
        'username' => [
            'required' => 'Username harus diisi',
            'unique' => 'Username sudah digunakan oleh pengguna lain'
        ],
        'displayName' => [
            'required' => 'Display name harus diisi'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'email' => 'Format email tidak valid'
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min' => 'Password minimal terdiri atas 8 karakter',
            'confirmed' => 'Konfirmasi password tidak sesuai'
        ],

        // Web Input
        'nama_web' => [
            'required' => 'Nama web tidak boleh kosong'
        ],
        'sub_domain' => [
            'required' => 'Subdomain tidak boleh kosong',
            'unique' => 'Subdomain sudah digunakan web lain'
        ],

        // Category Input
        'kategori' => [
            'required' => 'Kategori tidak boleh kosong',
        ],

        // Menu Input
        'menu_item_type' => [
            'in' => 'Tipe menu tidak valid',
        ],
        'menu_item_title' => [
            'required' => 'Judul menu tidak boleh kosong'
        ],
        'menu_item_link' => [
            'required' => 'Link menu tidak boleh kosong'
        ],
        'menu_order' => [
            'required' => 'Urutan menu tidak boleh kosong',
            'integer' => 'Urutan menu harus berupa angka'
        ],
        'parent' => [
            'exist' => 'Menu induk tidak valid'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
