<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPayments extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::with('product')->latest()->take(5)
            )
            ->columns([
                TextColumn::make('created_at')->label('Time'),
                TextColumn::make('total')->money(),
                TextColumn::make('product.name'),
            ])
            ->paginated(false);
    }

}
