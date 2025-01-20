# HTTP Methods

Every route must define the HTTP method(s) it responds to.
This is done using on of the HTTP Method attributes or the [Route attribute](Other-Attributes.md#route).

**Use On:** Action Methods

**Cardinality:** 1

## All
Shortcut for all HTTP methods
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Delete
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Get
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Head
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Options
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Patch
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Post
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>
## Put
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
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this route is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>middleware</td>
            <td>array|callable|string</td>
            <td>Middleware to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>disabledMiddleware</td>
            <td>array|callable|string</td>
            <td>Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>