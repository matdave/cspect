cspect.window.Source = function (config) {
    config = config || {};
    Ext.apply(config, {
        title: config.record.create ? _('cspect.source_create') : _('cspect.source_update'),
        url: cspect.config.connectorUrl,
        baseParams: {
            action: config.record.create ? 'CSPect\\Processors\\Sources\\Create' : 'CSPect\\Processors\\Sources\\Update'
        },
        fields: [
            {
                xtype: 'textfield',
                fieldLabel: _('cspect.source_name'),
                name: 'name',
                anchor: '100%',
                allowBlank: false
            }
        ]
    });
    cspect.window.Source.superclass.constructor
}
Ext.extend(cspect.window.Source, MODx.Window);
Ext.reg('cspect-window-source', cspect.window.Source);