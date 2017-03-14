<div class="form-group row">
    <label for="{{$field->getId()}}" class="col-md-2 col-form-label text-md-right">{{$field->getLabel()}}</label>
    <div class="col-md-10">
        <div class="mt-md-1">
            <label class="form-check-label">
                {!! $field->renderInput() !!}
            </label>
        </div>
    </div>
</div>