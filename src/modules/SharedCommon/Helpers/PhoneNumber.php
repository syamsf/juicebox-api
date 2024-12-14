<?php

namespace Modules\SharedCommon\Helpers;

class PhoneNumber {
    public function __construct(
        private string $phoneNumber,
        private string $countryCode = "+62"
    ) {
        [$phoneNumber, $dialCode] = $this->parse($phoneNumber, $countryCode);

        $this->phoneNumber = $phoneNumber;
        $this->countryCode = $dialCode;
    }

    /**
     * @throws \Exception
     */
    public static function fromPhone(?string $phone): self {
        if(empty($phone)) {
            throw new \Exception("Phone number is empty");
        }

        return new self($phone);
    }

    private function parse(string $phone, string $countryCode): array {
        preg_match('/\((.*?)\)\s+(.+)/', $phone, $phoneCountryCode);

        $dialCode = $phoneCountryCode[1] ?? $countryCode;
        $phoneNumber = $phoneCountryCode[2] ?? $phone;

        $phoneNumber  = preg_replace('/[^0-9]/i', '', $phoneNumber);

        if (str_starts_with($phoneNumber, '0')) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        $dialCode = preg_replace('/[^0-9]/i', '', $dialCode);

        if(str_starts_with($phoneNumber, $dialCode)) {
            $phoneNumber = substr($phoneNumber, strlen($dialCode));
        }

        return [$phoneNumber, $dialCode];
    }

    public function formatForWhatsapp(): string {
        return preg_replace('/[^0-9]/i', '', "{$this->countryCode}{$this->phoneNumber}");
    }

    public function formatForDatabase(): string {
        return "(+{$this->countryCode}) {$this->phoneNumber}";
    }

    public function getDialCode(bool $includePlusSign = true): string {
        return $includePlusSign ? "+" . $this->countryCode : $this->countryCode;
    }
}
