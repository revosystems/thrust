<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Contracts\Prunable;
use BadChoice\Thrust\Facades\Thrust;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File extends Field implements Prunable
{
    public string $rowClass              = 'fw3';
    protected $basePath;
    protected $basePathBindings          = [];
    protected $displayCallback;
    public $prunable                     = true;
    public bool $showInEdit              = false;
    public $editClasses                  = 'br1';
    protected $classes                   = '';
    public $indexStyle                   = 'height:30px; width:30px; object-fit: contain; border:solid 1px #eee;';
    public $editStyle                    = 'height:150px; width:100%; object-fit: contain; border:solid 1px #eee;';
    public $withLink                     = true;
    public $filename                     = null;
    public $onlyUpload                   = false;
    protected $withoutExistsCheck        = false;
    protected ?string $storageVisibility = null;
    protected string $accept             = ''; // accept all types

    protected $maxFileSize = 10240; // 10 MB

    protected $storage;

    public function classes($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    public function storage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    public function withLink($withLink = true)
    {
        $this->withLink = $withLink;
        return $this;
    }

    public function accept(string $accept): static
    {
        $this->accept = $accept;
        return $this;
    }

    public function public() : self
    {
        $this->storageVisibility = 'public';
        return $this;
    }

    public function private() : self
    {
        $this->storageVisibility = 'private';
        return $this;
    }

    public function path($path, $bindings = [])
    {
        $this->basePath         = $path . '/';
        $this->basePathBindings = $bindings;
        return $this;
    }

    public function maxFileSize($fileSize)
    {
        $this->maxFileSize = $fileSize;
        return $this;
    }

    public function prunable($prunable = true)
    {
        $this->prunable = $prunable;
        return $this;
    }

    /**
     * Set a callback that will be used to convert the filename to a full url
     * The callback can also be a class with the __invoke so it can be reused without wiring anything into the resource
     * @param $displayCallback
     * @return $this
     */
    public function display($displayCallback)
    {
        $this->displayCallback = $displayCallback;
        return $this;
    }

    public function displayInIndex($object)
    {
        return view('thrust::fields.file', [
            'title'         => $this->getTitle(),
            'path'          => $this->displayPath($object),
            'classes'       => $this->classes,
            'exists'        => $this->exists($object),
            'style'         => $this->indexStyle,
            'resourceName'  => Thrust::resourceNameFromModel($object),
            'id'            => $object->id,
            'field'         => $this->field,
            'inline'        => true,
            'description'   => $this->getDescription(),
            'withLink'      => $this->withLink
        ])->render();
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.file-edit', [
            'title'         => $this->getTitle(),
            'path'          => $this->displayPath($object),
            'exists'        => $this->exists($object),
            'classes'       => $this->editClasses,
            'style'         => $inline ? $this->indexStyle : $this->editStyle,
            'resourceName'  => Thrust::resourceNameFromModel($object),
            'id'            => $object->id,
            'field'         => $this->field,
            'inline'        => $inline,
            'description'   => $this->getDescription(),
            'withLink'      => ! $inline && $this->withLink,
            'learnMoreUrl'  => $this->learnMoreUrl,
            'accept'        => $this->accept,
        ])->render();
    }

    public function displayPath($object, $prefix = '')
    {
        if (! $this->onlyUpload && ! $this->getValue($object)) {
            return null;
        }
        if ($this->displayCallback) {
            return call_user_func($this->displayCallback, $object, $prefix);
        }
        return $this->getStorage()->url($this->filePath($object, $prefix));
    }

    public function onlyUpload($value)
    {
        $this->onlyUpload = $value;
        return $this;
    }

    protected function filePath($object, $namePrefix = '')
    {
        if (! $this->onlyUpload && ! $this->getValue($object)) {
            return null;
        }

        if ($this->onlyUpload) {
            return $this->getPath() . $this->filename;
        }

        return $this->getPath() . $namePrefix . $this->getValue($object);
    }

    protected function getPath()
    {
        // TODO: Use the bindings!
        return str_replace('{user}', auth()->user()->username, $this->basePath);
    }

    public function mapAttributeFromRequest($value)
    {
        $this->store(null, $value);

        return $this->filename;
    }

    public function store($object, $file)
    {
        $this->delete($object, false);
        $this->filename ??= Str::random(10) . "." . $file->extension();
        $this->getStorage()->putFileAs($this->getPath(), $file, $this->filename, $this->storageVisibility);
        $this->updateField($object, $this->filename);
    }

    protected function updateField($object, $value)
    {
        if ($this->onlyUpload) {
            return;
        }
        $object?->update([$this->field => $value]);
    }

    public function exists($object)
    {
        if ($this->withoutExistsCheck) return true;
        if (Str::startsWith($object->{$this->field}, 'http')) return true;
        if (! $this->filename && ! $object->{$this->field}) return false;
        return $this->getStorage()->exists($this->getPath(). ($this->filename ?? $object->{$this->field}));
    }

    public function delete($object, $updateObject = false)
    {
        if (! $this->onlyUpload && ! $this->getValue($object)) {
            return;
        }
        $this->deleteFile($object);
        if ($updateObject) {
            $this->updateField($object, null);
        }
    }

    protected function deleteFile($object)
    {
        $this->getStorage()->delete($this->filePath($object));
    }

    public function prune($object)
    {
        $this->delete($object);
    }

    public function withoutExistCheck(){
        $this->withoutExistsCheck = true;
        return $this;
    }

    public function onStoreFailed(): void
    {
        $this->onlyUpload(true)->deleteFile(null);
    }

    protected function getStorage() : \Illuminate\Filesystem\FilesystemAdapter {
        return $this->storage ?? Storage::disk(config('filesystem.default'));
    }
}
