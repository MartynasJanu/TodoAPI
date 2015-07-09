# TodoAPI

TodoAPI is a RESTful API built on PHP SlimFramework.

# URI reference

GET /api/v1/tasks               Returns all tasks from the database

GET /api/v1/task/:id            Returns one specific task from the database by :id

POST /api/v1/task               Creates a new task with XML data provided in POST body

PUT /api/v1/task/:id            Updates an existing task XML with data provided in POST body

DELETE /api/v1/task/:id         Deletes a task from the database with an id of :id