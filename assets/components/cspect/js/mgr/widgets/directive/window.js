cspect.window.Directive = function (config) {
    config = config || {};
    Ext.apply(config, {
        title: config.record.create ? _('cspect.directive_create') : _('cspect.directive_update'),
        url: cspect.config.connectorUrl,
        baseParams: {
            action: config.record.create ? 'CSPect\\Processors\\Directives\\Create' : 'CSPect\\Processors\\Directives\\Update'
        },
        fields: [
            {
                xtype: 'textfield',
                fieldLabel: _('cspect.directive_name'),
                name: 'name',
                anchor: '100%',
                allowBlank: false
            },
            {
                xtype: 'textfield',
                fieldLabel: _('cspect.directive_description'),
                name: 'description',
                anchor: '100%'
            }
        ]
    });
    cspect.window.Directive.superclass.constructor
}
Ext.extend(cspect.window.Directive, MODx.Window);
Ext.reg('cspect-window-directive', cspect.window.Directive);