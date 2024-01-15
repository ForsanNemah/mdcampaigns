<?php
namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Mockery\Matcher\HasValue;
use function Filament\Support\get_color_css_variables;

enum registerStatus : string implements HasLabel,HasColor
{

    case Cancelled='cancelled';
    case Delayed='delayed';
    case Processed='processed';
    case Waiting='waiting' ;
    public function getLabel(): ?string
    {
        return match ($this){
            self::Waiting=>'waiting',
            self::Cancelled=>'cancelled',
            self::Delayed=>'delayed',
            self::Processed=>'processed',
         };
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return match ($this){
            self::Waiting=>'waiting',
            self::Cancelled=>'cancelled',
            self::Delayed=>'delayed',
            self::Processed=>'processed',
        };
    }
    public function getColor(): string|array|null
    {
        // TODO: Implement getColor() method.
        return match ($this){
            self::Waiting=> Color::hex('#4d7c0f'),
            self::Cancelled=>'danger',
            self::Delayed=>'gray',
            self::Processed=>'success',

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
