<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PhpParser\Node\Expr\FuncCall;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'imagen', 'stock', 'disponible', 'pvp', 'user_id'];

    //Relación 1:N con users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //Relación N:M con tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    //Accessors y muttators
    public function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => ucfirst($v)
        );
    }

    public function descripcion(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => ucfirst($v)
        );
    }

    public function getTagsId(): array
    {
        $tags = [];

        foreach ($this->tags as $tag) {
            $tags[] = $tag->id;
        }
        return $tags;
    }
}
