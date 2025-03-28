# About CSPect

CSPect is a tool to manage and maintain your MODX site's Content Security Policies.

### What is a CSP

A CSP, or Content Security Policy, is a security feature implemented by web browsers to  control resource
requests made by a browser on your site. 

A CSP consists of two primary parts, the Directives and the Sources (or values) allowed within those directives.

#### Directives

Directives are a definition of the _type_ of request made by the browser from the site. For example, an iFrame
on your site will follow the "frame-src" directive if one exists, or fallback to the "default-src" directive.

#### Sources

Sources are a definition of the allowed values within a directive. Using the iFrame example again, if you define that
your "frame-src" directive only allows frames with the source "example.com" then the browser will block any requests
on your site for iFrames with the src "elpmaxe.com".

### How does CSPect Work

CSPect starts out by adding a basic list of directives available from [MDN fetch directives](https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Content-Security-Policy#directives)

With these directives you are able to add allowed sources per context. If something on your site fails the CSP
the browser will block the request and send a new report to the built-in reporting endpoint.

You can use the built-in reporting endpoint to automatically add new entries to your CSP.

## Usage

### Managing Directives

Lean how to [manage directives here.](Directives.md)

### Managing Sources

Lean how to [manage sources here.](Sources.md)

### Managing Reports

Lean how to [manage reports here.](Reports.md)

### Managing Contexts

Lean how to [manage contexts here.](Contexts.md)

### Additional System Settings

CSPect has an additional system setting for assigning default contexts. This is useful if you have multiple contexts that 
are similarly coded. The `cspect.default_contexts` setting is a comma-separated list of context names to assign as default
when creating new sources. By default, it just uses the "web" context.
