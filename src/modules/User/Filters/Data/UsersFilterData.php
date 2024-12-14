<?php

namespace Modules\User\Filters\Data;

use Illuminate\Http\Request;
use Modules\SharedCommon\Config\Status;
use Modules\SharedCommon\Filters\Data\BaseFilter;

class UsersFilterData extends BaseFilter {
    public function __construct(
        public readonly array   $globalFilterColumn = [],
        public readonly ?string $globalFilterKeyword = null,
        public readonly ?string $email = null,
        public readonly ?string $name = null,
        public readonly ?string $jobTitle = null,
        public readonly ?Status $status = null,
        public readonly ?string $phoneNumber = null,
    ) {
    }

    public static function fromRequest(Request $request): self {
        $email       = $request->query("email");
        $name        = $request->query("name");

        $globalFilterKeyword = $request->query("global_filter_keyword");
        $globalFilterColumn  = explode(",", $request->query("global_filter_column"));

        return new self(
            globalFilterColumn: $globalFilterColumn,
            globalFilterKeyword: $globalFilterKeyword,
            email: $email,
            name: $name,
        );
    }
}
