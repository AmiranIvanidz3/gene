@php
    $start = max($paginator->currentPage() - 2, 1);
    $end = min($start + 4, $paginator->lastPage());
@endphp

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif
            
            @if($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
            @if($start > 2)
                <li class="page-item disabled">
                    <span class="page-link">.</span>
                </li>
            @endif
        @endif

            {{-- Pagination Elements --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($paginator->currentPage() == $i)
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- "Three Dots" Separator --}}
            @if ($end < $paginator->lastPage())
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">.</span></li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() > 1 && $paginator->currentPage() < ($paginator->lastPage() - 2) )
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
