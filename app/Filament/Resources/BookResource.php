<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;
    protected static ?string $navigationGroup = 'Buku';
    protected static ?string $navigationLabel = 'Data Buku';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Buku')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('author')
                    ->label('Pengarang Buku')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('publisher')
                    ->label('Penerbit Buku')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('published_date')
                    ->label('Tahun Terbit Buku')
                    ->closeOnDateSelection()
                    ->required()
                    ->format('Y')
                    ->displayFormat('Y')
                    ,
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN Buku')
                    ->required()
                    ->maxLength(13),
                Forms\Components\TextInput::make('stock')
                    ->label('Stok Buku')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori Buku')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->label('Nama Kategori')->maxLength(20),
                    ])
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Buku')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
                    ->label('Pengarang Buku')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('publisher')
                    ->label('Penerbit Buku')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('published_date')
                //     ->label('Tahun Terbit Buku')
                //     ->sortable()
                //     ->date(),
                // Tables\Columns\TextColumn::make('isbn')
                //     ->label('ISBN Buku')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('stock')
                //     ->label('Stok Buku')
                //     ->sortable()
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                ]),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
