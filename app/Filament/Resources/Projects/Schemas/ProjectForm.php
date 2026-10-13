<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Support\Fields;
use App\Support\Media;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Proje bilgileri')->columns(2)->schema([
                        Fields::title('title', 'Proje adı'),
                        Fields::slug(),
                        TextInput::make('type')->label('Havuz tipi')->placeholder('Örn. Villa Havuzu')->maxLength(255),
                        TextInput::make('location')->label('Konum')->placeholder('Örn. Başakşehir / İstanbul')->maxLength(255),
                        Textarea::make('summary')->label('Kısa açıklama')->rows(2)->columnSpanFull(),
                        RichEditor::make('body')->label('Detay')->columnSpanFull(),
                    ]),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Görseller')->schema([
                        Fields::image('projects')->label('Kapak görseli')->required(),
                        FileUpload::make('gallery')->label('Galeri')->image()->multiple()->reorderable()
                            ->disk(Media::diskName())->directory('projects/gallery')->maxFiles(20)->maxSize(5120),
                    ]),
                    Fields::publishing(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
