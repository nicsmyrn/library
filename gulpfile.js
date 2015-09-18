var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.copy('node_modules/bootstrap-sass/assets/fonts/', 'public/fonts');
    mix.sass('app.scss');

    mix.styles([
        'libs/bootstrap-theme.min.css',
        'libs/select2.min.css',
        'libs/bootstrap-table.min.css',
        'libs/sweetalert.css',
        'libs/pnotify.custom.min.css',
        'libs/bootstrap-social.css',
        'libs/font-awesome.min.css'
    ]);

    mix.styles([
        'dashboard/metisMenu.min.css',
        //'dashboard/morris.css',
        'dashboard/sb-admin-2.css',
        'dashboard/timeline.css'
    ], 'public/css/dashboard.css');
    //
    mix.scripts([
        'libs/jquery-1.11.3.min.js',
        'libs/jquery-migrate-1.2.1.min.js',
        'libs/bootstrap.min.js',
        //'libs/bootstrap-table.min.js',
        //'libs/bootstrap-table-zh-CN.min.js',
        'libs/select2.min.js',
        'libs/sweetalert.min.js',
        'libs/pnotify.custom.min.js',
        'global.js'
    ]);

    mix.scripts([
        'vendor/vue.min.js',
        'vendor/vue-resource.min.js',
    ], 'public/js/vendor.js');
    //
    //mix.scripts([
    //    //'dashboard/metisMenu.min.js',
    //    //'dashboard/morris.min.js',
    //    //'dashboard/morris-data.js',
    //    //'dashboard/raphael-min.js',
    //    //'dashboard/sb-admin-2.js',
    //    //'dashboard/flot-data.js',
    //], 'public/js/dashboard.js');
});
