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

- Create a button, input, and image preview holder if you are going to choose images. Add class ``file-manager`` to button choose file. Specify the id to the input and image preview by ``data-input`` and ``data-preview``.
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