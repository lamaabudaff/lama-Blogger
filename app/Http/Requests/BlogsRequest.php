<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'text'=>'required',
            'image'=>'',
            'author_id'=>'required|exists:users,id',
            'categories'=>'required|array|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'required'=>'حقل :attribute مطلوب',
            'title.max'=>'هذا الحقل يجب أن يكون أقل من 10 أحرف',
            'author_id.exists'=>'هذا المؤلف غير موجود'
        ];
    }

    public function attributes()
    {
        return [
            'title'=>'العنوان',
            'text'=>'التفاصيل',
            'image'=>'الصورة',
        ];
    }
}
