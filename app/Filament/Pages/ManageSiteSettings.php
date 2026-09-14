<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Site Content';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('business_name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('tagline')
                    ->maxLength(191)
                    ->helperText('Shown under the logo in the hero section.'),
                Forms\Components\Textarea::make('about_text')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->tel(),
                Forms\Components\TextInput::make('email')
                    ->email(),
                Forms\Components\TextInput::make('service_area')
                    ->helperText('e.g. "Serving Winnipeg & the Seine River Valley"'),
                Forms\Components\TextInput::make('hours')
                    ->helperText('e.g. "Mon-Sat, 7am-7pm"'),
                Forms\Components\TextInput::make('facebook_url')
                    ->url(),
                Forms\Components\TextInput::make('instagram_url')
                    ->url(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SiteSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}