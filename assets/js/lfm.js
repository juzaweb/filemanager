(function($){
    function openFileManager(type, options) {
        type = type || 'file';
        var routePrefix = fileManager.prefix;
        if (options.prefix) {
            routePrefix = options.prefix;
        }

        if (routePrefix[0] != '/') {
            routePrefix = '/' + routePrefix;
        }

        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var w = options.width ? options.width : 800;
        var h = options.height ? options.height : 500;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var systemZoom = width / window.screen.availWidth;
        var left = (width - w) / 2 / systemZoom + dualScreenLeft;
        var top = (height - h) / 2 / systemZoom + dualScreenTop;

        window.open(routePrefix + '?type=' + type, 'File Manager', 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

        window.SetUrl = function (url, path, name) {
            if (options.input) {
                var targetInput = $('#' + options.input);
                targetInput.val(path);
            }

            if (options.preview) {
                var targetPreview = $('#' + options.preview);
                targetPreview.html('<img src="'+ url +'">');
            }

            if (options.name) {
                var targetName = $('#' + options.name);
                targetName.html(name);
            }
        };
    }

    $.fn.filemanager = function(type, options) {
        this.on('click', function(e) {
            openFileManager(type, options);
        });
    };

    $('body').on('click', '.file-manager', function () {
        var type = $(this).data('type') ?? 'image';
        var input = $(this).data('input');
        var preview = $(this).data('preview');
        var name = $(this).data('name');

        openFileManager(type, {
            'type': type,
            'input': input,
            'preview': preview,
            'name': name
        });
    });
})(jQuery);