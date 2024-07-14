<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('changePassword')
                ->form([
                    TextInput::make('new_password')
                                ->password()
                                ->label('New Password')
                                ->required()
                                ->rule(Password::default()),
                    TextInput::make('new_password_confirmation')
                                ->password()
                                ->label('Confirm Password')
                                ->required()
                                ->same('new_password')
                                ->rule(Password::default()),
                ])
                ->action(function(array $data){
                    $this->record->update([
                        'password' => Hash::make($data['new_password'])
                    ]);  
                    Notification::make() 
                        ->title('Saved successfully')
                        ->success()
                        ->send(); 
                })
        ];
    } 
}
