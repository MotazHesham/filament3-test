<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationGroup = 'Shop';
    
    protected static ?int $navigationSort = 1;


    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Payment Time')->sortable(),
                TextColumn::make('product.name')->url(fn(Payment $record) => ProductResource::getUrl('edit',['record' => $record->product]))->searchable(),
                TextColumn::make('user.name')->label('User name'),
                TextColumn::make('user.email')->label('User Email'),
                TextColumn::make('voucher.code'),
                TextColumn::make('subtotal')->money('usd')
                            ->summarize(Sum::make()->label('Subtotal')),
                TextColumn::make('taxes')->money('usd')
                            ->summarize(Sum::make()->label('Taxes')),
                TextColumn::make('total')->money('usd')
                            ->summarize(Sum::make()->label('Total')),
            ])
            ->filters([
                Filter::make('created_at')
                        ->form([
                            DatePicker::make('created_from'),
                            DatePicker::make('created_until'),
                        ])
                        ->query(function($query,$data){ 
                            return $query->when($data['created_from'], fn ($query) => $query->whereDate('created_at','>=' ,$data['created_from'])) 
                                    ->when($data['created_until'], fn ($query) => $query->whereDate('created_at','<=' ,$data['created_until']));
                        })
            ])
            ->defaultSort('created_at','desc')
            ->actions([ 
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'), 
        ];
    }
    
    public static function canCreate(): bool{
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
    
}
