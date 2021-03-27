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