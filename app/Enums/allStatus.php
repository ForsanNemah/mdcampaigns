<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum allStatus : int implements HasLabel,HasColor
{
    case Active=1;
    case Blocked=0;

    public function getLabel(): ?string
    {
        return match ($this){
            self::Active=>'active',
            self::Blocked=>'blocked',
         };
    }
    public function getColor(): string|array|null
    {
        // TODO: Implement getColor() method.
        return match ($this){
            self::Blocked=>'danger',
            self::Active=>'success',
        };
    }
   public function getIcon(): ?string
    {
        return match ($this){
            self::Blocked=>'heroicon-m-arrow-trending-up',
            self::Active=>'success',
        };
    }

}
