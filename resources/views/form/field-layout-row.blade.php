<div class="form-group row" @if($field->getName()) ng-class="{'has-danger':page.errors.{{$field->getName()}}}" @endif>
    <label for="{{$field->getId()}}" class="col-sm-2 col-form-label @if($field->isRequired()) required @endif">{{$field->getLabel()}}</label>
    <div class="col-sm-10">
        {!! $field->renderInput() !!}
        @if ($field->getName())
            <?php
            $error = 'page.errors.' . $field->getName();
            $errorMsg = '{{' . $error . '[0]}}';
            ?>
            <small class="form-control-feedback" ng-show="{{$error}}">{{$errorMsg}}</small>
        @endif
    </div>
</div>