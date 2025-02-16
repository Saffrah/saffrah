<?php

namespace App\Domains\Auth\Services;

// Repositories
use App\Domains\Auth\Repositories\AuthRepository;
use App\Domains\Company\Repositories\CompanyRepository;
use App\Domains\FileManager\Repositories\FileManagerRepository;
use App\Mail\OtpMail;
// Models
use App\Models\Company;
use App\Models\User;
// Libraries
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    private $auth_repository;
    private $company_repository;
    private $file_manager_repository;

    public function __construct(
        AuthRepository $auth_repository, 
        CompanyRepository $company_repository,
        FileManagerRepository $file_manager_repository
    ) 
    {
        $this->auth_repository         = $auth_repository;
        $this->company_repository      = $company_repository;
        $this->file_manager_repository = $file_manager_repository;
    }

    public function register($request) 
    {
        if($request['user_type'] == 'user') {
            $result = $this->auth_repository->register($request);
            $result['token']    = $result->createToken('User', ['role:user'])->plainTextToken; 
            $result['interest'] = "user_int_00".$result['id'];
        }
        else {
            $result = $this->company_repository->register($request);
            $result['token'] = $result->createToken('Company', ['role:company'])->plainTextToken; 
        }
        
        if($result) {
            return [
                'response_code'    => 200,
                'response_message' => 'registered successfully !', 
                'response_data'    => $result
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'registered failed !', 
            'response_data'    => NULL
        ];
    }

    protected function create_credentials($request, $user) 
    {
        if(Hash::check($request['password'], $user->password)) {
            $type = $user instanceof User ? 'user' : 'company';
            $user->tokens()->delete();
            $user['token']     = $user->createToken($type, ['role:'.$type])->plainTextToken; 
            $user['user_type'] = $type;
            
            if($type == 'company' && $user->email_verified_at == NULL) {
                return [
                    'response_code'    => 403,
                    'response_message' => 'You are not verified yet, please contact the administration !',
                    'response_data'    => $user
                ];
            }
            
            if($type == 'user')
                $user['interest'] = "user_int_00".$user['id'];

            return [
                'response_code'    => 200,
                'response_message' => 'Logged In Successfully',
                'response_data'    => $user
            ];
        }
        else {            
            return [
                'response_code'    => 400,
                'response_message' => 'The email or Password are not correct !',
                'response_data'    => NULL
            ];
        }
    }

    function login($request) 
    {
        $user = User::where('email', $request['email'])->orWhere('phone_number', $request['email'])->first();

        if($user) { 
            $result = $this->create_credentials($request, $user);
        }
        else {
            $user   = Company::where('email', $request['email'])->orWhere('phone_number', $request['email'])->first();
            if($user) {
                $result = $this->create_credentials($request, $user);

                if($result['response_code'] == 403) {
                    $registration_files = $this->file_manager_repository->getAllRegistrationFiles($user->id);
                    if($registration_files->isEmpty()) {
                        $result['response_code']    = 300;
                        $result['response_message'] = 'Please upload the needed Company verification files in order for administration to proceed with your application.';
                    }
                }
            }
            else {
                $result = [
                    'response_code'    => 400,
                    'response_message' => 'These Credentials are not correct !',
                    'response_data'    => NULL
                ];
            }
        }

        return $result;     
    }

    public function forgot_password($request) 
    {
        $user = User::where('email', $request['model_email'])->orWhere('phone_number', $request['model_email'])->first();
        if(!$user)
            $user = Company::where('email', $request['model_email'])->orWhere('phone_number', $request['model_email'])->first();
        
        if(isset($request['otp'])) 
        {
            // Check if OTP is valid
            $cachedOtp = Cache::get('password_reset_otp_' . $request['model_email']);

            if (!$cachedOtp) {
                return [
                    'response_code'    => 400,
                    'response_message' => 'Your OTP Has expired, please try again',
                    'response_data'    => []
                ];
            }

            if ($cachedOtp != $request['otp']) {
                return [
                    'response_code'    => 400,
                    'response_message' => 'Invalid OTP',
                    'response_data'    => []
                ];
            }

            if($user) {
                // Update the user's password
                $user->password = bcrypt($request['password']);
                $user->save();
                
                // Forget OTP from cache
                Cache::forget('password_reset_otp_' . $request['model_email']);
    
                return [
                    'response_code'    => 200,
                    'response_message' => 'Your Password rest successfully',
                    'response_data'    => []
                ];
            }
            else {
                return [
                    'response_code'    => 400,
                    'response_message' => 'Your Password rest Failed !',
                    'response_data'    => []
                ];
            }
        }
        else {
            if($user) {
                // Generate OTP (6 digits)
                $otp = mt_rand(100000, 999999);

                // Store the OTP in the cache for 10 minutes
                Cache::put('password_reset_otp_' . $request['model_email'], $otp, 600);

                // Send the OTP to the user's email
                try {
                    Mail::to($user->email)->send(new OtpMail($otp));
                } catch (\Exception $e) {
                    return [
                        'response_code'    => 500,
                        'response_message' => $e->getMessage(),
                        'response_data'    => []
                    ];
                }
            }

            return [
                'response_code'    => 200,
                'response_message' => 'if You account is in our database then check your email for OTP',
                'response_data'    => []
            ];
        }
        
    }

}
