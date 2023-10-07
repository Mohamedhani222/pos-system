<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sale_id')->relationship('sale', 'id')
                    ->label('Order number')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('total_amount', Sale::find($state)?->total_amount ?? 0))
                    ->createOptionForm([
                        Forms\Components\Select::make('customer_id')->relationship('customer', 'name'),
                        Forms\Components\Select::make('cashier_id')->relationship('cashier', 'name'),
                        Forms\Components\TextInput::make('total_amount')->numeric()->required(),
                        Forms\Components\DatePicker::make('date'),
                        Forms\Components\Select::make('status')->options(['paid', 'unpaid'])
                    ]),

                Forms\Components\Hidden::make('invoice_serial_number')->default(0),
                Forms\Components\Hidden::make('invoice_number')->default(0),
                Forms\Components\TextInput::make('total_amount'),
                Forms\Components\DatePicker::make('invoice_date')->default(now())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')->label('invoice number')->searchable(),
                Tables\Columns\TextColumn::make('sale.customer.name'),
                Tables\Columns\TextColumn::make('total_amount'),
                Tables\Columns\TextColumn::make('invoice_date')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
        ];
    }
}
