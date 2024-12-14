<?php declare(strict_types = 1);

namespace Modules\SharedCommon\Helpers;

use Illuminate\Support\Facades\DB;

class TransactionHandler {
    public function run(\Closure $callback) {
        DB::beginTransaction();

        try {
            $result = $callback();
            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function staticRun(\Closure $callback) {
        return self::staticRun($callback);
    }
}
