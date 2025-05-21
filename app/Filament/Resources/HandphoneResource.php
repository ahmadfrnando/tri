<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HandphoneResource\Pages;
use App\Filament\Resources\HandphoneResource\RelationManagers;
use App\Models\Brand;
use App\Models\Handphone;
use App\Models\RefKondisiBarang;
use App\Models\RefRamHandphone;
use App\Models\RefStatusHandphone;
use App\Models\RefTipeHandphone;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class HandphoneResource extends Resource
{
    protected static ?string $model = Handphone::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationLabel = 'Semua Barang';

    public static function getPluralLabel(): ?string
    {
        $locale = app()->getLocale();
        if ($locale == 'id') {
            return "Daftar Semua Handphone";
        } else
            return "Daftar Semua Handphone";
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('id_status', 1)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('imei')
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ukuran_layar')
                    ->required()
                    ->numeric(),
                Select::make('id_ram')
                    ->label('Ram Hp')
                    ->required()
                    ->options(RefRamHandphone::all()->pluck('ram', 'id'))
                    ->searchable(),
                Select::make('id_tipe_handphone')
                    ->label('Tipe Handphone')
                    ->required()
                    ->options(RefTipeHandphone::all()->pluck('nama_tipe', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex()->sortable(),
                Tables\Columns\TextColumn::make('imei')
                    ->searchable()
                    ->label('IMEI')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Imei berhasil disalin')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ukuran_layar')
                    ->formatStateUsing(fn($state): string => $state . ' inch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ram.ram'),
                Tables\Columns\TextColumn::make('tipe.nama_tipe'),
                Tables\Columns\TextColumn::make('kondisi.kondisi_barang'),
                TextColumn::make('id_status')
                    ->badge()
                    ->colors([
                        'success' => fn($record) => $record->id_status == 1,
                        'danger' => fn($record) => $record->id_status == 2,
                        'blue' => fn($record) => $record->id_status == 3,
                        'gray' => fn($record) => $record->id_status == 4,
                        'gray' => fn($record) => $record->id_status == 100,
                    ])
                    ->getStateUsing(function ($record) {
                        return RefStatusHandphone::find($record->id_status)->status_handphone ?? '';
                    }),
            ])
            ->filters([
                SelectFilter::make('id_status')
                    ->label('Status')
                    ->options(
                        RefStatusHandphone::all()->pluck('status_handphone', 'id')->toArray()
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHandphones::route('/'),
            'create' => Pages\CreateHandphone::route('/create'),
            'edit' => Pages\EditHandphone::route('/{record}/edit'),
        ];
    }
}
