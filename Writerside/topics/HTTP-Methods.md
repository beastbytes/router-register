# HTTP Method Attributes
Every route must define the HTTP method(s) it responds to.
This is done using on of the HTTP Method attributes or the [Route attribute](Other-Attributes.md#route).

There is an attribute for each HTTP method, and two convenience attributes:
`All` for all HTTP methods
and `GetPost` for routes that submit forms
where the first request is a `GET` to display the form and the second is a `POST` to submit the form. 

* **All** — Convenience attribute for all HTTP methods
* **Delete**
* **Get**
* **GetPost** — Convenience attribute for GET and POST HTTP methods
* **Head**
* **Options**
* **Patch**
* **Post**
* **Put**

**Use On:** Action Methods

**Cardinality:** 1

All HTTP method attributes take one parameter:
<table>
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Type</th>
            <th>Description</th>
            <th>Required</th>
            <th>Default</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>route</td>
            <td>RouteInterface</td>
            <td>The route</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>