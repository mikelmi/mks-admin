<div class="form-group row" @if($field->getNameSce()) ng-class="{'has-danger':page.errors.{{$field->getNameSce()}}}" @endif>
    <label for="{{$field->getId()}}" class="col-md-2 col-form-label text-md-right @if($field->isRequired()) required @endif">{{$field->getLabel()}}</label>
    <div class="col-md-10">
        {!! $field->renderField() !!}
        @include('admin::form.field-error-info')
    </div>
</div>