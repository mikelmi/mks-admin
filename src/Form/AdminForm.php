<?php
/**
 * Author: mike
 * Date: 12.03.17
 * Time: 22:35
 */

namespace Mikelmi\MksAdmin\Form;


use Backpack\Base\app\Http\Middleware\Admin;
use Illuminate\Support\Collection;

class AdminForm
{
    const MODE_CREATE = 'create';
    const MODE_EDIT = 'edit';

    private static $layout;

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $action = '';

    /**
     * @var string
     */
    private $backUrl = '';

    /**
     * @var string;
     */
    private $newUrl = '';

    /**
     * @var string
     */
    private $deleteUrl = '';

    /**
     * @var string
     */
    private $mode = self::MODE_CREATE;

    /**
     * @var Collection
     */
    private $breadcrumbs;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var Collection
     */
    protected $groups;

    /**
     * @var FormGroup
     */
    protected $mainGroup;

    /**
     * AdminForm constructor.
     */
    public function __construct()
    {
        $this->breadcrumbs = collect();
        $this->groups = collect();

        $this->mainGroup = new FormGroup('-default-');
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        if (!$this->title) {
            switch ($this->mode) {
                case self::MODE_CREATE: $this->title = __('admin::messages.Create');
                    break;
                case self::MODE_EDIT: $this->title = __('admin::messages.Edit');
                    break;
            }
        }

        return $this->title;
    }

    /**
     * @param string $title
     * @return AdminForm
     */
    public function setTitle(string $title): AdminForm
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return AdminForm
     */
    public function setAction(string $action): AdminForm
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->backUrl;
    }

    /**
     * @param string $backUrl
     * @return AdminForm
     */
    public function setBackUrl(string $backUrl): AdminForm
    {
        $this->backUrl = $backUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewUrl(): string
    {
        return $this->newUrl;
    }

    /**
     * @param string $newUrl
     * @return AdminForm
     */
    public function setNewUrl(string $newUrl): AdminForm
    {
        $this->newUrl = $newUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->deleteUrl;
    }

    /**
     * @param string $deleteUrl
     * @return AdminForm
     */
    public function setDeleteUrl(string $deleteUrl): AdminForm
    {
        $this->deleteUrl = $deleteUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return AdminForm
     */
    public function setMode(string $mode): AdminForm
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @param string $title
     * @param string|null $url
     * @return $this
     */
    public function addBreadCrumb(string $title, string $url = null)
    {
        $this->breadcrumbs->push(['title' => $title, 'url' => $url]);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBreadcrumbs(): bool
    {
        return $this->breadcrumbs->isNotEmpty();
    }

    /**
     * @return Collection
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    /**
     * @return bool
     */
    public function isEditMode(): bool
    {
        return $this->mode === self::MODE_EDIT;
    }

    /**
     * @return bool
     */
    public function isCreateMode(): bool
    {
        return $this->mode === self::MODE_CREATE;
    }

    /**
     * @return Collection
     */
    public function getFields(): Collection
    {
        return $this->mainGroup->getFields();
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return AdminForm
     */
    public function setOptions(array $options): AdminForm
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return AdminForm
     */
    public function setOption(string $key, $value): AdminForm
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @param array $options
     * @return string
     */
    public function open(array $options = []): string
    {
        $attr = array_merge($this->options, $options);

        $attr['method'] = array_get($attr, 'method', 'post');
        $attr['action'] = array_get($attr, 'action', $this->getAction());
        $attr['mks-form'] = null;

        return '<form '.html_attr($attr).'>';
    }

    /**
     * @return string
     */
    public function close(): string
    {
        return '</form>';
    }

    /**
     * @param FieldInterface|array $field
     * @param array $options
     * @return AdminForm
     */
    public function addField($field, array $options = []): AdminForm
    {
        if (is_array($field)) {
            $group = array_get(array_merge($field, $options), 'group');
        } else {
            $group = array_pull($options, 'group');
        }

        $this->group($group)->addField($field, $options);

        return $this;
    }

    /**
     * @param array $fields
     * @return AdminForm
     */
    public function setFields(array $fields): AdminForm
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * @param null $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function response($view = null, array $data = [])
    {
        return view($view ?: 'admin::form.admin-form', ['form' => $this], $data);
    }

    /**
     * @param array $options
     * @return static
     */
    public static function make(array $options = [])
    {
        $form = new static();

        $form->build($options);

        return $form;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function build(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (!is_string($key) || strtolower($key) === 'options') {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public static function getLayout(): string
    {
        if (!isset(self::$layout)) {
            self::$layout = config('admin.form.layout', 'default');
        }

        return self::$layout;
    }

    /**
     * @param string $layout
     */
    public static function setLayout(string $layout)
    {
        self::$layout = $layout;
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        static $setActiveGroup;

        if (!isset($setActiveGroup)) {
            if ($this->hasGroups()) {
                $activate = true;

                foreach ($this->groups as $group) {
                    if ($group->isActive()) {
                        $activate = false;
                        break;
                    }
                }

                if ($activate) {
                    $this->groups->first()->setActive(true);
                }
            }
            $setActiveGroup = true;
        }

        return $this->groups;
    }

    /**
     * @param array $groups
     * @return AdminForm
     */
    public function setGroups(array $groups): AdminForm
    {
        foreach ($groups as $group) {
            $this->addGroup($group);
        }

        return $this;
    }

    /**
     * @param array|string|FormGroup $data
     * @param array $options
     * @return AdminForm
     */
    public function addGroup($data, array $options = []): AdminForm
    {
        $group = FormGroupFactory::make($data, $options, false);

        if (is_array($data)) {
            $fields = array_get(array_merge($data, $options), 'fields');
        } else {
            $fields = array_get($options, 'fields');
        }

        if ($fields) {
            $this->setGroupFields($group, $fields);
        }

        $this->groups->put($group->getId(), $group);

        return $this;
    }

    /**
     * @param FormGroup $group
     * @param array $fields
     * @return $this
     */
    protected function setGroupFields(FormGroup $group, array $fields = [])
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasGroup($id): bool
    {
        return $this->groups->has($id);
    }

    /**
     * @return bool
     */
    public function hasGroups(): bool
    {
        return $this->groups->isNotEmpty();
    }

    /**
     * @param $id
     * @return FormGroup
     */
    public function group($id): FormGroup
    {
        return $this->groups->get($id, $this->mainGroup);
    }
}