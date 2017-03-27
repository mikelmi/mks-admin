@if ($field->getNameSce())
    <?php
    $error = 'page.errors[\'' . $field->getNameSce().'\']';
    $errorMsg = '{{' . $error . '[0]}}';
    ?>
    <small class="form-control-feedback" ng-show="{{$error}}">{{$errorMsg}}</small>
@endif