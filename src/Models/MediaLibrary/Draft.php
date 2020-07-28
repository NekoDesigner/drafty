<?php

namespace Nekodev\Drafty\Models\MediaLibrary;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Nekodev\Drafty\Models\Draft as DraftModel;

class Draft extends DraftModel implements HasMedia
{
    use InteractsWithMedia;
}
