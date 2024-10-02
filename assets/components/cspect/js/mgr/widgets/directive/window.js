cspect.window.Directive = function (config) {
    config = config || {isUpdate: false};
    Ext.apply(config, {
        title: !config.isUpdate ? _('cspect.directive_create') : _('cspect.directive_update'),
        url: cspect.config.connectorUrl,
        baseParams: {
            action: !config.isUpdate ? 'CSPect\\Processors\\Directives\\Create' : 'CSPect\\Processors\\Directives\\Update'
        },
        modal: true,
        autoHeight: true,
        collapsible: false,
        closeAction: 'close',
        fields: [
            {
                xtype: 'cspect-combo-directives',
                fieldLabel: _('cspect.global.name'),
                name: 'name',
                anchor: '100%',
            }/*,
            {
                xtype: 'textfield',
                fieldLabel: _('cspect.global.description_override'),
                name: 'description',
                anchor: '100%'
            }*/
        ]
    });
    cspect.window.Directive.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.Directive, MODx.Window);
Ext.reg('cspect-window-directive', cspect.window.Directive);