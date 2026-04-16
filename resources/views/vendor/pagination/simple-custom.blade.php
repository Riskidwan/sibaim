@if ($paginator->hasPages())
    <div class="page-btns">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="page-btn" disabled aria-disabled="true"><span>‹</span></button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-btn" aria-label="@lang('pagination.previous')">‹</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <button class="page-btn" disabled aria-disabled="true"><span>{{ $element }}</span></button>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="page-btn active" aria-current="page"><span>{{ $page }}</span></button>
                    @else
                        <a href="{{ $url }}" class="page-btn"><span>{{ $page }}</span></a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-btn" aria-label="@lang('pagination.next')">›</a>
        @else
            <button class="page-btn" disabled aria-disabled="true"><span>›</span></button>
        @endif
    </div>
@endif
