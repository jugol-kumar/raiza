{{--<div class="list-group list-group-flush">--}}
{{--    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)--}}
{{--        <a href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}" class="list-group-item list-group-item-action">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</a>--}}
{{--            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)--}}
{{--                <a href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}" class="list-group-item list-group-item-action">{{ \App\Category::find($second_level_id)->getTranslation('name') }}</a>--}}
{{--            @endforeach--}}
{{--    @endforeach--}}
{{--  </div>--}}


<div class="card-columns p-20px card-columns-count">
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
        <div class="card shadow-none border-0 bg-light">
            <ul class="list-unstyled mb-3">
                <li class="fw-600 border-bottom pb-2 mb-3">
                    <a class="text-reset" href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</a>
                </li>
                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                    <li class="mb-2">
                        <a class="text-reset" href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}">{{ \App\Category::find($second_level_id)->getTranslation('name') }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
