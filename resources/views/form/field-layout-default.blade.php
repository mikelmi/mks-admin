<div class="form-group" @if($field->getName()) ng-class="{'has-danger':page.errors.{{$field->getName()}}}" @endif>
    <label for="{{$field->getId()}}" class="form-control-label @if($field->isRequired()) required @endif">{{$field->getLabel()}}</label>
    {!! $field->renderInput() !!}
    @include('admin::form.field-error-info')
</div>