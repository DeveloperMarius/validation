<?php declare(strict_types=1);

namespace Somnambulist\Components\Validation\Rules;

use Somnambulist\Components\Validation\Rule;

class StartsWith extends Rule
{

    protected string $message = 'rule.starts_with';
    protected array $fillableParams = ['compare_with'];

    public function check(mixed $value): bool
    {
        $this->assertHasRequiredParameters($this->fillableParams);
        $compare_with = $this->parameter('compare_with');

        if(is_string($value) || is_numeric($value)){
            $value = strval($value);
            return str_starts_with($value, $compare_with);
        }

        if(is_array($value)){
            if($this->isAssociativeArray($value)){
                $first_value = $value[array_key_first($value)];
            }else{
                $first_value = $value[0];
            }
            return $first_value === $compare_with;
        }

        return false;
    }

    private function isAssociativeArray(array $value): bool
    {
        if (array() === $value){
            return false;
        }
        return array_keys($value) !== range(0, count($value) - 1);
    }
}