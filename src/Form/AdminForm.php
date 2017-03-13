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
     * @var Collection
     */
    private $fields;

    /**
     * @var array
     */
    private $options = [];

    /**
     * AdminForm constructor.
     */
    public function __construct()
    {
        $this->breadcrumbs = collect();
        $this->fields = collect();
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
        return $this->fields;
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
        $this->fields = collect();

        return '</form>';
    }

    /**
     * @param Field|array $field
     * @param array $options
     * @return AdminForm
     */
    public function addField($field, array $options = []): AdminForm
    {
        if (!$field instanceof Field) {
            if (!is_array($field)) {
                throw new \InvalidArgumentException("$field should be an array or instance of Field");
            }

            $type = array_pull($field, 'type');
            $this->fields->push(Field::make($type, $options));
        } else {
            if ($options) {
                $field->applySetters($options);
            }

            $this->fields->push($field);
        }

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
            self::$layout = config('admin::form.layout', 'default');
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
}