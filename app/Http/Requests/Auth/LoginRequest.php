<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('phone')) {
            $this->merge([
                'phone' => $this->normalizePhoneNumber($this->phone),
            ]);
        }
    }

    /**
     * Normalize the phone number by adding country code if missing.
     *
     * @param  string|null  $phoneNumber
     * @return string|null
     */
    protected function normalizePhoneNumber(?string $phoneNumber): ?string
    {
        if ($phoneNumber === null) {
            return null;
        }

        $normalizedPhone = preg_replace('/\D/', '', $phoneNumber);

        if (substr($normalizedPhone, 0, 1) === '0') {
            return '+38' . $normalizedPhone;
        } elseif (!str_starts_with($normalizedPhone, '380')) {
            return '+380' . $normalizedPhone;
        }

        return '+' . $normalizedPhone;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login_method' => ['required', 'string', 'in:phone,email,name'],
            'phone' => ['required_if:login_method,phone', 'nullable', 'string'],
            'email' => ['required_if:login_method,email', 'nullable', 'string', 'email'],
            'name' => ['required_if:login_method,name', 'nullable', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginMethod = $this->input('login_method');
        $credentials['password'] = $this->input('password');

        if ($loginMethod === 'email') {
            $credentials['email'] = $this->input('email');
        } elseif ($loginMethod === 'phone') {
            $credentials['phone'] = $this->input('phone');
        } else {
            $credentials['name'] = $this->input('name');
        }

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login_method')).'|'.$this->ip());
    }
}
