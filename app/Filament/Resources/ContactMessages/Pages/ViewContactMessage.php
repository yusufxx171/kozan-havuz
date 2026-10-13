<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->record->read_at === null) {
            $this->record->forceFill(['read_at' => now()])->save();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('whatsapp')
                ->label('WhatsApp ile yanıtla')
                ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                ->color('success')
                ->url(fn (): string => 'https://wa.me/'.$this->whatsappNumber($this->record->phone), shouldOpenInNewTab: true)
                ->visible(fn (): bool => filled($this->record->phone)),
            Action::make('email')
                ->label('E-posta ile yanıtla')
                ->icon(Heroicon::OutlinedEnvelope)
                ->url(fn (): string => 'mailto:'.$this->record->email)
                ->visible(fn (): bool => filled($this->record->email)),
            DeleteAction::make(),
        ];
    }

    private function whatsappNumber(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone);

        return match (true) {
            str_starts_with($digits, '90') => $digits,
            str_starts_with($digits, '0') => '9'.$digits,
            default => '90'.$digits,
        };
    }
}
