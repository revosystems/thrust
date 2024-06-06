<?php

namespace BadChoice\Thrust;

use BadChoice\Thrust\Contracts\DatabaseActionAuthor;
use BadChoice\Thrust\Models\DatabaseAction;
use BadChoice\Thrust\Models\DatabaseActionDefaultAuthor;
use BadChoice\Thrust\Models\Enums\DatabaseActionEvent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

final class ThrustObserver
{
    // https://laravel.com/docs/9.x/eloquent#observers-and-database-transactions
    public bool $afterCommit = true;

    protected bool $enabled = true;

    protected ResourceManager $manager;

    protected DatabaseActionAuthor $author;

    protected array $overlook = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct()
    {
        $this->manager = app(ResourceManager::class);
    }

    public function author(DatabaseActionAuthor $author): void
    {
        $this->author = $author;
    }

    public function enable(bool $value = true): void
    {
        $this->enabled = $value;
    }

    public function disable(bool $value = true): void
    {
        $this->enabled = ! $value;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function register(): void
    {
        if (! $this->enabled) {
            return;
        }

        collect($this->manager->models(observable: true))
            ->each(fn ($model) => $model::observe(static::class));
    }

    public function created(Model $model): void
    {
        $this->mergeOverlookedAttributes($model);

        $attributes = collect($model->getDirty())
            ->reject(fn ($value, $key) => $value === null || $this->overlooked($key));

        if ($attributes->isEmpty()) {
            return;
        }

        $this->trackDatabaseAction(
            model: $model,
            event: DatabaseActionEvent::CREATED,
            original: null,
            current: $attributes,
        );
    }

    public function updated(Model $model): void
    {
        $this->mergeOverlookedAttributes($model);

        $attributes = collect($model->getDirty())
            ->reject(fn ($value, $key) => $this->overlooked($key));

        if ($attributes->isEmpty()) {
            return;
        }

        $this->trackDatabaseAction(
            model: $model,
            event: DatabaseActionEvent::UPDATED,
            original: $attributes->map(fn ($value, $key) => $model->getOriginal($key)),
            current: $attributes,
        );
    }

    public function deleted(Model $model): void
    {
        $this->mergeOverlookedAttributes($model);

        $attributes = collect($model->getAttributes())
            ->reject(fn ($value, $key) => $value === null || $this->overlooked($key));

        if ($attributes->isEmpty()) {
            return;
        }

        $this->trackDatabaseAction(
            model: $model,
            event: DatabaseActionEvent::DELETED,
            original: $attributes,
            current: null,
        );
    }

    protected function trackDatabaseAction(
        Model $model,
        DatabaseActionEvent $event,
        ?Collection $original,
        ?Collection $current,
    ): ?DatabaseAction {
        if (! $this->enabled) {
            return null;
        }

        $attributes = [
            ...$this->authorAttributes(),
            'model_type' => $model::class,
            'model_id' => $model->id,
            'event' => $event,
            'original' => $original,
            'current' => $current,
            'ip' => request()->ip(),
        ];

        try {
            return DatabaseAction::on($model->getConnectionName())->create($attributes);
        } catch (QueryException $e) {
            // The table is probably not found because the user have not yet
            // logged in, so we don't bother to log anything.
        } catch (Exception $e) {
            Log::error('An exception occurred while trying to create a DatabaseAction', $attributes);
        }
        return null;
    }

    protected function authorAttributes(): array
    {
        $author = $this->author ?? new DatabaseActionDefaultAuthor;

        return [
            'author_name' => $author->name(),
            'author_type' => $author->type(),
            'author_id' => $author->id(),
        ];
    }

    protected function mergeOverlookedAttributes(Model $model): void
    {
        $key = $this->manager->resourceNameFromModel($model::class);
        $resource = $this->manager->resources()[$key];
        $this->overlook = [
            ...$this->overlook,
            ...(new $resource)->overlooked(),
        ];
    }

    protected function overlooked(string $key): bool
    {
        return in_array($key, $this->overlook);
    }
}
