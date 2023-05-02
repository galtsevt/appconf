@extends(config('admin_settings.extends_layout'))
@section('content')
    <div class="card shadow-sm">
        @if(count($formElementContainers) > 1)
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach($formElementContainers as $container)
                    @if($container->isVisible())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active':'' }}" id="{{ $container->getKey() }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#{{ $container->getKey() }}-tab-pane" type="button" role="tab"
                                    aria-controls="{{ $container->getKey() }}-tab-pane"
                                    aria-selected="true">{{ $container->getName() }}
                            </button>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.settings.save', $groupName) }}" method="POST">
            @csrf
            <div class="m-2 tab-content" id="myTabContent">
                @foreach($formElementContainers as $container)
                    @if($container->isVisible())
                        <div class="tab-pane fade {{ $loop->first ? 'show active':'' }}"
                             id="{{ $container->getKey() }}-tab-pane"
                             role="tabpanel" aria-labelledby="{{ $container->getKey() }}-tab" tabindex="0">
                            @foreach($container->getFormElements() as $formElement)
                                {{ $formElement->render() }}
                            @endforeach
                        </div>
                    @endif
                @endforeach
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </div>

        </form>
    </div>
@endsection
