<div class="jumbotron">
    <h1>Welcome to UIT Student</h1>
    {% if !session.has('auth') %} 
    <p>{{ tag.a(url('auths/signin'), 'Try it for Free &raquo;', ['class':'btn btn-primary btn-large btn-success'], true) }}</p>
    {% endif %}
    {# <h1>{{ session.get('auth')['role'] }}</h1>  #}
</div>


