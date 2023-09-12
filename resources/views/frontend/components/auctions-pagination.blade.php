@if ($paginator->hasPages())
<ul class="pagination">
    <li>
        @if ($paginator->onFirstPage())
            <a href="#0" disabled><i class="flaticon-left-arrow disabled"></i></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"><i class="flaticon-left-arrow"></i></a>
        @endif
    </li>
    @foreach ($elements as $element)
        @if (is_string($element))
            <li>
                <a href="#0" disabled>{{ $element }}</a>
            </li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li>
                        <a href="{{ $url }}" class="active">{{ $page }}</a>
                    </li>
                @else
                    <li>
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}"><i class="flaticon-right-arrow"></i></a></li>
    @else
        <li><a href="#" disabled><i class="flaticon-right-arrow"></i></a></li>
    @endif
</ul>
@endif
