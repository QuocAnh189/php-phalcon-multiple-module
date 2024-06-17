<div class="page-header">
    <h2>Sign Up</h2>
</div>

<form action="{{ url('auths/signup') }}" id="registerForm" role="form" method="post">
    <fieldset>
        <div class="control-group">
            {{ form.label('username', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('username', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Please enter your username
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('password', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('password', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="password_alert">
                    <strong>Warning!</strong> Please provide a valid password
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="confirmPassword">Confirm Password</label>
            <div class="controls">
                {{ password_field('confirmPassword', 'class': 'form-control') }}
                <div class="alert" id="confirmPassword_alert">
                    <strong>Warning!</strong> The password does not match
                </div>
            </div>
        </div>

         <div class="control-group">
            {{ form.label('role', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('role', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Please enter your role
                </div>
            </div>
        </div>

        <div style="padding:10px" class="form-actions">
            {{ tag.inputSubmit('Register', null, ['class': 'btn btn-primary', 'id': null, 'name': null, 'value': 'Register', 'onclick': 'return SignUp.validate();']) }}
            {{ tag.a(url('auths/signin'), 'Sign In', ['class':'']) }}  
        </div>
    </fieldset>
</form>
