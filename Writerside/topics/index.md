# About CSPect

CSPect is a tool to manage and maintain your MODX site's Content Security Policies.

## Getting Started

Install the package from your MODX package manager. On first install, CSPect will set up a basic list of sources and
directives for your.

## Usage

### Managing Directives

CSPect starts out by adding a basic list of directives available from [MDN fetch directives](https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Content-Security-Policy#directives)

To add additional directives, go to the "Directives" tab of the CSPect Custom Manager Page, and select "Create Directive"

This will open a popup window allowing you to select a new directive from a list of valid directives: 

![Create Directives Window](create_directive.png)

To edit an existing directive, right-click on the directive in the grid and select "Update Directive"

![Update Directive Action](update_directive.png)

This will take you to the Directive Management page, where you can assign sources.

### Managing Sources

CSPect starts out with a very basic list of sources, including 'self', 'unsafe-inline', 'unsafe-eval', 'data:', and 'blob:'

To add additional sources, go to the "Sources" tab of the CSPect Custom Manager Page, and select "Create Source"

![Create Source Window](create_source.png)

To edit an existing source, right-click on the source in the grid and select "Update Source"

![Update Source Action](update_source.png)

This will take you into the Source Management page. Here you can add/remove directives from a source, or assign contexts
to a source. 

![Manage Source Page](manage_source.png)

### Managing Reports

If you are using the built-in CSP reporting tool, you may receive occasional reports about violations to your CSP. These
are shown in the "Reports" tab of the CSPect Custom Manager Page.

![Reports Grid](reports.png)

To clear reports, you can click the "Clear Reports" button at the top of the grid.

To review a report, right-click and select "View Report".

![View Report](view_report.png)

The view report window will give you detailed information about the cause of a report. From here you can either ignore
the report, or click the "Auto Fix" button if you would like to generate an exception.

The "Auto Fix" button should remove any related reports.


### Managing Contexts

Each context of your site can be configured differently. You can view how contexts are configured in the "Contexts" tab
of the CSPect Custom Manager page. 

![Contexts Tab](contexts.png)

The first tab will be the System Wide defaults. These settings are: 

**Report Only** - Enables report only mode for CSP headers. _(default `Yes`)_ 

**Report URI** - A fallback URI to use for reporting CSP violations on browsers that don't support the report-to interface. e.g. https://example.com/csp-reports _(default `{{cspect.assets_url}}/report.php`)_

**Report To** - A directive to specify that a particular defined endpoint should be used for reporting. e.g. csp-endpoint _(default `cspect`)_

**Reporting Endpoints** - This setting defines one or more endpoint URLs as a comma-separated list. e.g. csp-endpoint="https://example.com/csp-reports" _(default `cspect="{{cspect.assets_url}}/report.php"`)_

For some use cases, you may want to assign your CSP manually using your server. If this is the case, you can click within 
one of the contexts and select "Export" to get the current CSP record for that context. If managing your CSP externally,
we recommend setting your context to "Report Only" or disabling the CSPect Plugin. 

### Additional Settings

CSPect has an additional system setting for assigning default contexts. This is useful if you have multiple contexts that 
are similarly coded. The `cspect.default_contexts` setting is a comma-separated list of context names to assign as default
when creating new sources. By default, it just uses the "web" context.
