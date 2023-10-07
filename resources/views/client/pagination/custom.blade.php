
@if ($paginator->hasPages())
<div class="pagination-wrapper">
    <div class="col-sm-6 text-left page-link">
        <ul class="pagination">
            @if (!$paginator->onFirstPage())
            <li><a href="{{ $paginator->previousPageUrl() }}"><</a></li>
            @endif

            @foreach ($elements as $element)
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a href="{{$url}}">{{ $page }}</a></li>
                    @else
                        <li><a href="{{$url}}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endforeach

            @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">></a></li>
            @endif
        </ul>
    </div>
    <div class="col-sm-6 text-right page-result">Showing 
        <span class="fw-semibold">{{$paginator->firstItem()}}</span> to 
        <span class="fw-semibold">{{$paginator->lastItem()}}</span> of 
        <span class="fw-semibold">{{$paginator->total()}}</span></div>
</div>
@endif