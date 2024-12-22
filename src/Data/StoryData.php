<?php

declare(strict_types=1);

namespace Roberto\Storyblok\Mapi\Data;

use Roberto\Storyblok\Mapi\Data\StoryblokData;

class StoryData extends StoryblokData
{
    #[\Override]
    public static function make(array $data = []): self
    {
        return new self($data);
    }

    public function setName($name): void
    {
        $this->set('name', $name);
    }

    public function getName(): string
    {
        return $this->get('name', "");
    }



}