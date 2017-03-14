<div class="form-group row" @if($field->getName()) ng-class="{'has-danger':page.errors.{{$field->getName()}}}" @endif>
    <label for="{{$field->getId()}}" class="col-md-2 col-form-label text-md-right @if($field->isRequired()) required @endif">{{$field->getLabel()}}</label>
    <div class="col-md-10">
        {!! $field->renderInput() !!}
        @include('admin::form.field-error-info')
    </div>
</div>