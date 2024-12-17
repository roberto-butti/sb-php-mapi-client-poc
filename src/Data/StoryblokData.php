<?php

namespace Roberto\Storyblok\Mapi\Data;

use ArrayAccess;
use Countable;
use Iterator;
use Roberto\Storyblok\Mapi\StoryblokResponse;

class StoryblokData implements Iterator, ArrayAccess, Countable
{
    use IterableDataTrait;

    public function __construct(private array $data) {}

    public static function make(array $data = []): StoryblokData
    {
        return new StoryblokData($data);
    }

    public static function makeFromResponse(StoryblokResponse $response): StoryblokData
    {
        return new StoryblokData($response->toArray());
    }

    public function get(mixed $key, mixed $defaultValue = null, string $charNestedKey = "."): mixed
    {
        if (is_string($key)) {
            $keyString = strval($key);
            if (str_contains($keyString, $charNestedKey)) {
                $nestedValue = $this->data;
                foreach (explode($charNestedKey, $keyString) as $nestedKey) {
                    if (is_array($nestedValue) && array_key_exists($nestedKey, $nestedValue)) {
                        $nestedValue = $nestedValue[$nestedKey];
                    } elseif ($nestedValue instanceof StoryblokData) {
                        $nestedValue = $nestedValue->get($nestedKey);
                    } else {
                        return $defaultValue;
                    }
                }
                return $this->returnData($nestedValue);
            }
        }
        return $this->returnData($this->data[$key]) ?? $defaultValue;

    }


    private function returnData(mixed $value): null|int|float|string|bool|\Roberto\Storyblok\Mapi\Data\StoryblokData
    {
        if (is_null($value)) {

            return null;
        }
        if (is_scalar($value)) {
            return $value;
            //return self::make([$value]);
        }
        if (is_array($value)) {


            return self::make($value);
        }
        if ($value instanceof StoryblokData) {
            return $value;
        }
        return StoryblokData::make([]);
    }


    public function getData(mixed $key, mixed $defaultValue = null, string $charNestedKey = "."): self|string|null
    {
        $value = $this->get($key, $defaultValue, $charNestedKey);
        return $this->returnData($value);

    }
    public function count(): int
    {
        return count($this->data);
    }
}