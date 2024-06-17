<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>Search students</h2>
    </div>
</div>

<form action="{{ url('students/search') }}" role="form" method="post">
{% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
    {{ element }}
    {% else %}

    <div class="form-group">
        {{ element.label() }} 
        <div class="controls">
            {{ element.setAttribute("class", "form-control") }} 
        </div>
    </div>
    {% endif %}
{% endfor %}

    {{ tag.inputSubmit('Search', null, ['class': 'btn btn-primary', 'id': null, 'name': null, 'value': 'Search']) }} 
</form>
