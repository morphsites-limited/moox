<?php

declare(strict_types=1);

namespace Moox\Data\Filament\Resources\StaticLanguageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Moox\Core\Traits\Base\BaseInCreatePage;
use Moox\Core\Traits\Simple\SingleSimpleInCreatePage;
use Moox\Data\Filament\Resources\StaticLanguageResource;

class CreateStaticLanguage extends CreateRecord
{
    use BaseInCreatePage, SingleSimpleInCreatePage;

    protected static string $resource = StaticLanguageResource::class;
}
