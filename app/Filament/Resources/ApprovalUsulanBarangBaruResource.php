<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovalUsulanBarangBaruResource\Pages;
use App\Filament\Resources\ApprovalUsulanBarangBaruResource\RelationManagers;
use App\Models\ApprovalUsulanBarangBaru;
use App\Models\RefStatusUsulan;
use App\Models\UsulanBarangBaru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalUsulanBarangBaruResource extends Resource
{
    protected static ?string $model = ApprovalUsulanBarangBaru::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Approval Barang Baru';

    public static function getPluralLabel(): ?string
    {
        return "Semua Usulan";
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_status_usulan', 1);  // filter id_status = 1
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('id_status_usulan', 1)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(ApprovalUsulanBarangBaru::where('id_status_usulan', 1)) // Hanya tampilkan data dengan id_status_usulan = 1
            ->columns([
                TextColumn::make('No')->rowIndex()->sortable(),
                TextColumn::make('model')->searchable(),
                TextColumn::make('jumlah')->searchable(),
                TextColumn::make('tujuan_pengusulan')->searchable(),
                TextColumn::make('user.name')->sortable()->searchable()->label('Pegawai yang mengajukan'),
                Tables\Columns\TextColumn::make('pesan')
                    ->width('300px')
                    ->html()
                    ->wrap()
                    ->searchable(),
                SelectColumn::make('id_status_usulan')
                    ->label('Status Usulan')
                    ->options(
                        RefStatusUsulan::all()->pluck('status_usulan', 'id')->toArray()
                    )
                    ->getStateUsing(function ($record) {
                        return RefStatusUsulan::find($record->id_status_usulan)->status_usulan ?? '';
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('beriKomentar')
                    ->label('Beri Komentar')
                    ->button()
                    ->icon('heroicon-o-chat-bubble-bottom-center-text') // icon optional
                    ->color('success')
                    ->action(function ($record, $data) {
                        $usulan = UsulanBarangBaru::find($record->id);
                        $usulan->update([
                            'pesan' => $data['pesan'],
                        ]);
                        // Atau pakai DB langsung:
                        // DB::table('comments')->insert([
                        //     'handphone_id' => $record->id,
                        //     'isi_komentar' => $data['isi_komentar'],
                        //     'created_at' => now(),
                        //     'updated_at' => now(),
                        // ]);

                        // Beri notifikasi sukses
                        // $this->notify('success', 'Komentar berhasil dikirim!');
                    })
                    ->modalHeading('Tambah Komentar')
                    ->form([
                        Forms\Components\Textarea::make('pesan')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->modalSubmitActionLabel('Kirim Komentar')
                    ->modalWidth('lg'),
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
            'index' => Pages\ManageApprovalUsulanBarangBarus::route('/'),
        ];
    }
}
