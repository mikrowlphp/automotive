<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\RelationManagers\ServiceRecordsRelationManager;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Schemas\DiagnosisForm;
use Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Schemas\DiagnosisTable;
use Packages\Automotive\Garage\Models\Diagnosis;

class DiagnosisResource extends Resource
{
    protected static ?string $model = Diagnosis::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'acceptance_date';

    public static function getModelLabel(): string
    {
        return __('automotive::services.diagnosis.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::services.diagnosis.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('automotive::services.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return DiagnosisForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return DiagnosisTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            ServiceRecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiagnoses::route('/'),
            'create' => Pages\CreateDiagnosis::route('/create'),
            'edit' => Pages\EditDiagnosis::route('/{record}/edit'),
            'view' => Pages\ViewDiagnosis::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['vehicle', 'customer'])
            ->orderBy('acceptance_date', 'desc');
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
