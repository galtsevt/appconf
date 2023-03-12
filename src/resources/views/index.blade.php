@extends(config('admin_settings.extends_layout'))
@section('content')
    <div class="card shadow-sm">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($data as $key => $config)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active':'' }}" id="{{ $key }}" data-bs-toggle="tab"
                            data-bs-target="#{{ $key }}-tab-pane" type="button" role="tab"
                            aria-controls="{{ $key }}-tab-pane"
                            aria-selected="true">{{ $config['name'] }}
                    </button>
                </li>
            @endforeach
        </ul>
        <form action="{{ route('admin.settings.save') }}" method="POST">
            @csrf
            <div class="m-2 tab-content" id="myTabContent">
                @foreach($data as $key => $config)
                    <div class="tab-pane fade {{ $loop->first ? 'show active':'' }}" id="{{ $key }}-tab-pane"
                         role="tabpanel" aria-labelledby="{{ $key }}-tab" tabindex="0">
                        @foreach($config['data'] as $name => $item)
                            @if(isset($item['type']) && $item['type'] == 'editor')
                                <x-form::editor name="{{ $name }}" labelName="{{ $item['name'] }}"
                                                value="{!!  settings($name) !!}" class="{{ $item['class'] ?? null }}"
                                                id="{{ $item['id'] ?? null }}"
                                                placeholder="{{ $item['placeholder'] }}"/>
                            @elseif(isset($item['type']) && $item['type'] == 'textarea')
                                <x-form::textarea name="{{ $name }}" labelName="{{ $item['name'] }}"
                                                  value="{!!  settings($name) !!}"
                                                  placeholder="{{ $item['placeholder'] }}"/>
                            @elseif(isset($item['type']) && $item['type'] == 'select')
                                <x-form::select name="{{ $name }}" labelName="{{ $item['name'] }}"
                                                selected="{!!  settings($name) !!}"
                                                :data="$item['data']()"/>
                            @else
                                <x-form::input type="text" name="{{ $name }}" labelName="{{ $item['name'] }}"
                                               value="{!! settings($name) !!}"
                                               placeholder="{{ $item['placeholder'] }}"/>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </div>

        </form>


        {{--        <x-form::input type="text" name="test" labelName="input" value="123" placeholder="test"/>
                <x-form::textarea name="test" labelName="textarea" value="123" placeholder="test"/>
                @php($array = [
                'test',
                'test2',
                'test3',
                ])
                <x-form::select name="test" labelName="select" selected="1" :data="$array"/>
                <x-form::input type="text" name="test" labelName="input" value="123" placeholder="test"/>--}}
    </div>
@endsection
