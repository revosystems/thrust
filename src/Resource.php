<?php

namespace BadChoice\Thrust;

use BadChoice\Thrust\Actions\Delete;
use BadChoice\Thrust\Actions\Import;
use BadChoice\Thrust\Actions\MainAction;
use BadChoice\Thrust\Contracts\FormatsNewObject;
use BadChoice\Thrust\Contracts\Prunable;
use BadChoice\Thrust\Exceptions\CanNotDeleteException;
use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\Fields\Edit;
use BadChoice\Thrust\Fields\FieldContainer;
use BadChoice\Thrust\Fields\Relationship;
use BadChoice\Thrust\Helpers\Translation;
use BadChoice\Thrust\Html\Validation;
use BadChoice\Thrust\ResourceFilters\Filters;
use BadChoice\Thrust\ResourceFilters\Search;
use BadChoice\Thrust\ResourceFilters\Sort;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

abstract class Resource
{

    /**
     * @var string defines the underlying model class
     */
    public static $model;

    /**
     * Set this to true when the resource is a simple one like business
     * @var bool
     */
    public static $singleResource = false;

    /**
     * @var string The field that will be used to display the resource main name
     */
    public $nameField = 'name';

    /**
     * Defines de number of items to paginate
     */
    public $pagination = 25;

    /**
     * Defines the searchable fields
     */
    public static $search = [];

    /**
     * @var bool Defines if the resource can be globaly searched
     */
    public static $allowsGlobalSearch = true;


    /**
    * You can make that search is performed to another resource and the result is displayed in the same page
    */
    public static $searchResource = null;

    /**
    * Defines if the search input must be focused on page load
    */
    public static $searchAutofocus = false;

    /**
    * @var int Defines the maximum number of search results to be displayed
    */
    public static $maxSearchResults = 100;

    /**
    * @var ?string The text currently being searched to match with results
    */
    public $searchText = null;


    /**
     * @var Defines the global gate ability for the actions to be performed,
     * It goes along with the default Laravel resource Policy if any
     */
    public static $gate;

    /**
     * @var Class that defines the policy relation, over the $model.
     */
    public static $policy;

    /**
     * @var Determines if the underlying model must be observed and tracked into database actions.
     */
    public static $observes = true;

    /**
     * @var Enumerates the attributes from the underlying model that will be overlooked when the model is observed.
     */
    protected $overlook = [];

    /**
     * @var string when resource is update will show a confirmation alert with the message specified
     */
    public $updateConfirmationMessage = '';

    /**
     * @var bool define if a resource can be imported using thrust import features
     */
    public static $importable = false;

    /** 
     * @var array in case the resource has fields that togheter are like a primary key (for example a morphable_id morphable_type) we want in the import for it to be treated as an id. Add those fields in this variable
     */
    public static $compoundKeyFields = null;


    /**
     * @var bool define if the resource is sortable and can be arranged in the index view
     */
    public static $sortable     = false;
    public static $sortField    = 'order';
    public static $defaultSort  = 'id';
    public static $defaultOrder = 'ASC';
    public static $canSaveOrderWhenSorted = false;

    /**
     * @var array Set the default eager loading relationships
     */
    protected $with = null;

    /**
     * @var Collection where rows already fetched are stored
     */
    private $alreadyFetchedRows;

    /**
     * @return array array of fields
     */
    abstract public function fields();

    public function getFields(?bool $inline = false)
    {
        return array_merge(
            ($this->fields() ?? []),
            $inline
                ? []
                : ($this->editAndDeleteFields() ?? [])
        );
    }

    public function fieldsFlattened(?bool $inline = false)
    {
        return collect($this->getFields($inline))->flatMap->fieldsFlattened();
    }

    public function fieldFor($field)
    {
        return $this->fieldsFlattened()->where('field', $field)->first();
    }

    public function panels($object)
    {
        return collect($this->fields())->filter(function ($field) {
            return ($field instanceof FieldContainer);
        })->each->withObject($object)
        ->flatMap->panels($object);
    }

    public function name()
    {
        return app(ResourceManager::class)->resourceNameFromModel(static::$model);
    }

    public function indexUrl() : string {
        return route('thrust.index', lcFirst(class_basename($this)));
    }

    public function editUrl($object) : string {
        return route('thrust.edit', [lcFirst(class_basename($this)), $object->id]);
    }

    public function find($id)
    {
        return (static::$model)::find($id);
    }

    public function first()
    {
        return $this->getBaseQuery()->first();
    }

    public function count()
    {
        return $this->getBaseQuery()->count();
    }

    public function create($data)
    {
        app(ResourceGate::class)->check($this, 'create');
        return static::$model::create($this->mapRequest($data));
    }

    public function update($id, $newData)
    {
        $object = $this->find($id);
        app(ResourceGate::class)->check($this, 'update', $object);
        $result = $object->update($this->mapRequest($newData));
        $this->onUpdated($object, $newData);
        return $result;
    }

    public function updateOrCreate($data)
    {
        app(ResourceGate::class)->check($this, 'create');
        $data = collect($this->mapRequest($data));
        if ($data->has('id')) {
            return static::$model::updateOrCreate($data->only('id')->all(), $data->except('id')->all());
        }

        if (static::$compoundKeyFields && $data->has(static::$compoundKeyFields)) {
            return static::$model::updateOrCreate($data->only(static::$compoundKeyFields)->all(), $data->except(static::$compoundKeyFields)->all());
        }
        
        return static::$model::create($data->all());
    }

    protected function onUpdated(Model $model, $newData): void
    {
    }

    public function delete($id)
    {
        $object = is_numeric($id) ? $this->find($id) : $id;
        app(ResourceGate::class)->check($this, 'delete', $object);
        $this->canBeDeleted($object);
        $this->prune($object);
        return $object->delete();
    }

    protected function canBeDeleted($object)
    {
        if (method_exists($object, 'canBeDeleted') && ! $object::canBeDeleted($object->id)) {
            throw new CanNotDeleteException(__('admin.cantDelete'));
        }
        return true;
    }

    public function canEdit($object)
    {
        return $this->can('update', $object);
    }

    public function canDelete($object)
    {
        return $this->can('delete', $object);
    }

    public function canSort(): bool
    {
        return static::$sortable && $this->can('update');
    }

    public function can($ability, $object = null)
    {
        if (! $ability) {
            return true;
        }
        return app(ResourceGate::class)->can($this, $ability, $object);
    }

    public function makeNew()
    {
        $object = new static::$model;
        if (collect(class_implements($this))->contains(FormatsNewObject::class)) {
            $this->formatNewObject($object);
        }

        if (static::$sortable) {
            $object->{static::$sortField} = $this->getBaseQuery()->orderBy(static::$sortField, 'DESC')->first()?->{static::$sortField} + 1;
        }
        return $object;
    }

    public function getValidationRules($objectId, $multiple = false)
    {
        $fields = $this->fieldsFlattened()->where('showInEdit', true);
        if ($multiple) {
            $fields = $fields->reject(function ($field) {
                return $field->excludeOnMultiple;
            });
        }
        return $fields->mapWithKeys(function ($field) use ($objectId) {
            return [$field->field => str_replace('{id}', $objectId, $field->validationRules)];
        })->filter(function ($value) {
            return $value != null;
        })->toArray();
    }

    public function getValidationEventListeners()
    {
        $fields = $this->fieldsFlattened()->where('showInEdit', true);
        return $fields->reduce(function ($carry, $field) {
            return $carry . Validation::make($field->validationRules)->generateEventListeners($field->field);
        }, '');
    }

    public function mapRequest($data)
    {
        $this->fieldsFlattened()->filter(function ($field) use ($data) {
            return isset($data[$field->field]);
        })->each(function ($field) use (&$data) {
            $data[$field->field] = $field->mapAttributeFromRequest($data[$field->field]);
        });
        return $data;
    }

    public function mainActions()
    {
        return  [
            ...(static::$importable ? [new Import()] : []),
            MainAction::make('new'),
        ];
    }

    public function actions()
    {
        return $this->canDelete(static::$model)
            ? [new Delete()]
            : [];
    }

    public function searchActions(?bool $whileSearch = false)
    {
        return $whileSearch && static::$searchResource
            ? Thrust::make(static::$searchResource)->actions()
            : $this->actions();
    }

    public function filters()
    {
        return null;
    }

    public function getWithFields()
    {
        return $this->with !== null ? $this->with : $this->getRelationshipsFields()->toArray();
    }

    public function getRelationshipsFields()
    {
        return $this->fieldsFlattened()->filter(function ($field) {
            return $field instanceof Relationship;
        })->pluck('field');
    }

    public function prune($object)
    {
        $this->fieldsFlattened()->filter(function ($field) {
            return $field instanceof Prunable;
        })->each->prune($object);
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    protected function getBaseQuery()
    {
        return $this->query ?? static::$model::query()->with($this->getWithFields());
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $query = $this->getBaseQuery();

        $this->applySearch($query);

        $this->applySort($query);

        if (request('filters')) {
            Filters::applyFromRequest($query, request('filters'));
        }
        return $query;
    }

    protected function applySearch(&$query)
    {
        if ($this->isBeingSearched()) {
            Search::apply($query, $this->searchText, static::$search);
        }
    }

    private function applySort(&$query)
    {
        if (request('sort') && $this->sortFieldIsValid(request('sort'))) {
            return Sort::apply($query, request('sort'), request('sort_order'));
        }
        
        if (static::$sortable) {
            return Sort::apply($query, static::$sortField, 'ASC');
        }

        return Sort::apply($query, static::$defaultSort, static::$defaultOrder);
    }

    public function rows()
    {
        if (! $this->alreadyFetchedRows) {
            return $this->fetchRows();
        }
        return $this->alreadyFetchedRows;
    }

    public function getTitle()
    {
        return trans_choice(config('thrust.translationsPrefix') . Str::singular($this->name()), 2);
    }

    public function getDescription()
    {
        $description = trans_choice(config('thrust.translationsDescriptionsPrefix') . Str::singular($this->name()), 1);
        if (! Str::contains($description, config('thrust.translationsDescriptionsPrefix'))) {
            return $description;
        }
        return '';
    }

    public function indexHeader(): ?HtmlString
    {
        return null;
    }

    public function filtersApplied()
    {
        if (! request()->has('filters')) {
            return collect();
        }
        return Filters::decodeFilters(request('filters'));
    }

    public function sortFieldIsValid($sort)
    {
        return $this->fieldsFlattened()->where('sortable', true)->pluck('field')->contains($sort);
    }

    protected function editAndDeleteFields()
    {
        return [Edit::make('edit'), Fields\Delete::make('delete')];

    }

    protected function fetchRows()
    {
        $this->alreadyFetchedRows = $this->isBeingSearched()
            ? $this->query()->limit(static::$maxSearchResults)->get()
            : $this->query()->paginate($this->getPagination())->withQueryString();

        return $this->alreadyFetchedRows;
    }

    protected function getPagination()
    {
        return min(100, request('pagination') ?? $this->pagination);
    }

    public function sortableIsActive()
    {
        return $this->canSort() && (static::$canSaveOrderWhenSorted || ! request('sort'));
    }

    public function getUpdateConfirmationMessage()
    {
        return Translation::useTranslationPrefix($this->updateConfirmationMessage, $this->updateConfirmationMessage);
    }

    public function generateMultipleFields()
    {
        return [];
    }

    public function overlooked(): array
    {
        return $this->overlook;
    }

    public function breadcrumbs(mixed $object): array
    {
        return [$this->getTitle() => route('thrust.index', Thrust::resourceNameFromModel($this))];
    }

    public function onStoreFailed(): void
    {
        $this->fieldsFlattened()->each->onStoreFailed();
    }

    /**
     * @throws ValidationException
     */
    final public function validate(Request $request, string|int|null $id = null): void
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $this->getValidationRules($id));
        $this->withValidator($request, $validator);
        $validator->validate();
    }

    protected function withValidator(Request $request, Validator $validator)
    {
    }

    public function setSearchText(?string $text): self
    {
        $this->searchText = $text;
        return $this;
    }

    public function isBeingSearched(): bool
    {
        return $this->searchText !== null;
    }
}
