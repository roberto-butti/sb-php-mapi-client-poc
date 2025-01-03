<?php

declare(strict_types=1);

namespace Roberto\Storyblok\Mapi\Data;

use Roberto\Storyblok\Mapi\Data\StoryblokData;

class AssetsData extends StoryblokData
{
    #[\Override]
    public function getDataClass(): string
    {
        return AssetData::class;
    }


    /**
     * @param array<mixed> $data
     */
    public static function makeFromResponse(array $data = []): self
    {
        return new self($data["assets"] ?? []);
    }

}
