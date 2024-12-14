<?php

namespace Modules\SharedCommon\Filters\Data\Default;

use Illuminate\Http\Request;

class DistinctByData {
    public function __construct(
        public readonly ?string $key = null,
    ) {
    }

    public static function default(): self {
        return new self();
    }

    public static function make(?string $key): self {
        return new self($key);
    }

    public static function fromRequest(Request $request): self {
        $key = $request->query("distinct_by");

        return empty($key) ? self::default() : self::make($key);
    }
}
