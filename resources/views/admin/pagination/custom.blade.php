@if ($paginator->hasPages())

    <?php
    $items_count = 3;
    $show_first_item = false;
    $show_last_item = false;
    
    $limit_start = 1;
    $limit_end = 1;
    if (count($elements[0]) > $items_count * 2) {
        $limit_start = $paginator->currentPage() - 1;
        $limit_end = $limit_start + 2;
    }
    
    if ($paginator->currentPage() >= $items_count) {
        $show_first_item = true;
    }
    if ($paginator->lastPage() > $paginator->currentPage() + 1) {
        $show_last_item = true;
    }
    ?>

    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            <p class="small text-muted">
                Showing
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                to
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                of
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                results
            </p>
        </div>

        <div>
            <ul class="pagination pagination-rounded">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <a href="#" class="page-link">←</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">→</a>
                    </li>
                @else
                    <li class="page-item">
                        <a href="#" class="page-link">→</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
