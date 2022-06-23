<?php

namespace App\Gentree\RawProviders;

use App\Gentree\Dto\FormattedItem;
use App\Gentree\Dto\RawItem;

/**
 * Interface for providing input data as FormattedItem array ( @see FormattedItem )
 */
interface RawProviderInterface
{
    /**
     * @return RawItem[]
     */
    public function provideRaw(): array;
}