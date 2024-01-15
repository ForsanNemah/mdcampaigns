<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected static string $layout = 'filament-panels::components.layout.index';
    protected static string $view = 'filament.pages.auth.edit-profile';
    public static function getLabel(): string
    {
        return parent::getLabel(); // TODO: Change the autogenerated stub
    }

    public function getName()
    {
        return parent::getName(); // TODO: Change the autogenerated stub
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
