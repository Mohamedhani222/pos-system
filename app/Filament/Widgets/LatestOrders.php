<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Sale::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('items.product.name'),
                Tables\Columns\TextColumn::make('cashier.name')->label('cashier'),
                Tables\Columns\TextColumn::make('customer.name')->label('customer'),
            ]);
    }
}
