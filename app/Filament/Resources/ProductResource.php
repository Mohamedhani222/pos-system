<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->rules('required|string|max:255'),
                Forms\Components\Textarea::make('description')->required()->rules('required|string|max:255'),
                Forms\Components\TextInput::make('unit_price')->numeric()->required()->rules('numeric|required'),
                Forms\Components\TextInput::make('quantity_available')->numeric()->required()->rules('numeric|required'),
                Forms\Components\FileUpload::make('image')->disk('public')->directory('images/')->required()->rules('image|required'),
                Forms\Components\Checkbox::make('active'),
                Forms\Components\Select::make('category_id')->relationship('category', 'name')->required()->rules('exists:categories,id')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(20),
                Tables\Columns\TextColumn::make('unit_price')->label('price'),
                Tables\Columns\TextColumn::make('quantity_available')->label('quantity'),
                Tables\Columns\TextColumn::make('category.name')
                    ->url(function (Product $product): string {
                        return CategoryResource::getUrl('edit', [
                            'record' => $product->category_id
                        ]);
                    }),
                Tables\Columns\ImageColumn::make('image')->disk('public'),
                Tables\Columns\ToggleColumn::make('active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
        ];
    }
}
