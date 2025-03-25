<?php

$_lang['cspect.menu'] = 'CSPect';
$_lang['cspect.menu_desc'] = 'Manage your CSP';
$_lang['cspect.manage.page_title'] = 'CSPect';

$_lang['cspect.manage.directive'] = 'Directives';
$_lang['cspect.manage.directive_desc'] = 'Manage your CSP directives';
$_lang['cspect.manage.source'] = 'Sources';
$_lang['cspect.manage.source_desc'] = 'Manage your CSP sources';
$_lang['cspect.manage.violation'] = 'Reports';
$_lang['cspect.manage.violation_desc'] = 'Review CSP violation reports';
$_lang['cspect.manage.context'] = 'Contexts';
$_lang['cspect.manage.context_desc'] = 'Manage your context specific CSP settings';

$_lang['cspect.global.name'] = 'Name';
$_lang['cspect.global.created_on'] = 'Created On';
$_lang['cspect.global.description'] = 'Description';
$_lang['cspect.global.description_override'] = 'Description Override (optional) <small>Defaults to MDN description</small>';
$_lang['cspect.global.default'] = 'Default';
$_lang['cspect.global.rank'] = 'Rank';
$_lang['cspect.global.change_order'] = 'Change Order';
$_lang['cspect.global.remove'] = 'Remove';
$_lang['cspect.global.remove_confirm'] = 'Are you sure you want to remove this item?';
$_lang['cspect.global.url'] = 'URL';
$_lang['cspect.global.search'] = 'Search';
$_lang['cspect.global.clear'] = 'Clear';
$_lang['cspect.global.csp'] = 'Content Security Policy';

$_lang['cspect.combo.empty.directive'] = 'Select a Directive';
$_lang['cspect.combo.empty.source'] = 'Select a Source';

$_lang['cspect.context'] = 'Context';
$_lang['cspect.context.global'] = 'System';
$_lang['cspect.context.global_desc'] = 'Default settings for all contexts. Click on a context tab to override it\'s specific settings.';
$_lang['cspect.context.inherited'] = 'Inherited from Global';
$_lang['cspect.context.export'] = 'Export CSP';

$_lang['cspect.directive'] = 'Directive';
$_lang['cspect.directive_create'] = 'Create Directive';
$_lang['cspect.directive_update'] = 'Update Directive';
$_lang['cspect.directive_remove'] = 'Remove Directive';
$_lang['cspect.directive_remove_confirm'] = 'Are you sure you want to remove this directive?';
$_lang['cspect.directive.child-src'] = 'Child Source';
$_lang['cspect.directive_desc.child-src'] = 'Allows the developer to control nested browsing contexts and worker execution contexts.';
$_lang['cspect.directive.connect-src'] = 'Connect Source';
$_lang['cspect.directive_desc.connect-src'] = 'Provides control over fetch requests, XHR, eventsource, beacon and websockets connections.';
$_lang['cspect.directive.default-src'] = 'Default Source';
$_lang['cspect.directive_desc.default-src'] = 'Serves as a fallback for the other fetch directives.';
$_lang['cspect.directive.font-src'] = 'Font Source';
$_lang['cspect.directive_desc.font-src'] = 'Specifies which URLs to load fonts from.';
$_lang['cspect.directive.frame-src'] = 'Frame Source';
$_lang['cspect.directive_desc.frame-src'] = 'Specifies which URLs can be loaded into nested browsing contexts.';
$_lang['cspect.directive.img-src'] = 'Image Source';
$_lang['cspect.directive_desc.img-src'] = 'Specifies which URLs can be loaded as images.';
$_lang['cspect.directive.manifest-src'] = 'Manifest Source';
$_lang['cspect.directive_desc.manifest-src'] = 'Specifies which URLs can be loaded as a web app manifest.';
$_lang['cspect.directive.media-src'] = 'Media Source';
$_lang['cspect.directive_desc.media-src'] = 'Specifies which URLs can be loaded for audio and video elements.';
$_lang['cspect.directive.object-src'] = 'Object Source';
$_lang['cspect.directive_desc.object-src'] = 'Specifies which URLs can be loaded as plugins.';
$_lang['cspect.directive.prefetch-src'] = 'Prefetch Source';
$_lang['cspect.directive_desc.prefetch-src'] = 'Specifies which URLs can be loaded as a prefetch.';
$_lang['cspect.directive.script-src'] = 'Script Source';
$_lang['cspect.directive_desc.script-src'] = 'Specifies which URLs can be loaded as a script. Acts as the default for the script-src-elem and script-src-attr directives.';
$_lang['cspect.directive.script-src-attr'] = 'Script Source Attribute';
$_lang['cspect.directive_desc.script-src-attr'] = 'Specifies which URLs can be loaded as a script for inline event handlers and event handler content attributes.';
$_lang['cspect.directive.script-src-elem'] = 'Script Source Element';
$_lang['cspect.directive_desc.script-src-elem'] = 'Specifies which URLs can be loaded as a script for inline script elements.';
$_lang['cspect.directive.style-src'] = 'Style Source';
$_lang['cspect.directive_desc.style-src'] = 'Specifies which URLs can be loaded as a stylesheet. Acts as the default for the style-src-elem and style-src-attr directives.';
$_lang['cspect.directive.style-src-attr'] = 'Style Source Attribute';
$_lang['cspect.directive_desc.style-src-attr'] = 'Specifies which URLs can be loaded as a stylesheet for inline style attributes.';
$_lang['cspect.directive.style-src-elem'] = 'Style Source Element';
$_lang['cspect.directive_desc.style-src-elem'] = 'Specifies which URLs can be loaded as a stylesheet for inline style elements.';

$_lang['cspect.source'] = 'Source';
$_lang['cspect.source_create'] = 'Create Source';
$_lang['cspect.source_update'] = 'Update Source';
$_lang['cspect.source_remove'] = 'Remove Source';
$_lang['cspect.source_remove_confirm'] = 'Are you sure you want to remove this source?';

$_lang['cspect.sourcedirective_create.source'] = 'Add Source';
$_lang['cspect.sourcedirective_create.directive'] = 'Add Directive';

$_lang['cspect.context'] = 'Context';
$_lang['cspect.context_update'] = 'Update Context';

$_lang['cspect.sourcecontext'] = 'Source Context';
$_lang['cspect.sourcecontext_create'] = 'Create Source Context';
$_lang['cspect.sourcecontext_create.context'] = 'Add Context';
$_lang['cspect.sourcecontext_create.source'] = 'Add Source';

$_lang['cspect.violation'] = 'Report';
$_lang['cspect.violation.view'] = 'View Report';
$_lang['cspect.violation.age'] = 'Age';
$_lang['cspect.violation.type'] = 'Type';
$_lang['cspect.violation.user_agent'] = 'User Agent';
$_lang['cspect.violation.body'] = 'Body';
$_lang['cspect.violation.directive'] = 'Directive';
$_lang['cspect.violation.blocked'] = 'Blocked';
$_lang['cspect.violation.clear'] = 'Clear Reports';
$_lang['cspect.violation.clear_confirm'] = 'Are you sure you want to clear all reports?';

$_lang['cspect.violation.body.blockedURL'] = 'Blocked';
$_lang['cspect.violation.body.blockedURI'] = 'Blocked';
$_lang['cspect.violation.body.documentURI'] = 'URI';
$_lang['cspect.violation.body.documentURL'] = 'URL';
$_lang['cspect.violation.body.disposition'] = 'Disposition';
$_lang['cspect.violation.body.originalPolicy'] = 'Policy';
$_lang['cspect.violation.body.referrer'] = 'Referrer';
$_lang['cspect.violation.body.effectiveDirective'] = 'Directive';
$_lang['cspect.violation.body.violatedDirective'] = 'Directive';
$_lang['cspect.violation.body.lineNumber'] = 'Line #';
$_lang['cspect.violation.body.columnNumber'] = 'Column #';
$_lang['cspect.violation.body.sample'] = 'Sample';
$_lang['cspect.violation.body.scriptSample'] = 'Sample';
$_lang['cspect.violation.body.sourceFile'] = 'Source';
$_lang['cspect.violation.body.statusCode'] = 'Status';
$_lang['cspect.violation.body.statusMessage'] = 'Message';
$_lang['cspect.violation.auto_fix'] = 'Auto Fix';
$_lang['cspect.violation.auto_fix_confirm'] = 'Are you sure you want to auto fix this report?';
$_lang['cspect.violation.auto_fix_unavailable'] = 'Auto Fix Unavailable';

$_lang['cspect.err.bad_sort_column'] = 'Bad Sort Column!';

$_lang['setting_cspect.report_only'] = 'Report Only';
$_lang['setting_cspect.report_only_desc'] = 'Enable report only mode for CSP headers.';
$_lang['setting_cspect.report_uri'] = 'Report URI';
$_lang['setting_cspect.report_uri_desc'] = 'A fallback URI to use for reporting CSP violations on browsers that don\'t support the report-to interface. e.g. https://example.com/csp-reports';
$_lang['setting_cspect.report_to'] = 'Report To';
$_lang['setting_cspect.report_to_desc'] = 'A directive to specify that a particular defined endpoint should be used for reporting. e.g. csp-endpoint';
$_lang['setting_cspect.reporting_endpoints'] = 'Reporting Endpoints';
$_lang['setting_cspect.reporting_endpoints_desc'] = 'This setting defines one or more endpoint URLs as a comma-separated list. e.g. csp-endpoint="https://example.com/csp-reports"';
$_lang['setting_cspect.default_contexts'] = 'Default Contexts';
$_lang['setting_cspect.default_contexts_desc'] = 'This setting defines one or more default contexts as a comma-separated list to automatically assign a source to when created.';