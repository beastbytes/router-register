# Parameter Attributes
If a route has parameters, use parameter attributes to specify the matching patterns.

**Use On:** Action Methods

**Cardinality:** *

## Alpha
Parameter contains alphabetic characters
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>length</td>
            <td>array|int|null</td>
            <td><dl>
                    <dt>array &ndash; list{0: ?int, 1: ?int}</dt>
                    <dd>The minimum and maximum number of characters.
                        Set minimum null to specify only a maximum,
                        and maximum null to specify only a minimum.</dd>
                    <dt>int</dt>
                    <dd>The number of characters</dd>
                    <dt>null</dt>
                    <dd>Any length</dd>
                </dl>
            </td>
            <td>No</td>
            <td>null (any length)</td>
        </tr>
        <tr>
            <td>case</td>
            <td>AlphaCase</td>
            <td>Whether the characters must be lowercase, uppercase, or can be either</td>
            <td>No</td>
            <td>AlphaCase::insensitive</td>
        </tr>
    </tbody>
</table>

## AlphaNumeric
Parameter contains alphabetic characters and digits
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>length</td>
            <td>array|int|null</td>
            <td><dl>
                    <dt>array &ndash; list{0: ?int, 1: ?int}</dt>
                    <dd>The minimum and maximum number of characters.
                        Set minimum null to specify only a maximum,
                        and maximum null to specify only a minimum.</dd>
                    <dt>int</dt>
                    <dd>The number of characters</dd>
                    <dt>null</dt>
                    <dd>Any length</dd>
                </dl>
            </td>
            <td>No</td>
            <td>null (any length)</td>
        </tr>
        <tr>
            <td>case</td>
            <td>AlphaCase</td>
            <td>Whether the characters must be lowercase, uppercase, or can be either</td>
            <td>No</td>
            <td>AlphaCase::insensitive</td>
        </tr>
    </tbody>
</table>

## Hex
Parameter contains hexadecimal characters
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>length</td>
            <td>array|int|null</td>
            <td><dl>
                    <dt>array &ndash; list{0: ?int, 1: ?int}</dt>
                    <dd>The minimum and maximum number of characters.
                        Set minimum null to specify only a maximum,
                        and maximum null to specify only a minimum.</dd>
                    <dt>int</dt>
                    <dd>The number of characters</dd>
                    <dt>null</dt>
                    <dd>Any length</dd>
                </dl>
            </td>
            <td>No</td>
            <td>null (any length)</td>
        </tr>
        <tr>
            <td>case</td>
            <td>AlphaCase</td>
            <td>Whether the characters must be lowercase, uppercase, or can be either</td>
            <td>No</td>
            <td>AlphaCase::insensitive</td>
        </tr>
    </tbody>
</table>

## Id
Parameter is number with a minimum value of 1; e.g. database autoincrement value
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## In
Parameter must be on of the provided options
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>options</td>
            <td>string[]</td>
            <td>Options to match</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Numeric
Parameter contains numeric digits
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>length</td>
            <td>array|int|null</td>
            <td><dl>
                    <dt>array &ndash; list{0: ?int, 1: ?int}</dt>
                    <dd>The minimum and maximum number of characters.
                        Set minimum null to specify only a maximum,
                        and maximum null to specify only a minimum.</dd>
                    <dt>int</dt>
                    <dd>The number of characters</dd>
                    <dt>null</dt>
                    <dd>Any length</dd>
                </dl>
            </td>
            <td>No</td>
            <td>null (any length)</td>
        </tr>
        <tr>
            <td>nonZero</td>
            <td>bool</td>
            <td>Whether the number must be non-zero</td>
            <td>No</td>
            <td>false (zero is allowed)</td>
        </tr>
    </tbody>
</table>

## Parameter
Specifies the pattern the parameter must match
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>pattern</td>
            <td>string</td>
            <td>Regex to match</td>
            <td>Yes</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Uuid
Parameter is a Universally Unique Identifier (aka Globally Unique Identifier (GUID))
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
            <td>string</td>
            <td>Parameter name</td>
            <td>Yes</td>
            <td></td>
        </tr>
        <tr>
            <td>case</td>
            <td>AlphaCase</td>
            <td>Whether the characters must be lowercase, uppercase, or can be either</td>
            <td>No</td>
            <td>AlphaCase::insensitive</td>
        </tr>
    </tbody>
</table>

# DefaultValue
Specifies a default value to use if a parameter is not specified in the URL

**Use On:** Action Methods

**Cardinality:** *

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
            <td>string</td>
            <td>Parameter name</td>
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

# AlphaCase
AlphaCase is an enum that specifies the case of alphabetic characters; the enumerations are:

* AlphaCase::insensitive — characters can be lowercase or uppercase
* AlphaCase::lower — characters must be lowercase
* AlphaCase::upper — characters must be uppercase