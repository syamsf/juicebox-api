<?php

namespace Modules\SharedCommon\Filters\Data\Default;

use Illuminate\Http\Request;
use Modules\SharedCommon\Filters\Enums\DirectionEnum;

class SortByData {
    public function __construct(
        public readonly ?string       $key = null,
        public readonly DirectionEnum $direction = DirectionEnum::ASC,
    ) {
    }

    public static function default(): self {
        return new self();
    }

    public static function createdAt(DirectionEnum $direction = DirectionEnum::ASC): self {
        return new self("created_at", $direction);
    }

    public static function make(string $key, DirectionEnum $direction = DirectionEnum::ASC): self {
        return new self($key, $direction);
    }

    public static function fromRequest(Request $request): self {
        $key = $request->query("sort_by_key");
        $direction = $request->query("sort_by_direction");

        if (empty($key))
            return self::default();

        $directionEnum = empty($direction) || empty(DirectionEnum::tryFrom(strtolower($direction)))
            ? DirectionEnum::ASC
            : DirectionEnum::tryFrom(strtolower($direction));

        return self::make($key, $directionEnum);
    }
}
