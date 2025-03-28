# Contexts

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