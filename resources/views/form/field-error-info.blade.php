@if ($field->getName())
    <?php
    $error = 'page.errors.' . $field->getName();
    $errorMsg = '{{' . $error . '[0]}}';
    ?>
    <small class="form-control-feedback" ng-show="{{$error}}">{{$errorMsg}}</small>
@endif