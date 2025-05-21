<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataBarangRusakResource\Pages;
use App\Filament\Resources\DataBarangRusakResource\RelationManagers;
use App\Models\DataBarangRusak;
use App\Models\Handphone;
use App\Models\RefKondisiBarang;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataBarangRusakResource extends Resource
{
    protected static ?string $model = DataBarangRusak::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-x-mark';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Barang Rusak';

    public static function getPluralLabel(): ?string
    {
        return "Semua Barang Rusak";
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_handphone')
                    ->label('Handphone')
                    ->required()
                    ->searchable()
                    ->options(Handphone::where('id_status', 1)->pluck('imei', 'id')),
                DatePicker::make('tanggal'),
                Textarea::make('deskripsi_kerusakan'),
                Select::make('id_kondisi')
                    ->label('Kondisi Barang')
                    ->options(RefKondisiBarang::whereNotIn('id', [1, 4])->pluck('kondisi_barang', 'id')),
                Select::make('id_user')
                    ->label('Pegawai')
                    ->required()
                    ->options(User::all()->pluck('name', 'id')),
                Forms\Components\FileUpload::make('bukti_barang_rusak')
                    ->disk('public')
                    ->directory('bukti-barang-rusak')
                    ->maxSize(2048)
                    ->required()
                    ->label('Bukti Barang Rusak )* Maksimal 2MB)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex()->sortable(),
                TextColumn::make('handphone.imei')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Imei berhasil disalin')
                    ->copyMessageDuration(1500)
                    ->label('IMEI'),
                TextColumn::make('handphone.model')
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('deskripsi_kerusakan')
                    ->searchable(),
                TextColumn::make('id_kondisi')
                    ->badge()
                    ->colors([
                        'primary' => fn($record) => $record->id_kondisi == 2,
                        'danger' => fn($record) => $record->id_kondisi == 3,
                    ])
                    ->getStateUsing(function ($record) {
                        return RefKondisiBarang::find($record->id_kondisi)->kondisi_barang ?? '';
                    }),
                ImageColumn::make('bukti_barang_rusak')
                    ->label('Bukti Barang Rusak')
                    ->defaultImageUrl(url('sample-1.jpg'))
                    ->disk('public'),
                TextColumn::make('user.name')->label('Pegawai')

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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDataBarangRusaks::route('/'),
        ];
    }
}
