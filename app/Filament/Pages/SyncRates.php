<?php

namespace App\Filament\Pages;

use App\Http\Controllers\ExchangeRateController;
use App\Services\ExchangeRateService;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
class SyncRates extends Page
{    
    protected static ?string $navigationLabel = 'Sync';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.sync-rates';



    public ?string $from = null;
    public ?string $to = null;


    public function mount (): void {
        $this->from = now()->subDays(7)->toDateString();
        $this->to = now()->toDateString();
    }
    protected function getHeaderActions(): array {
        return [
            Action::make('Sync')
            ->label('Install Rates')
            ->icon('heroicon-o-arrow-path')
            ->action(function (ExchangeRateService $service) {
                $service->syncRate($this->from, $this->to);
                Notification::make()
                    ->title('Done!!!')
                    ->success()
                    ->send();
            }),
        ];
    }
}
