# TodoAPI

TodoAPI is a RESTful API built on PHP SlimFramework. GET, POST, PUT and DELETE verbs are used for communication and XML for data structure.

# URI reference

GET /api/v1/tasks               Returns all tasks from the database

GET /api/v1/task/:id            Returns one specific task from the database by :id

POST /api/v1/task               Creates a new task with valid XML data based on the specified structure provided in request body

PUT /api/v1/task/:id            Updates an existing task valid XML data based on the specified structure provided in request body

DELETE /api/v1/task/:id         Deletes a task from the database with an id of :id

**data structures**

All data objects (tasks) for replies and request are made of the following example structure:
    <task>
        <id>1</id>
        <description/>
        <progress>50</progress>
        <link rel="get" href="/api/v1/task/1"/>
        <link rel="delete" href="/api/v1/task/1"/>
        <link rel="put" href="/api/v1/task/1"/>
    </task>

Object collections:
<tasks>
    <task>
        <id>1</id>
        <description/>
        <progress>50</progress>
        <link rel="get" href="/api/v1/task/1"/>
        <link rel="delete" href="/api/v1/task/1"/>
        <link rel="put" href="/api/v1/task/1"/>
    </task>
    <task>
        <id>2</id>
        <description/>
        <progress>100</progress>
        <link rel="get" href="/api/v1/task/2"/>
        <link rel="delete" href="/api/v1/task/2"/>
        <link rel="put" href="/api/v1/task/2"/>
    </task>
</tasks>