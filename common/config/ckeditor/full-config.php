<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 30.10.14
 * Time: 22:13
 */

/**
 *
 * full preset returns the full toolbar configuration set for CKEditor.
 */
return [
    'height' => 300,
    'toolbarGroups' => [
        ['name' => 'clipboard', 'groups' => ['mode','undo', 'selection', 'clipboard', 'doctools']],
        ['name' => 'editing', 'groups' => ['find', 'spellchecker', 'tools', 'about']],

        ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
        ['name' => 'forms'],

        ['name' => 'styles'],
        ['name' => 'blocks'],
        '/',
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
        ['name' => 'links', 'groups' => ['links', 'insert']],
        ['name' => 'others'],

    ],
];