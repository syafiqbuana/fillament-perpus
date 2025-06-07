<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Filament\Resources\LoanResource\RelationManagers;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                ->relationship('member', 'name')
                ->label('Nama Anggota')
                ->required()
                ->searchable()
                ->preload()
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')->required()->label('Nama Anggota')->maxLength(255),
                    Forms\Components\TextInput::make('phone')->required()->label('No. Telepon Anggota')->tel()->maxLength(15),
                ]),
            Forms\Components\Select::make('book_id')
                ->relationship('book', 'title')
                ->label('Judul Buku')
                ->required()
                ->searchable()
                ->preload()
                ->createOptionForm([
                    Forms\Components\TextInput::make('title')->required()->label('Judul Buku')->maxLength(255),
                    Forms\Components\TextInput::make('author')->required()->label('Nama Penulis')->maxLength(255),
                ]),
            Forms\Components\Hidden::make('user_id')
                ->label('Nama Petugas')
                ->default(fn() => auth()->id())
                    ->required(),
            Forms\Components\DatePicker::make('loan_date')
                ->label('Tanggal Pinjam')
                ->required()
                ->closeOnDateSelection()
                ->native(false),
            Forms\Components\DatePicker::make('return_date')
                ->label('Tanggal Kembali')
                ->required()
                ->closeOnDateSelection()
                ->native(false),
        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->label('Nama Anggota')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Judul Buku')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Petugas')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('loan_date')
                //     ->label('Tanggal Pinjam')
                //     ->date()
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('return_date')
                //     ->label('Tanggal Kembali')
                //     ->date()
                //     ->sortable()
                //     ->searchable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
