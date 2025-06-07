<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangMasukResource\Pages;
use App\Filament\Resources\BarangMasukResource\RelationManagers;
use App\Models\BarangMasuk;
use App\Models\Handphone;
use App\Models\RefKondisi;
use App\Models\RefKondisiBarang;
use App\Models\RefRamHandphone;
use App\Models\RefStatusHandphone;
use App\Models\RefTipeHandphone;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-circle';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Barang Masuk';

    public static function getPluralLabel(): ?string
    {
        return "Semua Barang Masuk";
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
                    ->searchable()
                    ->required()
                    ->options(Handphone::where('id_status', 100)->pluck('imei', 'id')),
                Forms\Components\DatePicker::make('tanggal_masuk')
                    ->required(),
                TextInput::make('harga_masuk')
                    ->prefix('Rp')
                    ->required()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('id_kondisi')
                    ->label('Kondisi Handphone')
                    ->required()
                    ->options(RefKondisiBarang::all()->pluck('kondisi_barang', 'id')),
                Select::make('id_user')
                    ->label('Pegawai')
                    ->required()
                    ->options(User::all()->pluck('name', 'id')),
                // Forms\Components\FileUpload::make('bukti_barang_masuk')
                //     ->disk('public')
                //     ->directory('bukti-barang-masuk')
                //     ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex()->sortable(),
                // Tables\Columns\ImageColumn::make('bukti_barang_masuk')
                //     ->label('')
                //     ->defaultImageUrl(url('sample-1.jpg'))
                //     ->disk('public'),
                Tables\Columns\TextColumn::make('handphone.imei')
                    ->label('IMEI')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Imei berhasil disalin')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('tanggal_masuk')->date(),
                Tables\Columns\TextColumn::make('harga_masuk')->money('Rp.', 0, true),
                Tables\Columns\TextColumn::make('kondisi.kondisi_barang'),
                Tables\Columns\TextColumn::make('user.name'),
            ])
            ->filters([
                Filter::make('tanggal_masuk')
                    ->form([
                        DatePicker::make('tanggal_masuk'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_masuk'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_masuk', '=', $date),
                            );
                    })
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
            'index' => Pages\ManageBarangMasuks::route('/'),
        ];
    }
}
