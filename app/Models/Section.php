<?php

namespace App\Models;

use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['page_id', 'type', 'content', 'settings', 'sort_order', 'is_visible'])]
class Section extends Model
{
    /** @use HasFactory<SectionFactory> */
    use HasFactory;

    public const TYPES = [
        'hero' => 'Hero',
        'text_block' => 'Bloque de texto',
        'image_text' => 'Imagen y texto',
        'cards' => 'Tarjetas',
        'gallery' => 'Galeria',
        'services' => 'Servicios',
        'projects' => 'Proyectos',
        'contact' => 'Contacto',
        'faq' => 'Preguntas frecuentes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'settings' => 'array',
            'sort_order' => 'integer',
            'is_visible' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Page, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
