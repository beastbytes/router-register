# Other Attributes
Other attributes that can be applied to a route or group.

## DefaultValue
Defines a default value for a parameter when the route does not contain a value.

When used on a class it applies to all routes specified in the class.

**Use On**: Class | Action method

**Cardinality**: *
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
            <td>parameter</td>
            <td>string</td>
            <td>Name of the parameter</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>value</td>
            <td>int|string</td>
            <td>The default value</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Fallback
Defines a fallback route that is attempted if no other routes in a group matches.

Only one fallback route is permitted in a group.

**Use On**: Action method

**Cardinality**: ?

## Group
Defines a group.

The prefix defines the name of the group; if not specified, the default group name is used.
Multiple controllers can belong to the same group by using the same group definition.

**Use On**: Class

**Cardinality**: ?
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
            <td>group</td>
            <td>GroupInterface</td>
            <td>
                <p>The group</p>
                <p>
                    Defines the prefixes applied to routes and names in the group; 
                    both can be overridden by the attribute parameters
                </p>
            </td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>prefix</td>
            <td>string</td>
            <td>The prefix applied to all routes in the group</td>
            <td>No</td>
            <td>null</td>
        </tr>
        <tr>
            <td>hosts</td>
            <td>array|string</td>
            <td>The host(s) that this group is valid for</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>cors</td>
            <td>array|string</td>
            <td>CORS middleware</td>
            <td>No</td>
            <td>null</td>
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
            <td>Parent Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
        <tr>
            <td>namePrefix</td>
            <td>string</td>
            <td>The prefix applied to all route names in the group</td>
            <td>No</td>
            <td>null</td>
        </tr>
    </tbody>
</table>

## Host
Defines a host that all routes in a class are valid for.

**Use On**: Class

**Cardinality**: *
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
            <td>host</td>
            <td>string</td>
            <td>The host the route is valid for</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Middleware
Defines a middleware that is applied to all routes in a class.

**Use On**: Class

**Cardinality**: *
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
            <td>middleware</td>
            <td>array|string</td>
            <td>The middleware</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Override
Overrides another route with the same name.

**Use On**: Action method

**Cardinality**: ?

## Prefix
Defines a prefix and a name-prefix that are applied to all routes in a class.

**Use On**: Class

**Cardinality**: ?
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
            <td>name</td>
            <td>?string</td>
            <td>
                <p>The prefix name.</p>
                <p>A shortcut for setting the prefix and name prefix at the same time.</p>
                <p>prefix = '/' . {name}</p>
                <p>namePrefix = {name} . '_'</p>
                <p>The prefix and namePrefix parameters override the shortcut values.</p>
            </td>
            <td>No</td>
            <td>null</td>
        </tr>
        <tr>
            <td>prefix</td>
            <td>?string</td>
            <td>The prefix</td>
            <td>No</td>
            <td>null</td>
        </tr>
        <tr>
            <td>namePrefix</td>
            <td>?string</td>
            <td>The name prefix</td>
            <td>No</td>
            <td>null</td>
        </tr>
    </tbody>
</table>


## Route
Defines a route

**Use On**: Action method

**Cardinality**: ?

> Either Route or one of the [HTTP Methods attributes](HTTP-Methods.md) _must_ be used
{style="note"}
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
            <td>methods</td>
            <td>Method[]</td>
            <td>The HTTP methods that this route responds to</td>
            <td>No</td>
            <td></td>
        </tr>
        <tr>
            <td>route</td>
            <td>RouteInterface</td>
            <td>
                <p>The route</p>
                <p>Defines the route name and URI pattern</p>
            </td>
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
            <td>Parent Middleware not to apply to the route</td>
            <td>No</td>
            <td>[]</td>
        </tr>
    </tbody>
</table>