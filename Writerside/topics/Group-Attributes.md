# GroupAttributes
Attributes that define a group.

## Group
Defines the group a controller belongs to.

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
    </tbody>
</table>

## GroupCors
Defines CORS middleware to apply a group.

It is only necessary to define GroupCors in one controller of a group.

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
    </tbody>
</table>

## GroupHost
Defines a host that all routes in a group are valid for.

It is only necessary to define GroupHost in one controller of a group.

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

## GroupMiddleware
Defines a middleware to apply a group or,
if  the `disable` parameter is `true`, a parent group middleware that should not be invoked.

It is only necessary to define GroupMiddleware in one controller of a group.

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

## GroupNamePrefix
Defines a name prefix for a group.

It is only necessary to define GroupNamePrefix in one controller of a group.

If the GroupNamePrefix attribute is not defined, the group name prefix is the group name and separator
which are obtained from the `group` parameter of the `Group` attribute.

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
            <td>namePrefix</td>
            <td>string</td>
            <td>The name prefix.</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>