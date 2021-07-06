<?php

namespace App\Http\Requests\Blogs;

use App\DTO\Blogs\BlogDto;
use App\Rules\CheckTranslations;
use App\ValueObjects\Translation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'title' => [
                'required',
                new CheckTranslations(5, 255),
            ],
            'short_description' => [
                'required',
                new CheckTranslations(10, 300),
            ],
            'content' => [
                'required',
                new CheckTranslations(10, 100000),
            ],
            'slug' => [
                'required',
                'max:255',
                Rule::unique('blogs', 'slug')
                    ->ignore($this->route('blog')->id)
            ],
            'cover' => [
                'nullable',
                'image',
                'max:20480', // 20 MB max
                Rule::dimensions()
                    ->maxHeight(4000)
                    ->maxWidth(6000)
            ]
        ];
    }

    public function getDto(): BlogDto
    {
        $translations_to_vo = function (array $translations) {
            return array_map(function ($locale, $value) {
                return new Translation($locale, $value);
            }, array_keys($translations), array_values($translations));
        };

        return new BlogDto([
            'title' => $translations_to_vo($this->get('title')),
            'content' => $translations_to_vo($this->get('content')),
            'short_description' => $translations_to_vo($this->get('short_description')),
            'slug' => $this->get('slug'),
            'cover' => $this->has('cover') ? $this->file('cover') : null
        ]);
    }

}
