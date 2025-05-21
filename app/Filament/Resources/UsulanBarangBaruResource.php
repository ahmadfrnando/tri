<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsulanBarangBaruResource\Pages;
use App\Filament\Resources\UsulanBarangBaruResource\RelationManagers;
use App\Models\RefStatusUsulan;
use App\Models\User;
use App\Models\UsulanBarangBaru;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class UsulanBarangBaruResource extends Resource
{
    protected static ?string $model = UsulanBarangBaru::class;


    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Usulan Barang baru';

    public static function getPluralLabel(): ?string
    {
        return "Semua Usulan";
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('model')->required(),
                TextInput::make('jumlah')->numeric()->required(),
                Textarea::make('tujuan_pengusulan')->required(),
                Select::make('id_user')
                    ->label('Pegawai yang mengajukan')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex()->sortable(),
                Tables\Columns\TextColumn::make('model')->searchable(),
                Tables\Columns\TextColumn::make('jumlah')->searchable(),
                Tables\Columns\TextColumn::make('tujuan_pengusulan')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('id_status_usulan')
                    ->label('Status Usulan')
                    ->badge()
                    ->colors([
                        'primary' => fn($record) => $record->id_status_usulan == 1,
                        'success' => fn($record) => $record->id_status_usulan == 2,
                        'gray' => fn($record) => $record->id_status_usulan == 3,
                        'danger' => fn($record) => $record->id_status_usulan == 4,
                    ])
                    ->getStateUsing(function ($record) {
                        return RefStatusUsulan::find($record->id_status_usulan)->status_usulan ?? '';
                    }),
            ])
            ->filters([
                SelectFilter::make('id_status_usulan')
                    ->label('Status')
                    ->options(
                        RefStatusUsulan::all()->pluck('status_usulan', 'id')->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsulanBarangBarus::route('/'),
        ];
    }
}
