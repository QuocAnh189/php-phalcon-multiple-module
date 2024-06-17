{% for user in page.items %}
{% if loop.first %}

<div class="row mb-3">
    <div class="col-xs-12 col-md-6">
        <h2>List users</h2>
    </div>
    <div class="col-xs-12 col-md-6 text-right">
        <div >
            {{ tag.a(url('users/index'), 'Search users', ['class':'btn btn-primary my-2']) }} 
        </div>
        {% if session.get('auth')['role'] == 'admin' %} 
        <div >
            {{ tag.a(url('users/create'), 'Create users', ['class':'btn btn-primary']) }} 
        </div>
        {% endif %}
    </div>
</div>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
{% endif %} 
        <tr>
            <td>{{ user.id }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.role }}</td>
            {% if session.get('auth')['role'] == 'admin' %} 
            <td width="7%">{{ tag.a(url('users/update/' ~ user.id), "<i class=\"glyphicon glyphicon-edit\"></i> Edit", ['class': 'btn btn-default'], true) }}</td>
            <td width="7%">{{ tag.a(url('users/delete/' ~ user.id), "<i class=\"glyphicon glyphicon-remove\"></i> Delete", ['class': 'btn btn-default'], true) }}</td>
            {% endif %}
        </tr>
{% if loop.last %}
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ tag.a(url('users/search'), "<i class=\"icon-fast-backward\"></i> First", ['class': 'btn btn-default'], true) }} 
                    {{ tag.a(url('users/search?page=') ~ page.getPrevious(), "<i class=\"icon-step-backward\"></i> Previous", ['class': 'btn btn-default'], true) }} 
                    {{ tag.a(url('users/search?page=') ~ page.getNext(), "<i class=\"icon-step-forward\"></i> Next", ['class': 'btn btn-default'], true) }} 
                    {{ tag.a(url('users/search?page=') ~ page.getLast(), "<i class=\"icon-fast-forward\"></i> Last", ['class': 'btn btn-default'], true) }} 
                    <span class="help-inline">{{ page.getCurrent() }}/{{ page.getLast() }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No users were found...
{% endfor %}