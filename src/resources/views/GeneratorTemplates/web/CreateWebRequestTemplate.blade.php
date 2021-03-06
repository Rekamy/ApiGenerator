<?=
"<?php

namespace " . $context->namespace['web_request'] . ";

use Illuminate\Foundation\Http\FormRequest;
use " . $context->namespace['model'] . "\\" . ucfirst(Str::camel(Str::singular($tablename))) .";

class Create" . ucfirst(Str::camel(Str::singular($tablename))) . "Request extends FormRequest
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
        return " . ucfirst(Str::camel(Str::singular($tablename))) . "::\$rules;
    }
}
"
?>
