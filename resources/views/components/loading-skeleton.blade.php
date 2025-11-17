@props(['type' => 'card', 'count' => 1])

@if($type === 'card')
    @for($i = 0; $i < $count; $i++)
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <div class="skeleton h-6 w-3/4 mb-4 rounded"></div>
        <div class="skeleton h-4 w-full mb-2 rounded"></div>
        <div class="skeleton h-4 w-5/6 mb-2 rounded"></div>
        <div class="skeleton h-4 w-4/6 rounded"></div>
    </div>
    @endfor
@elseif($type === 'table')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="skeleton h-8 w-1/4 mb-4 rounded"></div>
        </div>
        <div class="border-t border-gray-200">
            @for($i = 0; $i < $count; $i++)
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center space-x-4">
                    <div class="skeleton h-10 w-10 rounded-full"></div>
                    <div class="flex-1">
                        <div class="skeleton h-4 w-1/3 mb-2 rounded"></div>
                        <div class="skeleton h-3 w-1/4 rounded"></div>
                    </div>
                    <div class="skeleton h-8 w-20 rounded"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>
@elseif($type === 'text')
    @for($i = 0; $i < $count; $i++)
    <div class="skeleton h-4 w-full mb-2 rounded"></div>
    @endfor
@endif
