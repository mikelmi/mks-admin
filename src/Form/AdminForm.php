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
    const MODE_VIEW = 'view';

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
     * @var array
     */
    protected $alerts = [];

    /**
     * @var string
     */
    protected $editUrl = '';

    /**
     * @var string
     */
    protected $infoUrl = '';

    /**
     * @var string
     */
    protected $previewUrl = '';

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
     * @return bool
     */
    public function isViewMode(): bool
    {
        return $this->mode === self::MODE_VIEW;
    }

    /**
     * @return AdminForm
     */
    public function setupCreateMode()
    {
        return $this->setMode(static::MODE_CREATE);
    }

    /**
     * @return AdminForm
     */
    public function setupEditMode()
    {
        return $this->setMode(static::MODE_EDIT);
    }

    /**
     * @return AdminForm
     */
    public function setupViewMode()
    {
        return $this->setMode(static::MODE_VIEW);
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
        if ($this->isViewMode()) {
            /** @var FieldInterface $field */
            foreach ($this->getFields() as $field) {
                $field->setStatic(true);
            }

            /** @var FormGroup $group */
            foreach ($this->getGroups() as $group) {
                /** @var FieldInterface $field */
                foreach ($group->getFields() as $field) {
                    $field->setStatic(true);
                }
            }

            return '<div '.html_attr($options).'>';
        }

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
        if ($this->isViewMode()) {
            return '</div>';
        }

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

            if (is_callable([$this, $method])) {
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
        $group->setFields($fields);

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

    /**
     * @param string $message
     * @param string $type
     * @param string|null $icon
     * @return AdminForm
     */
    public function alert(string $message, string $type = 'info', string $icon = null): AdminForm
    {
        $this->alerts[$type] = [
            'type' => $type,
            'message' => $message,
            'icon' => $icon,
        ];

        return $this;
    }

    /**
     * @param string $message
     * @param string|null $icon
     * @return AdminForm
     */
    public function alertSuccess(string $message, string $icon = null)
    {
        return $this->alert($message, 'success', $icon);
    }

    /**
     * @param string $message
     * @param string|null $icon
     * @return AdminForm
     */
    public function alertWarning(string $message, string $icon = null)
    {
        return $this->alert($message, 'warning', $icon);
    }

    /**
     * @param string $message
     * @param string|null $icon
     * @return AdminForm
     */
    public function alertError(string $message, string $icon = null)
    {
        return $this->alert($message, 'danger', $icon);
    }

    /**
     * @return bool
     */
    public function hasAlerts(): bool
    {
        return !empty($this->alerts);
    }

    /**
     * @return array
     */
    public function getAlerts(): array
    {
        return $this->alerts;
    }

    /**
     * @return string
     */
    public function getEditUrl(): string
    {
        return $this->editUrl;
    }

    /**
     * @param string $editUrl
     * @return AdminForm
     */
    public function setEditUrl(string $editUrl): AdminForm
    {
        $this->editUrl = $editUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getInfoUrl(): string
    {
        return $this->infoUrl;
    }

    /**
     * @param string $infoUrl
     * @return AdminForm
     */
    public function setInfoUrl(string $infoUrl): AdminForm
    {
        $this->infoUrl = $infoUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreviewUrl(): string
    {
        return $this->previewUrl;
    }

    /**
     * @param string $previewUrl
     * @return AdminForm
     */
    public function setPreviewUrl(string $previewUrl): AdminForm
    {
        $this->previewUrl = $previewUrl;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasModel(): bool
    {
        return false;
    }

    public function isInTrash(): bool
    {
        return false;
    }
}