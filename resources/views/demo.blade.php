<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo File Manager</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/theanh/laravel-filemanager/images/folder.png') }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">
    <h1 class="page-header">Integration Demo Page</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>CKEditor</h2>
            <textarea name="ce" class="form-control"></textarea>
        </div>
        <div class="col-md-6">
            <h2>TinyMCE</h2>
            <textarea name="tm" class="form-control"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Summernote</h2>
            <textarea id="summernote-editor" name="content"></textarea>
        </div>
        <div class="col-md-6">
            <h2>Standalone Image Button</h2>
            <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Choose
                    </a>
                  </span>
                <input id="thumbnail" class="form-control" type="text" name="filepath">
            </div>
            <div id="holder"></div>

            <h2>Standalone File Button</h2>
            <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm2" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Choose
                    </a>
                  </span>
                <input id="thumbnail2" class="form-control" type="text" name="filepath">
            </div>

            <h2>Standalone Class Button</h2>
            <div class="input-group">
                  <span class="input-group-btn">
                    <a data-input="thumbnail3" data-preview="holder3" class="btn btn-primary file-manager" data-name="name3">
                      <i class="fa fa-picture-o"></i> Choose
                    </a>
                  </span>
                <div id="name3"></div>
                <input id="thumbnail3" class="form-control" type="text" name="filepath">
                <div id="holder3"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Embed file manager</h2>
            <iframe src="/file-manager" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    var route_prefix = "/file-manager";
</script>

<!-- CKEditor init -->
<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
<script>
    $('textarea[name=ce]').ckeditor({
        height: 100,
        filebrowserImageBrowseUrl: route_prefix + '?type=image',
        filebrowserImageUploadUrl: route_prefix + '/upload?type=image&_token={{csrf_token()}}',
        filebrowserBrowseUrl: route_prefix + '?type=file',
        filebrowserUploadUrl: route_prefix + '/upload?type=file&_token={{csrf_token()}}'
    });
</script>

<!-- TinyMCE init -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    var editor_config = {
        path_absolute: "",
        selector: "textarea[name=tm]",
        plugins: [
            "link image"
        ],
        relative_urls: false,
        height: 129,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=image";
            }
            else {
                cmsURL = cmsURL + "&type=file";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };

    tinymce.init(editor_config);
</script>
<script>
    var fileManager = {
        prefix: "{{ config('file-manager.route_prefix') }}",
    };
</script>
<script src="{{ asset('vendor/theanh/laravel-filemanager/js/lfm.js') }}"></script>
<script>
    $('#lfm').filemanager('image', {
        'input': 'thumbnail',
        'preview': 'holder',
    });

    $('#lfm2').filemanager('file', {
        'input': 'thumbnail2',
    });
</script>

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
    $(document).ready(function () {
        $('#summernote').summernote();
    });
</script>
<script>
    $(document).ready(function () {

        // Define function to open filemanager window
        var lfm = function (options, cb) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/file-manager';
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
            window.SetUrl = cb;
        };

        // Define LFM summernote button
        var LFMButton = function (context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="note-icon-picture"></i> ',
                tooltip: 'Insert image with filemanager',
                click: function () {

                    lfm({type: 'image', prefix: '/file-manager'}, function (url, path) {
                        context.invoke('insertImage', url);
                    });

                }
            });
            return button.render();
        };

        // Initialize summernote with LFM button in the popover button group
        // Please note that you can add this button to any other button group you'd like
        $('#summernote-editor').summernote({
            toolbar: [
                ['popovers', ['lfm']],
            ],
            buttons: {
                lfm: LFMButton
            }
        })
    });
</script>
</body>
</html>
