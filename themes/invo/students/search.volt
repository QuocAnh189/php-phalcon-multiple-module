{% for student in page.items %}
{% if loop.first %}
<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>List students</h2>
    </div>
    <div class="col-xs-12 col-md-6 text-right">
        <div >
            {{ tag.a(url('students/index'), 'Search students', ['class':'btn btn-primary my-2']) }} 
        </div>
        {% if session.get('auth')['role'] == 'admin' %} 
        <div >
            {{ tag.a(url('students/create'), 'Create students', ['class':'btn btn-primary']) }} 
        </div>
        {% endif %}
        
    </div>
</div>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Code</th>
            <th>Username</th>
            <th>Email</th>
            <th>Department</th>
            <th>Major</th>
        </tr>
    </thead>
    <tbody>
{% endif %} 
        <tr>
            <td>{{ student.code }}</td>
            <td>{{ student.username }}</td>
            <td>{{ student.email }}</td>
            <td>{{ student.department }}</td>
            <td>{{ student.major }}</td>
            {% if session.get('auth')['role'] == 'admin' %} 
            <td width="7%">{{ tag.a(url('students/update/' ~ student.code), "<i class=\"glyphicon glyphicon-edit\"></i> Edit", ['class': 'btn btn-default'], true) }}</td>
            <td width="7%">{{ tag.a(url('students/delete/' ~ student.code), "<i class=\"glyphicon glyphicon-remove\"></i> Delete", ['class': 'btn btn-default'], true) }}</td>
            {% endif %}
        </tr>
{% if loop.last %}
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ tag.a(url('students/search'), "<i class=\"icon-fast-backward\"></i> First", ['class': 'btn btn-default'], true) }} 
                    {{ tag.a(url('students/search?page=') ~ page.getPrevious(), "<i class=\"icon-step-backward\"></i> Previous", ['class': 'btn btn-default'], true) }} 
                    {{ tag.a(url('students/search?page=') ~ page.getNext(), "<i class=\"icon-step-forward\"></i> Next", ['class': 'btn btn-default'], true) }} 
                    {{ tag.a(url('students/search?page=') ~ page.getLast(), "<i class=\"icon-fast-forward\"></i> Last", ['class': 'btn btn-default'], true) }} 
                    <span class="help-inline">{{ page.getCurrent() }}/{{ page.getLast() }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No students were found...
{% endfor %}