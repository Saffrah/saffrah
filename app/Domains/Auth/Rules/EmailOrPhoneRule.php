<?php

namespace App\Domains\Auth\Rules;

use App\Models\Company;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailOrPhoneRule implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];
 
    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
 
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type   = '';
        $passed = true;
        $originalValue = $value; // Store original for database lookup

        if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !is_numeric($value)) {
            $type = 'email';
            $fail('It must be a valid email!');
            $passed = false;
        } elseif (is_numeric($value)) {
            // Remove non-digit characters (e.g., "+", "-")
            $value = preg_replace('/\D/', '', $value);

            if (preg_match('/^(?:20)?(1\d{9})$/', $value, $matches)) {
                // Egyptian number: Must be exactly 10 digits after +20 or start with 01
                $value = '0' . $matches[1]; // Ensure format: 01XXXXXXXXX
                $type = 'phone';
            } elseif (preg_match('/^(?:966)?(5\d{8})$/', $value, $matches)) {
                // Saudi number: Must be exactly 9 digits after +966 or start with 05
                $value = '0' . $matches[1]; // Ensure format: 05XXXXXXXX
                $type = 'phone';
            } elseif (preg_match('/^01\d{9}$/', $value)) {
                // Direct Egyptian number (without country code)
                $type = 'phone';
            } elseif (preg_match('/^05\d{8}$/', $value)) {
                // Direct Saudi number (without country code)
                $type = 'phone';
            } else {
                $fail('It must be a valid Egyptian or Saudi phone number!');
                $passed = false;
            }
        }

        if ($passed) {
            if ($type == 'email') {
                $company = Company::where('email', $originalValue)->first();
                $user    = User::where('email', $originalValue)->first();

                if (!$user && !$company) {
                    $fail('This email does not exist!');
                }
            } elseif ($type == 'phone') {
                $company = Company::where('phone_number', $value)->first();
                $user    = User::where('phone_number', $value)->first();

                if (!$user && !$company) {
                    $fail('This phone number does not exist!');
                }
            }
        }
    }


}
