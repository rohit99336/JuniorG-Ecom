<div class="pagination justify-content-center mt-100">
    <nav>
        <ul class="pagination m-0 d-flex align-items-center">
            <!-- Previous Page Link -->
            <li class="item @if (!$paginator->onFirstPage()) enabled @else disabled @endif">
                <a class="link" href="{{ $paginator->previousPageUrl() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a>
            </li>

            <!-- Pagination Links -->
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="item @if ($paginator->currentPage() == $i) active @endif">
                    <a class="link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Next Page Link -->
            <li class="item @if ($paginator->hasMorePages()) enabled @else disabled @endif">
                <a class="link" href="{{ $paginator->nextPageUrl() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
        </ul>
    </nav>
</div>
