## About
Media gallery with CKEditor, TinyMCE and Summernote support. Built on Laravel file system.

### Features
- [x] DB media and media folder
- [x] Chunk upload support
- [x] CKEditor and TinyMCE integration
- [x] Uploading validation
- [x] Cropping and resizing of images
- [x] Add custom support type
- [ ] Multi media select

## Install
- Install package
```
composer require theanh/laravel-filemanager
```

- Publish the package’s config and assets:
```
php artisan vendor:publish --provider="Theanh\FileManager\Providers\FileManagerServiceProvider" --tag=config
php artisan vendor:publish --provider="Theanh\FileManager\Providers\FileManagerServiceProvider" --tag=assets
```
- Migration
```
php artisan migrate
```

- Create symbolic link:
```
php artisan storage:link
```

- Edit routes/web.php
```
Route::group(['prefix' => 'file-manager', 'middleware' => ['web', 'auth']], function (){
    \Theanh\FileManager\Routes::web();
});
```

## Usage
### Editor Integration:
#### CKEditor
```
<textarea id="my-editor" name="content" class="form-control">{!! old('content', 'test editor content') !!}</textarea>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/file-manager?type=image',
    filebrowserImageUploadUrl: '/file-manager/upload?type=image',
    filebrowserBrowseUrl: '/file-manager?type=file',
    filebrowserUploadUrl: '/file-manager/upload?type=file'
  };
</script>
```

- Sample 1 - Replace by ID:
```
<script>
CKEDITOR.replace('my-editor', options);
</script>
```
- Sample 2 - With JQuery Selector:
```
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
$('textarea.my-editor').ckeditor(options);
</script>
```

#### TinyMCE5
```
<script src="/path-to-your-tinymce/tinymce.min.js"></script>
<textarea name="content" class="form-control my-editor">{!! old('content', $content) !!}</textarea>
<script>
  var editor_config = {
    path_absolute : "/",
    selector: 'textarea.my-editor',
    relative_urls: false,
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table directionality",
      "emoticons template paste textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    file_picker_callback : function(callback, value, meta) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
      if (meta.filetype == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.openUrl({
        url : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no",
        onMessage: (api, message) => {
          callback(message.content);
        }
      });
    }
  };

  tinymce.init(editor_config);
</script>
```

#### TinyMCE4
```
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<textarea name="content" class="form-control my-editor">{!! old('content', $content) !!}</textarea>
<script>
  var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
```

### Standalone button
- Import ``lfm.js`` (run public assets if you need).
```
<script>
    var fileManager = {
        prefix: "{{ config('file-manager.route_prefix') }}",
    };
</script>
<script src="{{ asset('vendor/theanh/laravel-filemanager/js/lfm.js') }}"></script>
```

- Create a button, input, and image preview holder if you are going to choose images. Specify the id to the input and image preview by ``data-input`` and ``data-preview``.
```
<div class="input-group">
   <span class="input-group-btn">
     <a data-input="thumbnail" data-preview="holder" class="btn btn-primary file-manager">
       <i class="fa fa-picture-o"></i> Choose
     </a>
   </span>
   <input id="thumbnail" class="form-control" type="text" name="filepath">
 </div>
 <div id="holder"></div>
 ```

### JavaScript integration
```
var lfm = function (options, cb) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/file-manager';
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
            window.SetUrl = cb;
        };
```

And use it like this:
```
lfm({type: 'image', prefix: '/file-manager'}, function (url, path, name) {
    console.log(url, path, name);
});
```

## Credits
[Laravel File Manager](https://github.com/UniSharp/laravel-filemanager)

## License

The Laravel File Manager package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
