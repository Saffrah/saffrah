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

        if (! filter_var($value, FILTER_VALIDATE_EMAIL) && ! is_numeric($value)) {
            $type = 'email';
            $fail('it must be a valid email !');
            $passed = false;
        }
        elseif(is_numeric($value)) {
            // Remove Egypt (+20) or Saudi Arabia (+966) country code
            $value = preg_replace('/^(\+?20|0020|\+?966|00966)/', '', $value);

            // Ensure the correct format for Egypt (11 digits) and Saudi Arabia (starting with 05)
            if (preg_match('/^1\d{9}$/', $value)) {
                // Egyptian number (already starts with 01)
                $value = '0' . ltrim($value, '0'); // Ensure single leading 0
            } elseif (preg_match('/^5\d{8}$/', $value)) {
                // Saudi number (starts with 5, add missing 0)
                $value = '0' . $value;
            }

            // Validate the final phone number
            if (preg_match('/^01\d{9}$/', $value) || preg_match('/^05\d{8}$/', $value)) {
                $type = 'phone';
            } else {
                $fail('It must be a valid phone number!');
                $passed = false;
            }
        }

        if($passed) {
            if($type == 'email') {
                $company = Company::where('email', $value)->first();
                $user    = User::where('email', $value)->first();
        
                if(!$user && !$company) {
                    $fail('This email does not Exist !');
                }
            }
            elseif ($type == 'phone') {
                $company = Company::where('phone_number', $value)->first();
                $user    = User::where('phone_number', $value)->first();
        
                if(!$user && !$company) {
                    $fail('This Phone number does not Exist !');
                }
            }
        }
    }
}
