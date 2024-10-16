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

        if(is_numeric($value) && ! preg_match('/^\d{11}$/', $value)) {
            $type = 'phone';
            $fail('it must be a valid Phone number !');
            $passed = false;
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
