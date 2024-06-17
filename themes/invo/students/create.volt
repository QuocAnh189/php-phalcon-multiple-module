<form action="{{ url('students/create') }}" role="form" method="post">
    <ul class="pager">
        <li class="previous pull-left">
            {{ tag.a(url('students/search'), '&larr; Go Back', [], true) }} 
        </li>
        <li class="pull-right">
            {{ tag.inputSubmit('Create', 'Create', ['class': 'btn btn-success', 'id':null, 'name':null]) }} 
        </li>
    </ul>

   <h2>Create Student</h2>

    <fieldset>
        {% for element in form %}
            {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }} 
            {% else %} 
                <div class="form-group">
                    {{ element.label() }} 
                    {{ element.render(['class': 'form-control']) }} 
                </div>
            {% endif %}
        {% endfor %} 
    </fieldset>
</form>
