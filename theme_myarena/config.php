<?php
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'myarena';
$THEME->parents = ['boost'];
$THEME->sheets = [];

$THEME->layouts = [
    'base' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'standard' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'course' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'coursecategory' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'incourse' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'frontpage' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'admin' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mydashboard' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mypublic' => [
        'file' => 'columns1.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'login' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'popup' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
    'maintenance' => [
        'file' => 'columns1.php',
        'regions' => [],
    ],
];
