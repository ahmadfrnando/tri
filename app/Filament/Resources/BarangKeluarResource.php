<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangKeluarResource\Pages;
use App\Filament\Resources\BarangKeluarResource\RelationManagers;
use App\Models\BarangKeluar;
use App\Models\Handphone;
use App\Models\RefKondisiBarang;
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
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangKeluarResource extends Resource
{
    protected static ?string $model = BarangKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-circle';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Barang Keluar';

    public static function getPluralLabel(): ?string
    {
        return "Semua Barang Keluar";
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
                    ->label('IMEI')
                    ->options(Handphone::where('id_status', 1)->pluck('imei', 'id'))
                    ->searchable(),
                Forms\Components\DatePicker::make('tanggal_keluar')
                    ->required(),
                TextInput::make('harga_keluar')
                    ->prefix('Rp')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('id_kondisi')
                    ->label('Kondisi Barang')
                    ->options(RefKondisiBarang::all()->pluck('kondisi_barang', 'id')),
                Select::make('id_user')
                    ->label('Pegawai')
                    ->options(User::all()->pluck('name', 'id')),
                // Forms\Components\FileUpload::make('bukti_barang_keluar')
                //     ->disk('public')
                //     ->directory('bukti-barang-keluar')
                //     ->maxSize(2048)
                //     ->label('Bukti Barang Keluar (* Maksimal 2MB)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex()->sortable(),
                // Tables\Columns\ImageColumn::make('bukti_barang_keluar')
                //     ->label('')
                //     ->defaultImageUrl(url('sample-1.jpg'))
                //     ->disk('public'),
                Tables\Columns\TextColumn::make('handphone.imei')
                    ->copyable()
                    ->copyMessage('Imei berhasil disalin')
                    ->copyMessageDuration(1500)
                    ->label('IMEI')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_keluar')->date(),
                Tables\Columns\TextColumn::make('harga_keluar')->money('Rp.', 0, true),
                Tables\Columns\TextColumn::make('kondisi.kondisi_barang'),
                Tables\Columns\TextColumn::make('user.name'),
            ])
            ->filters([
                Filter::make('tanggal_keluar')
                    ->form([
                        DatePicker::make('tanggal_keluar'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_keluar'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_keluar', '=', $date),
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
            'index' => Pages\ManageBarangKeluars::route('/'),
        ];
    }
}
