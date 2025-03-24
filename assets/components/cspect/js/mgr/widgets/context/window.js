cspect.window.ContextExport = function (config) {
    config = config || {};
    config.exportData = config.exportData || '';
    Ext.applyIf(config, {
        title: _('cspect.context.export'),
        cls: 'cspect-window-context-export',
        width: 400,
        autoHeight: true,
        modal: true,
        layout: 'anchor',
        items: [
            {
                xtype: "displayfield",
                value: config.exportData
            }
        ]
    });
    cspect.window.ContextExport.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.ContextExport, Ext.Window);
Ext.reg('cspect-window-context-export', cspect.window.ContextExport);