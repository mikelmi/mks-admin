<div class="form-group" @if($field->getName()) ng-class="{'has-danger':page.errors.{{$field->getName()}}}" @endif>
    <label for="{{$field->getId()}}" class="form-control-label @if($field->isRequired()) required @endif">{{$field->getLabel()}}</label>
    {!! $field->renderInput() !!}
    @if ($field->getName())
        <?php
            $error = 'page.errors.' . $field->getName();
            $errorMsg = '{{' . $error . '[0]}}';
        ?>
        <small class="form-control-feedback" ng-show="{{$error}}">{{$errorMsg}}</small>
    @endif
</div>