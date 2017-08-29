var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix
            // Copy webfont files from /vendor directories to /public directory.
            .copy('vendor/fortawesome/font-awesome/fonts', 'public/build/fonts/font-awesome')
            .copy('vendor/twbs/bootstrap-sass/assets/fonts/bootstrap', 'public/build/fonts/bootstrap')
            .copy('vendor/twbs/bootstrap/dist/js/bootstrap.min.js', 'resources/assets/js/shared')

            // Copy JS vendors from /vendor/bower_components to public directory.
            .copy('vendor/bower_components/select2/select2.full.min.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/datepicker/bootstrap-datepicker.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/input-mask/inputmask.extensions.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/input-mask/jquery.inputmask.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/input-mask/inputmask.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/maskmoney/jquery.maskMoney.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/datatables/jquery.dataTables.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/datatables/dataTables.bootstrap.js', 'resources/assets/js/shared')
            .copy('vendor/bower_components/colorpicker/bootstrap-colorpicker.min.js', 'resources/assets/js/shared')

            // Copy CSS vendors from /vendor/bower_components to public directory.
            .copy('vendor/bower_components/select2/select2.min.css', 'resources/assets/css/shared')
            .copy('vendor/bower_components/datepicker/datepicker3.css', 'resources/assets/css/shared')
            .copy('vendor/bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css', 'resources/assets/css/shared')
            .copy('vendor/bower_components/datatables/jquery.dataTables.css', 'resources/assets/css/shared')
            .copy('vendor/bower_components/datatables/dataTables.bootstrap.css', 'resources/assets/css/shared')
            .copy('vendor/bower_components/datatables/images/', 'public/css/plugin/images')
            .copy('vendor/bower_components/colorpicker/bootstrap-colorpicker.min.css', 'resources/assets/css/shared')

            .sass([// Process front-end stylesheets
                'frontend/main.scss'
            ], 'resources/assets/css/frontend/main.css')
            .sass([// Process front-end stylesheets
                'frontend/2017/website.scss'
            ], 'public/css/website-2017.css')
            .styles([// Combine pre-processed CSS files
                'frontend/bootstrap.min.css',
                'frontend/main.css',
                'frontend/bootstrap-theme.min.css',
                'frontend/owl.carousel.css',
                'frontend/owl.theme.css',
                'frontend/dlmenu.css',
                'frontend/style.css',
                'frontend/fullcalendar.min.css'

            ], 'public/css/frontend.css')
            .styles([
                'frontend/bootstrap.min.css',
                'frontend/main.css',
                'frontend/magnific-popup.css',
                'frontend/owl.carousel.css',
                'frontend/classroom-style.css',
                'frontend/classroom-skin.css',
                'frontend/jquery.bootstrap-touchspin.css',
                'frontend/jquery-comments.css',
                'frontend/fullcalendar.min.css'
            ], 'public/css/classroom.css')
            .scripts([// Combine front-end scripts

                'frontend/shared/modernizr.js',
                'shared/bootstrap.min.js',
                'shared/inputmask.js',
                'shared/jquery.inputmask.js',
                'shared/inputmask.extensions.js',
                'shared/jquery.maskMoney.js',
                'shared.js',
                'plugins.js',
                'frontend/shared/notification.js',
                'frontend/frontend/jquery.dlmenu.js',
                'frontend/shared/owl.carousel.min.js',
                'frontend/frontend/jquery.easing.min.js',
                'shared/autocomplete.js',
                'frontend/frontend/jquery.magnific-popup.min.js',
                'frontend/frontend/jquery.sticky-kit.min.js',
                'frontend/frontend/jquery-easy-ticker.min.js',
                'frontend/frontend/main.js',
                'frontend/frontend/switcher.js',
                'frontend/frontend/scroll/scroll.js',
                'frontend/frontend/export-notes/print.js',
                'frontend/frontend/carousel-banner/carousel.js',
                'frontend/classroom/fullcalendar/lib/moment.min.js',
                'frontend/classroom/fullcalendar/locale-all.js',
                'frontend/classroom/fullcalendar/fullcalendar.js',
            ], 'public/js/frontend.js')
            .scripts([
                'shared.js',
                'plugins.js',
                'frontend/shared/notification.js',
                'frontend/shared/modernizr.js',
                'frontend/shared/jquery-ui-1.10.4.custom.js',
                'frontend/shared/jquery.ui.touch-punch.js',
                'frontend/classroom/jquery.browser.mobile.js',
                'frontend/frontend/jquery-placeholder.js',
                'frontend/shared/jquery.flexslider-min.js',
                'frontend/shared/nanoscroller.js',
                'frontend/shared/jquery.appear.js',
                'frontend/classroom/jquery-comments.min.js',
                'frontend/shared/bootstrap-fileupload.min.js',
                'frontend/shared/owl.carousel.min.js',
                'frontend/shared/jstree.js',
                'frontend/shared/theme.js',
                'frontend/classroom/classroom.js',
                'frontend/classroom/rating.js',
                'frontend/shared/theme.init.js',
                'frontend/classroom/examples.treeview.js',
                'frontend/classroom/jquery.bootstrap-touchspin.js',
                'frontend/exam/Chart.min.js',
                'frontend/exam/charts.js',
                'frontend/exam/exam.js',
                'frontend/classroom/error.js',
                'frontend/counterup/jquery.counterup.min.js',
                'frontend/counterup/jquery.waypoints.min.js',
                'frontend/frontend/scroll/scroll.js',
                'frontend/frontend/export-notes/print.js',
                'frontend/classroom/fullcalendar/lib/moment.min.js',
                'frontend/classroom/fullcalendar/fullcalendar.js',
                'frontend/classroom/fullcalendar/locale-all.js',
                'frontend/classroom/workshop.js'
            ], 'public/js/classroom.js'
                    )
            .scripts([
                'frontend/frontend/pagseguro-setup.js'
            ], 'public/js/pagseguro-setup.js')

            .sass([// Process back-end stylesheets
                'backend/main.scss',
                'backend/skin.scss',
            ], 'resources/assets/css/backend/main.css')
            .styles([// Combine pre-processed CSS files
                'backend/main.css',
            ], 'public/css/backend.css')
            .scripts([// Combine back-end scripts
                'shared.js',
                'plugins.js',
                'backend/main.js',
                'backend/courses.js',
                'backend/coupons.js',
                'backend/myworkshoptutor.js',
                'backend/Chart.min.js',
                'backend/charts.js',
                'backend/myworkshopevaluation/edit_tutor_activity.js',
                'backend/questions/video-preview-content.js',
                'backend/webinars/index.js'
            ], 'public/js/backend.js')

            // Apply version control
            .version([
                "public/css/frontend.css",
                "public/js/frontend.js",
                "public/js/classroom.js",
                "public/css/backend.css",
                "public/js/backend.js",
                "public/css/classroom.css",
                "public/css/website-2017.css"
            ]);
});

/**
 * Uncomment for LESS version
 */
/*elixir(function(mix) {
 mix
 // Copy webfont files from /vendor directories to /public directory.
 .copy('vendor/fortawesome/font-awesome/fonts', 'public/build/fonts/font-awesome')
 .copy('vendor/twbs/bootstrap/fonts', 'public/build/fonts/bootstrap')
 .copy('vendor/twbs/bootstrap/dist/js/bootstrap.min.js', 'public/js/vendor')
 
 .less([ // Process front-end stylesheets
 'frontend/main.less'
 ], 'resources/assets/css/frontend/main.css')
 .styles([  // Combine pre-processed CSS files
 'frontend/main.css'
 ], 'public/css/frontend.css')
 .scripts([ // Combine front-end scripts
 'plugins.js',
 'frontend/main.js'
 ], 'public/js/frontend.js')
 
 .less([ // Process back-end stylesheets
 'backend/AdminLTE.less'
 ], 'resources/assets/css/backend/main.css')
 .styles([ // Combine pre-processed CSS files
 'backend/main.css'
 ], 'public/css/backend.css')
 .scripts([ // Combine back-end scripts
 'plugins.js',
 'backend/main.js'
 ], 'public/js/backend.js')
 
 // Apply version control
 .version(["public/css/frontend.css", "public/js/frontend.js", "public/css/backend.css", "public/js/backend.js"]);
 });*/
