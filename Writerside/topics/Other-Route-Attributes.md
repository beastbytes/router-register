# Other Attributes
Other attributes that can be applied to a route.

## DefaultValue
Defines a default value for a parameter when the route does not contain a value.

When used at the class level, it applies to all routes specified in the class.

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
Defines a fallback route that is attempted if no other routes in a group match.

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
    </tbody>
</table>

## Host
Defines a host that all routes in a class are valid for.

When used at the class level, it applies to all routes specified in the class.

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
            <td>host</td>
            <td>string</td>
            <td>The host the route is valid for</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Middleware
Defines a middleware to apply the route or,
if the `disable` parameter is `true`, a parent group or class level middleware that should not be invoked.

When used at the class level, it applies to all routes specified in the class.

_**Note**_: When an action method disables a class level middleware,
no output for the middleware is generated for the action method.

**Use On**: Class | Action method

**See Also** [Defining Middleware Attributes](Defining-Middleware-Attributes.md)

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
            <td>
                <p>The middleware(s)</p>
                <p>
                    An array definition of middleware must use the
                    <a
                        href="https://github.com/yiisoft/definitions#arraydefinition"
                        target="_blank"
                    >
                        Yiisoft\Definitions\ArrayDefinition syntax
                    </a>.
                </p>
                <p>
                    To use a closure as middleware, define it as a string; 
                    strings starting with 'fn' or 'function' are treated as closures.
                </p>
                <p>Example:</p>
                <p><code>
                    'fn (' . MyMiddleware::class . ' $middleware) => $middleware->setValue("' . ValueEnum::acase->value . '")'
                </code></p>
                <p>All other strings are treated "as is".</p>
            </td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>disable</td>
            <td>bool</td>
            <td>Disable the parent group middleware</td>
            <td>No</td>
            <td>false</td>
        </tr>
    </tbody>
</table>

## Override
Overrides another route with the same name.

**Use On**: Action method

**Cardinality**: ?

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
    </tbody>
</table>