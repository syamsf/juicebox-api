<?php

namespace Modules\SharedCommon\Helpers;

class EnvConfigWriter {
    public static function write(array $variables): array {
        // Example:
        //    $variables = [
        //          "API_PAYMENT_OPENAPI_VA_CLIENT_ID={$clientId}",
        //          "API_PAYMENT_OPENAPI_VA_CLIENT_SECRET={$clientSecret}",
        //    ];
        //    EnvConfigWriter::write($variables);


        return (new self())->writeToEnv($variables);
    }

    public function writeToEnv(array $variables): array {
        if (empty($variables))
            throw new \Exception("variables is required");

        $currentContent = file_get_contents(base_path('.env'));

        foreach ($variables as $variable) {
            $pattern = '/^' . preg_quote(explode('=', $variable)[0], '/') . '=.*/m';

            $currentContent = preg_match($pattern, $currentContent)
                ? preg_replace($pattern, $variable, $currentContent)
                : $currentContent . "\n" . $variable;
        }

        file_put_contents(base_path('.env'), $currentContent);

        return ['status' => 'success', 'message' => '.env variable added successfully'];
    }
}
