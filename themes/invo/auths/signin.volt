<div class="row">
    <div class="col-md-6">
        <div class="page-header">
            <h2>Sign In</h2>
        </div>

        <form action="{{ url('auths/signin') }}" role="form" method="post">
            <fieldset>
                <div class="form-group">
                    {{ form.label('username', ['class': 'control-label']) }} 
                    <div class="controls">
                        {{ form.render('username', ['class': 'form-control']) }} 
                    </div>
                </div>
                <div class="form-group">
                    {{ form.label('password', ['class': 'control-label']) }} 
                    <div class="controls">
                        {{ form.render('password', ['class': 'form-control']) }} 
                    </div>
                </div>
                <div class="form-group">
                    {{ tag.inputSubmit('Login', null, ['class': 'btn btn-primary btn-large', 'id': null, 'name': null, 'value': 'Login']) }} 
                    {{ tag.a(url('/auths/signup'), 'Sign Up', ['class':'']) }} 
                </div>
            </fieldset>
        </form>
    </div>
</div>
