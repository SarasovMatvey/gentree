<?php

namespace App\Gentree\RawProviders;

use App\Gentree\Dto\RawItem;

interface RawProviderInterface
{
    /**
     * @return RawItem[]
     */
    public function provideRaw(): array;
}