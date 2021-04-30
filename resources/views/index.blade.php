<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE"/>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('filemanager::file-manager.title-page') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/tadcms/laravel-filemanager/images/folder.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tadcms/laravel-filemanager/css/file-manager.css') }}">
</head>
<body>
<div class="container-fluid" id="wrapper">
    @php
        $embed = (bool) request()->get('embed', false);
    @endphp

    @if(!$embed)
        <div class="card bg-primary text-white p-0 rounded-0">
            <div class="card-header">
                <h5 class="card-title text-uppercase">{{ trans('filemanager::file-manager.title-panel') }}</h5>
            </div>
        </div>
    @endif

    <div class="row mt-3">

        <div class="col-sm-12 col-xs-12" id="main">
            <nav class="navbar navbar-expand-sm border" id="nav">
                <div class="navbar-header">
                    <a class="navbar-brand clickable text-primary d-none" id="to-previous">
                        <i class="fa fa-arrow-left"></i>
                        <span class="hidden-xs">{{ trans('filemanager::file-manager.nav-back') }}</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="nav-buttons">
                    <ul class="nav navbar-nav ml-auto">
                        {{--<li>
                          <a class="clickable" id="thumbnail-display">
                            <i class="fa fa-th-large"></i>
                            <span>{{ trans('filemanager::file-manager.nav-thumbnails') }}</span>
                          </a>
                        </li>
                        <li>
                          <a class="clickable" id="list-display">
                            <i class="fa fa-list"></i>
                            <span>{{ trans('filemanager::file-manager.nav-list') }}</span>
                          </a>
                        </li>--}}
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                {{ trans('filemanager::file-manager.nav-sort') }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="#" class="dropdown-item" id="list-sort-alphabetic">
                                        <i class="fa fa-sort-alpha-asc"></i> {{ trans('filemanager::file-manager.nav-sort-alphabetic') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" id="list-sort-time">
                                        <i class="fa fa-sort-amount-asc"></i> {{ trans('filemanager::file-manager.nav-sort-time') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="visible-xs d-none" id="current_dir" style="padding: 5px 15px;background-color: #f8f8f8;color: #5e5e5e;"></div>

            <div id="alerts"></div>

            <div id="content" class="mt-2"></div>
        </div>

        <ul id="fab">
            <li>
                <a href="javascript:void(0)"></a>
                <ul class="hide">
                    <li>
                        <a href="javascript:void(0)" id="add-folder"
                           data-mfb-label="{{ trans('filemanager::file-manager.nav-new') }}">
                            <i class="fa fa-folder"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" id="upload"
                           data-mfb-label="{{ trans('filemanager::file-manager.nav-upload') }}">
                            <i class="fa fa-upload"></i>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ trans('filemanager::file-manager.title-upload') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('file-manager.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data' class="dropzone">

                    <div class="form-group" id="attachment">
                        <div class="controls text-center">
                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-primary rounded-0" id="upload-button"><i class="fa
                                fa-cloud-upload"></i> {{ trans('filemanager::file-manager.message-choose') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type='hidden' name='working_dir' id='working_dir'>
                    <input type='hidden' name='previous_dir' id='previous_dir'>
                    <input type='hidden' name='type' id='type' value='{{ request("type", 'image') }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">{{ trans('filemanager::file-manager.btn-close') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addFolderModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('filemanager::file-manager.add-folder')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>@lang('filemanager::file-manager.folder-name')</label>
                    <input class="form-control" autocomplete="off" type="text" id="folder-name">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="b-add-folder"><i class="fa fa-plus"></i> @lang('filemanager::file-manager.add-folder')</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('filemanager::file-manager.close') }}</button>
            </div>

        </div>
    </div>
</div>

<div id="lfm-loader">
    <img src="{{ asset('vendor/tadcms/laravel-filemanager/images/loader.svg') }}" />
</div>

<script>
    var lfm_route = "{{ route('file-manager.index') }}";
    var lang = JSON.parse('{!! json_encode(trans('filemanager::file-manager')) !!}');
    var _token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('vendor/tadcms/laravel-filemanager/js/file-manager.js') }}"></script>

<script type="text/javascript">
    $.fn.fab = function () {
        var menu = this;
        menu.addClass('mfb-component--br mfb-zoomin')
            .attr('data-mfb-toggle', 'hover');
        var wrapper = menu.children('li');
        wrapper.addClass('mfb-component__wrap');
        var parent_button = wrapper.children('a');
        parent_button.addClass('mfb-component__button--main')
            .append($('<i>').addClass('mfb-component__main-icon--resting fa fa-plus'))
            .append($('<i>').addClass('mfb-component__main-icon--active fa fa-times'));
        var children_list = wrapper.children('ul');
        children_list.find('a').addClass('mfb-component__button--child');
        children_list.find('i').addClass('mfb-component__child-icon');
        children_list.addClass('mfb-component__list').removeClass('hide');
    };

    $('#fab').fab({
        buttons: [
            {
                icon: 'fa fa-folder',
                label: "{{ trans('filemanager::file-manager.nav-new') }}",
                attrs: {id: 'add-folder'}
            },
            {
                icon: 'fa fa-upload',
                label: "{{ trans('filemanager::file-manager.nav-upload') }}",
                attrs: {id: 'upload'}
            }
        ]
    });

    Dropzone.options.uploadForm = {
        paramName: "upload",
        uploadMultiple: false,
        parallelUploads: 5,
        clickable: '#upload-button',
        timeout: 0,
        dictDefaultMessage: '{{ trans('filemanager::file-manager.drag-and-drop-files') }}',
        init: function () {
            var _this = this; // For the closure
            this.on('success', function (file, response) {
                var obj = JSON.parse(file.xhr.response);
                if (obj.status == true) {
                    refreshFoldersAndItems('OK');
                } else {
                    this.defaultOptions.error(file, obj.data.message);
                }
            });
        },
        chunking: true,
        forceChunking: true,
        chunkSize: 1048576,
        retryChunks: true,   // retry chunks on failure
        retryChunksLimit: 3,
        acceptedFiles: "{{ implode(',', $mimetypes) }}",
        maxFilesize: parseInt('{{ $max_file_size * 1024 * 1024  }}'),
    }
</script>
</body>
</html>
