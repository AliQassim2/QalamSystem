<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:0,1,2',
            'password' => 'required|string|min:8|confirmed',
            'state' => 'required|boolean',
            'school_id' => 'required|integer'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string'   => 'الاسم يجب ان يكون نص',
            'name.max'      => 'الاسم طويل جدا',

            'username.required' => 'اسم المستخدم مطلوب',
            'username.string'   => 'اسم المستخدم يجب ان يكون نص',
            'username.max'      => 'اسم المستخدم طويل جدا',
            'username.regex'    => 'اسم المستخدم يجب أن يحتوي فقط على حروف وأرقام وشرطة سفلية',
            'username.unique'   => 'اسم المستخدم مستخدم بالفعل',

            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email'    => 'البريد الالكتروني غير صحيح',
            'email.max'      => 'البريد الالكتروني طويل جدا',
            'email.unique'   => 'البريد الالكتروني مستخدم بالفعل',

            'phone.string' => 'رقم الهاتف يجب ان يكون نص',
            'phone.max'    => 'رقم الهاتف طويل جدا',

            'role.required' => 'الدور مطلوب',
            'role.in'       => 'الدور يجب أن يكون: 0 أو 1 أو 2',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.string'   => 'كلمة المرور يجب ان تكون نص',
            'password.min'      => 'كلمة المرور يجب ان تكون 8 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',

            'state.required' => 'الحالة مطلوبة',
            'state.boolean'  => 'الحالة يجب أن تكون true أو false',

            'school_id.required' => 'المدرسة مطلوبة',
            'school_id.integer'  => 'المدرسة يجب أن تكون رقم',
        ];
    }
}
