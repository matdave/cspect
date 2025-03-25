cspect.window.ContextExport = function (config) {
    config = config || {};
    config.exportData = config.exportData || '';
    Ext.applyIf(config, {
        title: _('cspect.context.export'),
        width: 800,
        autoHeight: true,
        modal: true,
        maximizable: true,
        shadow: true,
        layout: 'form',
        cls: 'modx-window',
        anchor: '100% 100%',
        labelAlign: 'top',
        defaults: {
            hideLabel: false,
            anchor: '100%',
        },
        items: [
            {
                fieldLabel: _('cspect.global.csp'),
                xtype: "displayfield",
                html: config.exportData,
                autoScroll: true,
            },
            {
                fieldLabel: _('settings_cspect.reporting_endpoints'),
                xtype: "displayfield",
                html: config.endpoints,
                autoScroll: true,
            }
        ]
    });
    cspect.window.ContextExport.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.ContextExport, Ext.Window);
Ext.reg('cspect-window-context-export', cspect.window.ContextExport);