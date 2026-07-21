@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="flex items-center gap-1.5">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-400 bg-white cursor-not-allowed">
                        Previous
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-100 transition-colors">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-1.5 text-sm text-gray-400">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-medium">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-100 transition-colors">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-100 transition-colors">
                        Next
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-400 bg-white cursor-not-allowed">
                        Next
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
