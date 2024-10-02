cspect.window.Source = function (config) {
    config = config || {isUpdate: false};
    Ext.apply(config, {
        title: !config.isUpdate ? _('cspect.source_create') : _('cspect.source_update'),
        url: cspect.config.connectorUrl,
        baseParams: {
            action: !config.isUpdate ? 'CSPect\\Processors\\Sources\\Create' : 'CSPect\\Processors\\Sources\\Update'
        },
        modal: true,
        autoHeight: true,
        collapsible: false,
        closeAction: 'close',
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
    cspect.window.Source.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.Source, MODx.Window);
Ext.reg('cspect-window-source', cspect.window.Source);