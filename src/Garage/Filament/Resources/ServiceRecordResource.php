<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas\ServiceRecordForm;
use Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Tables\ServiceRecordsTable;
use Packages\Automotive\Garage\Models\ServiceRecord;

class ServiceRecordResource extends Resource
{
    protected static ?string $model = ServiceRecord::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('automotive::service_records.service_record');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::service_records.service_records');
    }

    public static function form(Schema $schema): Schema
    {
        return ServiceRecordForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return ServiceRecordsTable::make($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceRecords::route('/'),
            'create' => Pages\CreateServiceRecord::route('/create'),
            'edit' => Pages\EditServiceRecord::route('/{record}/edit'),
            'view' => Pages\ViewServiceRecord::route('/{record}'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
