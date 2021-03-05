<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'gender', 'type', 'phone'
    ];

    public $fields = [];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->fields = [
            'created_at' => 'Дата регистрации',
            'name' => 'Имя абитуриента',
            'type' => [
                'title' => 'Поступление',
                'handler' => function($value) { return "После {$value}-го класса"; },
                'values' => ['' => '', '9' => 9, 11 => '11'],
            ],
            'gender' => [
                'title' => 'Пол',
                'handler' => function($value) { return $value=='m' ? 'М' : 'Ж'; },
                'values' => ['' => '', 'm' => 'М', 'f' => 'Ж']
            ],
            'phone' => 'Контактный телефон',
        ];
    }

    public function genderLetter(){
        return $this->gender == 'm' ? 'M' : 'Ж';
    }

    static public function getFieldsSchema(){
        $profile = new static();
        return $profile->fields;
    }

    public function fieldTitle($fieldName){
        if (empty($this->fields[$fieldName])){
            return $fieldName;
        }
        if (is_string($this->fields[$fieldName])) {
            return $this->fields[$fieldName];
        }
        return $this->fields[$fieldName]['title'];
    }

    public function fieldValue($fieldName){
        if (empty($this->fields[$fieldName])){
            return null;
        }
        $value = $this->{$fieldName};
        if (is_string($this->fields[$fieldName])) {
            return $value;
        }
        return $this->fields[$fieldName]['handler']($value);
    }

    static public function fieldFilter($fieldName){
        $schema = static::getFieldsSchema();

        if (empty($schema[$fieldName])){
            return '';
        }

        $fieldType = 'string';
        if (!is_string($schema[$fieldName]) && !empty($schema[$fieldName]['values'])) {
            $fieldType = 'list';
            $values = $schema[$fieldName]['values'];
        }

        $value = request()->input("f.{$fieldName}", '');

        if ($fieldType == 'string') {
            return '<input type="string" class="form-control form-control-sm" name="f['.$fieldName.']" value="'.$value.'">';
        }

        $html = '<select class="form-control form-control-sm" name="f['.$fieldName.']">';
        foreach($values as $key => $title) {
            $html .= '<option value="'.$key.'"'.($value==$key ? ' selected' : '').'>'.$title.'</option>';
        }
        $html .= '</select>';

        return $html;
    }

}
