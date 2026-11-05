<?php

declare(strict_types=1);

namespace Rimba\Knowledge\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Throwable;

#[Table(name: 'kn_document_files')]
#[Fillable([
    'document_revision_id',
    'disk',
    'path',
    'name',
    'mime_type',
    'size_bytes',
    'checksum_sha256',
    'locale',
    'is_primary',
])]
class DocumentFile extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
            'is_primary' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $file): void {
            $file->disk ??= 'local';

            if (blank($file->path)) {
                return;
            }

            $file->name = filled($file->name)
                ? $file->name
                : basename($file->path);

            if (! $file->isDirty('path') && filled($file->checksum_sha256)) {
                return;
            }

            try {
                $storage = Storage::disk($file->disk);

                if (! $storage->exists($file->path)) {
                    return;
                }

                $file->mime_type = $storage->mimeType($file->path) ?: null;
                $file->size_bytes = $storage->size($file->path);

                $stream = $storage->readStream($file->path);

                if (is_resource($stream)) {
                    $hash = hash_init('sha256');
                    hash_update_stream($hash, $stream);
                    fclose($stream);
                    $file->checksum_sha256 = hash_final($hash);
                }
            } catch (Throwable) {
                // The upload remains valid even when a remote disk cannot expose metadata.
            }
        });

        static::saved(function (self $file): void {
            if (! $file->is_primary) {
                return;
            }

            self::query()
                ->where('document_revision_id', $file->document_revision_id)
                ->where('id', '!=', $file->getKey())
                ->where('is_primary', true)
                ->update(['is_primary' => false]);
        });
    }

    public function downloadUrl(): string
    {
        $filesystem = Storage::disk($this->disk);

        try {
            return $filesystem->temporaryUrl($this->path, now()->addMinutes(10));
        } catch (Throwable) {
            return $filesystem->url($this->path);
        }
    }

    public function revision(): BelongsTo
    {
        return $this->belongsTo(DocumentRevision::class, 'document_revision_id');
    }
}
