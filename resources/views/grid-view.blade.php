@if((sizeof($files) > 0) || (sizeof($directories) > 0))

    <div class="row">
        @foreach($items as $item)
            <?php
            /**
             * @var stdClass $item
             * */
            ?>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 img-row">
                {{--<a href="" class="file-close"><i class="fa fa-times-circle"></i></a>--}}
                <div class="square clickable {{ $item->is_file ? '' : 'folder-item' }}" data-id="{{ $item->id }}"
                     @if($item->is_file) onclick="useFile('{{ $item->url }}', '{{ $item->path }}', '{{ $item->name }}')"
                        @endif >
                    @if($item->thumb)
                        <img src="{{ $item->thumb }}">
                    @else
                        <i class="fa {{ $item->icon }} fa-5x"></i>
                    @endif
                </div>

                <div class="caption text-center">
                    <div class="btn-group">
                        <nav class="navbar navbar-expand-sm border" id="nav">
                            <div class="collapse navbar-collapse" id="nav-buttons">
                                <ul class="nav navbar-nav">
                                    <li class="nav-item dropdown">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 col-xs-8 col-lg-8">
                                                <button type="button" data-id="{{ $item->path }}" class="item_name btn btn-default btn-xs{{ $item->is_file ? '' : 'folder-item'}}" @if($item->is_file) onclick="useFile('{{ $item->url }}', '{{ $item->path }}', '{{ $item->name }}')" @endif >
                                                    {{ $item->name }}
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 m-auto">

                                                <button class="btn btn-default dropdown-toggle btn-xs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="caret"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-right">

                                                    <li>
                                                        <a href="javascript:rename('{{ $item->id }}', '{{ $item->name }}', {{ $item->is_file == 1 ? 1 : 0 }})" class="dropdown-item"><i class="fa fa-edit fa-fw"></i> {{ trans('filemanager::file-manager.menu-rename') }}
                                                        </a></li>

                                                    @if($item->is_file)
                                                        <li>
                                                            <a href="javascript:download('{{ $item->id }}')" class="dropdown-item"><i class="fa fa-download fa-fw"></i> {{ trans('filemanager::file-manager.menu-download') }}
                                                            </a></li>

                                                        <li class="divider"></li>

                                                        @if($item->thumb)
                                                            <li>
                                                                <a href="javascript:fileView('{{ $item->url }}', '{{ $item->updated }}')" class="dropdown-item"><i class="fa fa-image fa-fw"></i> {{ trans('filemanager::file-manager.menu-view') }}
                                                                </a></li>

                                                            {{--<li><a href="javascript:resizeImage('{{ $item->name }}')"><i class="fa fa-arrows fa-fw"></i> {{ trans('filemanager::file-manager.menu-resize') }}</a></li>--}}

                                                            {{--<li><a href="javascript:cropImage('{{ $item->name }}')"><i class="fa fa-crop fa-fw"></i> {{ trans('filemanager::file-manager.menu-crop') }}</a></li>--}}
                                                            <li class="divider"></li>
                                                        @endif

                                                    @endif

                                                    <li>
                                                        <a href="javascript:trash('{{ $item->id }}', {{ $item->is_file ? 1 : 0 }})" class="dropdown-item"><i class="fa fa-trash
                      fa-fw"></i> {{ trans('filemanager::file-manager.menu-delete') }}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>

            </div>
        @endforeach

    </div>

@else
    <p>{{ trans('filemanager::file-manager.message-empty') }}</p>
@endif
