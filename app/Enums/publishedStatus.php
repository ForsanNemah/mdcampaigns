<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum publishedStatus : int implements HasLabel,HasColor
{
    case Published= 1 ;
    case UnPublished=0;
    public function getLabel(): ?string
    {
        return match ($this){
            self::Published=>'Published',
            self::UnPublished=>'UnPublished',
         };
    }
    public function getColor(): string|array|null
    {
        // TODO: Implement getColor() method.
        return match ($this){
            self::Published=>'success',
            self::UnPublished=>'warning',
        };
    }
 /*   public function getIcon(): ?string
    {
        return match ($this){
            self::Waiting=>'warning',
            self::Cancelled=>'cancelled',
            self::Delayed=>'delayed',
            self::Processed=>'processed',
        };
    }*/

}
