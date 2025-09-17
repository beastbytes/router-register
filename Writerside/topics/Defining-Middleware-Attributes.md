# Defining Middleware Attributes

Middleware to be applied to a route can be defined using Router Register's
[Middleware Attribute](Other-Route-Attributes.md#middleware) or by defining middleware attributes in the application.
Using application defined middleware attributes will make the source code cleaner
and gives IDE code completion and type checking.

As an example, consider middleware to provide access checking
to ensure that the current user has permission to perform the requested action.
If the user does not have permission, the access checker redirects the user to a _safe_ location.

## Access Checker Middleware
The access checker middleware will be something like:
```PHP
final class AccessChecker implements MiddlewareInterface
{
    private ?string $permission = null;
    private ?string $route = null;

    public function __construct(
        private AccessCheckerInterface $accessChecker,
        private CurrentUser $currentUser,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->accessChecker->userHasPermission($this->currentUser->getId(), $this->permission)) {
            return $handler->handle($request);
        }

        return $this
            ->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader(
                Header::LOCATION,
                $this
                    ->urlGenerator
                    ->generate($this->route)
            )
        ;
    }

    public function withPermission(string $permission): self
    {
        $new = clone $this;
        $new->permission = $permission;
        return $new;
    }

    public function withRedirectRoute(string $route): self
    {
        $new = clone $this;
        $new->route = $route;
        return $new;
    }
}
```

## Using the Middleware Attribute
Using the AccessChecker middleware with Router Register's Middleware attribute will look like:
```PHP
final class Secret {
    #[Get(SecretRoute::view)]
    #[Middleware(
        'fn (' . AccessChecker::class . ' $checker) => $checker'
        . "->withPermission('secret.view')"
        . "->withRedirectRoute('safe.location')"
    )]
    public function view(): ResponseInterface
    {
        // Action code
    }
}
```

This works, but the middleware definition is a lot of code, especially if repeated for many actions.

## Defining an Application Middleware Attribute
A better solution is to define an application middleware attribute.

Application middleware attributes must implement
```BeastBytes\Router\Register\Attribute\MiddlewareAttributeInterface```,
which requires that the attribute has a ```getMiddleware()``` method that returns the middleware string.

For the access checker, this will look like:
```PHP
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class AccessCheck implements MiddlewareAttributeInterface
{
    public function __construct(
        private readonly string $permission,
        private readonly string $route,
        private readonly bool $disable = false,
    )
    {
    }

    public function getMiddleware(): string
    {
        return 'fn (' . AccessChecker::class . ' $checker) => $checker'
            . "->withPermission('" . $this->permission . "')"
            . "->withRedirectRoute('" . $this->route . "'')";
        }
    }

    public function getDisable(): bool
    {
        return $this->disable;
    }
}
```

Then, to add the middleware to the route definition:
```PHP
final class Secret {
    #[Get(SecretRoute::view)]
    #[AccessCheck(permission: 'secret.view', route: 'safe.location')]
    public function view(): ResponseInterface
    {
        // Action code
    }
```

Less code, more readable code, more reusable code, and comes with IDE code completion and type checking.
The resulting route definition is the same in both cases.