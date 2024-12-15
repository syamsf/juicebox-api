<?php

namespace Modules\Post\Filters\Data;

use Illuminate\Http\Request;
use Modules\SharedCommon\Filters\Data\BaseFilter;

class PostFilterData extends BaseFilter {
    public function __construct(
        public readonly array   $globalFilterColumn = [],
        public readonly ?string $globalFilterKeyword = null,
        public readonly ?string $title = null,
        public readonly ?string $content = null,
    ) {
    }

    public static function fromRequest(Request $request): self {
        $title   = $request->query("title");
        $content = $request->query("content");

        $globalFilterKeyword = $request->query("global_filter_keyword");
        $globalFilterColumn  = explode(",", $request->query("global_filter_column"));

        return new self(
            globalFilterColumn: $globalFilterColumn,
            globalFilterKeyword: $globalFilterKeyword,
            title: $title,
            content: $content,
        );
    }
}
