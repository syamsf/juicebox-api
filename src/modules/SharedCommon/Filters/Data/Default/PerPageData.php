<?php

namespace Modules\SharedCommon\Filters\Data\Default;

use Illuminate\Http\Request;

class PerPageData {
    public function __construct(
        public readonly ?int $perPage = null
    ) {
    }

    public static function make(int $perPage): self {
        return new self($perPage);
    }

    public static function default(): self {
        return new self();
    }

    public static function fromRequest(Request $request): self {
        $perPage = $request->query("per_page");
        $perPage = empty($perPage) || empty(intval($perPage)) ? 15 : intval($perPage);

        return self::make($perPage);
    }
}
